<?php
/**
 * Stridewel International - Dynamic SEO Meta & Social Tags Include
 */

if (!isset($page_slug)) {
    $page_slug = 'home';
}
if (!isset($custom_seo)) {
    $custom_seo = ['page_slug' => $page_slug];
} else {
    $custom_seo['page_slug'] = $page_slug;
}

echo render_seo_meta($custom_seo);
?>
