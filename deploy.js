/**
 * Stridewel International - Live FTP Deployment Automation Script
 * Automates syncing of project files to cPanel live hosting.
 *
 * Usage:
 *   node deploy.js            # Run full deployment
 *   node deploy.js --dry-run  # List files to be deployed without uploading
 */

const ftp = require("basic-ftp");
const path = require("path");
const fs = require("fs");

// Load local .env if present (ignored by git)
const envPath = path.join(__dirname, ".env");
if (fs.existsSync(envPath)) {
    const envLines = fs.readFileSync(envPath, "utf8").split(/\r?\n/);
    for (const line of envLines) {
        const match = line.match(/^\s*([\w.-]+)\s*=\s*(.*)?\s*$/);
        if (match) {
            const key = match[1];
            let value = (match[2] || "").trim();
            if (value.startsWith('"') && value.endsWith('"')) value = value.slice(1, -1);
            if (value.startsWith("'") && value.endsWith("'")) value = value.slice(1, -1);
            if (!process.env[key]) process.env[key] = value;
        }
    }
}

// FTP Configuration
const config = {
    host: process.env.FTP_HOST || process.env.FTP_SERVER || "stridewel.com",
    port: parseInt(process.env.FTP_PORT || "21", 10),
    user: process.env.FTP_USER || process.env.FTP_USERNAME || "strid@stridewel.com",
    password: process.env.FTP_PASSWORD || "",
    secure: false, // Standard FTP with passive mode on cPanel
    remoteRoot: "/"
};

const isDryRun = process.argv.includes("--dry-run");

// Directories and file patterns to ignore
const IGNORE_DIRS = new Set([
    ".git",
    ".github",
    "node_modules",
    "scratch",
    ".gemini",
    ".agents",
    ".system_generated",
    ".idea",
    ".vscode",
    "extracted_products",
    "cat_extracted",
    "catalog_pages",
    "pdf_extracted"
]);

const IGNORE_FILES = new Set([
    "package.json",
    "package-lock.json",
    "deploy.js",
    "test_ftp.php",
    "test_new_ftp.php",
    "test_cdup.php",
    "test_ftp_web.php",
    "test_cpanel_user.php",
    "probe_ftp.php",
    "probe_urls.php",
    ".DS_Store",
    "Thumbs.db",
    "desktop.ini"
]);

function shouldIgnore(relativePath, isDir) {
    const parts = relativePath.split(path.sep);
    for (const part of parts) {
        if (IGNORE_DIRS.has(part)) return true;
    }
    const fileName = parts[parts.length - 1];
    if (IGNORE_FILES.has(fileName)) return true;
    if (fileName.startsWith("test_") && fileName.endsWith(".php")) return true;
    if (fileName.endsWith(".log") || fileName.endsWith(".tmp") || fileName.endsWith(".bak")) return true;
    return false;
}

function getAllLocalFiles(dir, baseDir = dir) {
    let results = [];
    const list = fs.readdirSync(dir);
    for (const file of list) {
        const fullPath = path.join(dir, file);
        const relPath = path.relative(baseDir, fullPath);
        const stat = fs.statSync(fullPath);

        if (stat.isDirectory()) {
            if (!shouldIgnore(relPath, true)) {
                results = results.concat(getAllLocalFiles(fullPath, baseDir));
            }
        } else {
            if (!shouldIgnore(relPath, false)) {
                results.push({
                    fullPath,
                    relPath: relPath.replace(/\\/g, "/"),
                    size: stat.size
                });
            }
        }
    }
    return results;
}

async function deploy() {
    console.log("==================================================");
    console.log("🚀 Stridewel International - Live Website Deployer");
    console.log("==================================================");
    console.log(`🌐 Target Host  : ${config.host}:${config.port}`);
    console.log(`👤 User         : ${config.user}`);
    console.log(`📂 Remote Path  : ${config.remoteRoot}`);
    console.log(`⚙️  Mode         : ${isDryRun ? "DRY RUN (Preview Only)" : "LIVE SYNC"}`);
    console.log("--------------------------------------------------");

    const localFiles = getAllLocalFiles(__dirname);
    console.log(`📦 Found ${localFiles.length} files to sync.\n`);

    if (isDryRun) {
        console.log("📋 Files scheduled for upload:");
        localFiles.forEach(f => console.log(`  - ${f.relPath} (${(f.size / 1024).toFixed(1)} KB)`));
        console.log("\n✅ Dry run completed successfully. No remote files modified.");
        return;
    }

    const client = new ftp.Client(30000);
    // client.ftp.verbose = true;

    try {
        console.log("⏳ Connecting to FTP server...");
        await client.access({
            host: config.host,
            port: config.port,
            user: config.user,
            password: config.password,
            secure: config.secure
        });
        console.log("✅ Authenticated successfully!\n");

        await client.cd(config.remoteRoot);

        // Upload files with progress
        let uploaded = 0;
        const total = localFiles.length;
        const startTime = Date.now();

        for (const file of localFiles) {
            uploaded++;
            const remoteFilePath = file.relPath;
            const remoteDir = path.posix.dirname(remoteFilePath);

            if (remoteDir && remoteDir !== ".") {
                await client.ensureDir(remoteDir);
                await client.cd(config.remoteRoot);
            }

            const percent = Math.round((uploaded / total) * 100);
            process.stdout.write(`\r[${uploaded}/${total}] (${percent}%) 📤 ${file.relPath} ... `);

            await client.uploadFrom(file.fullPath, remoteFilePath);
            process.stdout.write("Done!\n");
        }

        // Clean up temporary test files if they exist on remote
        try {
            await client.remove("live_test.txt");
            await client.remove("test_deploy.txt");
        } catch (e) {
            // Ignore if missing
        }

        const duration = ((Date.now() - startTime) / 1000).toFixed(1);
        console.log("\n==================================================");
        console.log(`🎉 Deployment Complete!`);
        console.log(`⏱️  Total Time : ${duration} seconds`);
        console.log(`📄 Files Uploaded: ${uploaded}`);
        console.log(`🔗 Live URL   : https://${config.host}/`);
        console.log("==================================================");

    } catch (err) {
        console.error("\n❌ Deployment failed with error:", err.message);
        process.exit(1);
    } finally {
        client.close();
    }
}

deploy();
