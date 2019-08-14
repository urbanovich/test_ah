<?php

namespace TestAH\Helpers;

class ParserHtml
{

    public static function parse($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        /*$finder = new \DomXPath($dom);
        $nodes = $finder->query('//div[@class="frame-image"]');*/
    }
}