<?php

namespace Tests\Feature;

use Tests\TestCase;

class SitemapCompatibilityTest extends TestCase
{
    public function test_sitemap_xml_declaration_renders_with_host_php_settings(): void
    {
        $xml = view('seo.sitemap', ['rows' => [[
            'url' => 'https://realestate.sanbadathai.com/en',
            'updated' => null,
            'alternates' => [
                'en' => 'https://realestate.sanbadathai.com/en',
                'ru' => 'https://realestate.sanbadathai.com/ru',
            ],
        ]]])->render();

        $this->assertStringStartsWith('<?xml version="1.0" encoding="UTF-8"?>', $xml);
        $document = new \DOMDocument;
        $this->assertTrue($document->loadXML($xml));
        $this->assertSame(1, $document->getElementsByTagName('url')->length);
    }
}
