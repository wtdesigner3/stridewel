<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/function.php';

header('Content-Type: application/xml; charset=utf-8');

$baseUrl = rtrim(SITE_URL, '/');
$allProducts = get_all_products();
$allBlogs = get_blogs();

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Core Pages -->
    <url>
        <loc><?= $baseUrl ?>/</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/about</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/products</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/faq</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/blog</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/contact</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Dynamic Product Pages (36 Items) -->
    <?php foreach ($allProducts as $p): ?>
    <url>
        <loc><?= $baseUrl ?>/<?= e($p['category_slug'] ?? 'guns-sheaths') ?>/<?= urlencode($p['slug']) ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($p['updated_at'] ?? 'now')) ?></lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <?php endforeach; ?>

    <!-- Dynamic Blog Articles -->
    <?php foreach ($allBlogs as $b): ?>
    <url>
        <loc><?= $baseUrl ?>/blog/<?= urlencode($b['slug'] ?? ('article-' . $b['id'])) ?></loc>
        <lastmod><?= date('Y-m-d', strtotime($b['updated_at'] ?? $b['created_at'] ?? 'now')) ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
</urlset>
