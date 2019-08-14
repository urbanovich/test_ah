<?php

namespace TestAH\Helpers;

class ParserHtml
{

    public static function parse($html)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

        $finder = new \DomXPath($dom);
        $nodes = $finder->query('//body/*');
        $images = $finder->query('//img');
        $movedImage = null;
        foreach ($images as $image) {
            $movedImage = $image;
            $image->parentNode->removeChild($image);
        }

        $middle = (int)($nodes->count() / 2);
        $leftBlock = new \DOMDocument();
        $rightBlock = new \DOMDocument();
        foreach ($nodes as $key => $node) {
            if ($node instanceof \DOMElement) {
                if ($key <= $middle) {
                    $node = $leftBlock->importNode($node, true);
                    $leftBlock->appendChild($node);
                } else {

                    if (($key - 1) == $middle && !is_null($movedImage)) {
                        $image = $rightBlock->importNode($movedImage, true);
                        $rightBlock->appendChild($image);
                    }
                    $node = $rightBlock->importNode($node, true);
                    $rightBlock->appendChild($node);
                }
            }
        }

        return [
            'left' => $leftBlock->saveHTML(),
            'right' => $rightBlock->saveHTML(),
        ];
    }
}