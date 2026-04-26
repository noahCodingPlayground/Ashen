<?php

function crawl($url, &$visited, &$results, $base) {
    if (isset($visited[$url])) return;
    $visited[$url] = true;

    $html = @file_get_contents($url);
    if ($html === false) return;

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();

    $links = $dom->getElementsByTagName('a');

    foreach ($links as $link) {
        $href = $link->getAttribute('href');

        if ($href === "../" || $href === "./") continue;

        $full = rtrim($url, '/') . '/' . ltrim($href, '/');

        if (str_starts_with($href, '?') || str_contains($href, '#')) continue;

        if (str_ends_with($href, '/')) {
            $relative = str_replace($base, '', $full);
            $relative = trim($relative, '/');
            if ($relative !== '') {
                $results[] = $relative;
            }
            crawl($full, $visited, $results, $base);
        }
    }
}

$start = "/ashen/games/a3/";
$visited = [];
$results = [];

crawl($start, $visited, $results, $start);

echo json_encode(["games" => array_values(array_unique($results))], JSON_PRETTY_PRINT);

?>