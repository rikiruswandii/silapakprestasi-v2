<?php

use Symfony\Component\DomCrawler\Crawler;

/**
 * Tabler icon
 * @param string $key
 * @param array $class
 * @return string
 */
function tabler_icon($key = 'home', $class = [])
{
    if (!file_exists(WRITEPATH . 'data/tabler-icons.json')) {
        return '';
    }

    $icons = file_get_contents(WRITEPATH . 'data/tabler-icons.json');
    $icons = json_decode($icons);

    $icon = array_filter($icons, function ($icon) use ($key) {
        return $icon->name === $key;
    });
    $icon = array_shift($icon);

    $crawler = new Crawler($icon->svg);
    $crawler->filter('svg')->each(function ($node) use ($class) {
        $node->getNode(0)->setAttribute('class', implode(' ', ['icon', ...$class]));
    });

    $svg = $crawler->html();
    return $svg;
}
