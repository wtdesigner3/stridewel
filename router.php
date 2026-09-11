<?php
/**
 * Stridewel International - Built-in Development Server Router
 * Enables clean URLs: /about, /contact, /products, and /{category-slug}/{product-slug}
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = trim(urldecode($uri), '/');

// 1. If path contains assets/ or uploads/, resolve to real root asset path
if (preg_match('#(assets|uploads)/.+$#i', $path, $asset_match)) {
    $real_asset = __DIR__ . '/' . $asset_match[0];
    if (file_exists($real_asset) && !is_dir($real_asset)) {
        $ext = strtolower(pathinfo($real_asset, PATHINFO_EXTENSION));
        $mimes = [
            'css'   => 'text/css; charset=UTF-8',
            'js'    => 'application/javascript; charset=UTF-8',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'webp'  => 'image/webp',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+xml',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'eot'   => 'application/vnd.ms-fontobject',
            'pdf'   => 'application/pdf',
            'mp4'   => 'video/mp4'
        ];
        if (isset($mimes[$ext])) {
            header('Content-Type: ' . $mimes[$ext]);
        }
        readfile($real_asset);
        exit;
    }
}

// 2. Serve any direct root static file
$direct_file = __DIR__ . '/' . $path;
if (!empty($path) && file_exists($direct_file) && !is_dir($direct_file)) {
    $ext = strtolower(pathinfo($direct_file, PATHINFO_EXTENSION));
    $mimes = [
        'css'   => 'text/css; charset=UTF-8',
        'js'    => 'application/javascript; charset=UTF-8',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'webp'  => 'image/webp',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        'pdf'   => 'application/pdf',
        'xml'   => 'application/xml; charset=UTF-8',
        'json'  => 'application/json; charset=UTF-8'
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
        readfile($direct_file);
        exit;
    }
    return false;
}

// 3. Main Page Routes
if ($path === 'index' || $path === 'index.php' || $path === 'home') {
    header("Location: /", true, 301);
    exit;
}

if ($path === '') {
    require __DIR__ . '/index.php';
    exit;
}

if ($path === 'about' || $path === 'about.php') {
    require __DIR__ . '/about.php';
    exit;
}

if ($path === 'contact' || $path === 'contact.php') {
    require __DIR__ . '/contact.php';
    exit;
}

if ($path === 'faq' || $path === 'faq.php') {
    require __DIR__ . '/faq.php';
    exit;
}

if ($path === 'catalog' || $path === 'download-catalog' || $path === 'catalogue' || $path === 'download-catalogue') {
    $pdf = __DIR__ . '/uploads/catalog/stridewel_catalog_1789024165.pdf';
    if (file_exists($pdf)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="Stridewel_Product_Catalogue.pdf"');
        readfile($pdf);
        exit;
    }
}

if ($path === 'sitemap' || $path === 'sitemap.xml' || $path === 'sitemap.php') {
    require __DIR__ . '/sitemap.php';
    exit;
}

if ($path === 'submit-inquiry' || $path === 'submit-inquiry.php') {
    require __DIR__ . '/submit-inquiry.php';
    exit;
}

// 4. Blog Listing & Details
if ($path === 'blog' || $path === 'blogs' || $path === 'blog.php') {
    require __DIR__ . '/blog.php';
    exit;
}

if (preg_match('#^blog/([a-zA-Z0-9_-]+)$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/blog-details.php';
    exit;
}

if ($path === 'blog-details' || $path === 'blog-details.php') {
    require __DIR__ . '/blog-details.php';
    exit;
}

// 5. Products Listing & Category Filter
if ($path === 'products' || $path === 'shop' || $path === 'shop.php') {
    require __DIR__ . '/shop.php';
    exit;
}

if (preg_match('#^products/([a-zA-Z0-9_-]+)$#', $path, $m)) {
    $_GET['cat'] = $m[1];
    require __DIR__ . '/shop.php';
    exit;
}

// 6. Product Detail by Category/Product: /{category-slug}/{product-slug}
if (preg_match('#^([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)$#', $path, $m)) {
    // Avoid routing if first segment is a real folder like admin, assets, inc, etc.
    if (!in_array($m[1], ['admin', 'assets', 'inc', 'includes', 'uploads', 'scratch'])) {
        $_GET['cat'] = $m[1];
        $_GET['slug'] = $m[2];
        require __DIR__ . '/shop-details.php';
        exit;
    }
}

// 7. Product Detail Aliases
if (preg_match('#^product/([a-zA-Z0-9_-]+)$#', $path, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/shop-details.php';
    exit;
}

if ($path === 'shop-details' || $path === 'shop-details.php') {
    require __DIR__ . '/shop-details.php';
    exit;
}

// 8. Generic Extensionless PHP Routing Fallback
if (file_exists(__DIR__ . '/' . $path . '.php')) {
    require __DIR__ . '/' . $path . '.php';
    exit;
}

// 9. Admin subpath fallback
if (strpos($path, 'admin/') === 0) {
    $admin_file = __DIR__ . '/' . $path;
    if (file_exists($admin_file . '.php')) {
        require $admin_file . '.php';
        exit;
    }
}

// 10. If looking for a static asset extension that doesn't exist, return 404
if (preg_match('#\.(css|js|png|jpg|jpeg|webp|gif|svg|ico|woff|woff2|ttf|eot|pdf)$#i', $path)) {
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

// Default fallback
require __DIR__ . '/index.php';

