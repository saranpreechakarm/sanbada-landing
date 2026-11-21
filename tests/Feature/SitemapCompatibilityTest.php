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

    public function test_schema_context_is_emitted_as_json_instead_of_a_blade_directive(): void
    {
        $html = view('seo.head', ['seo' => [
            'title' => 'Sanbada', 'description' => 'Property in Phuket',
            'canonical' => 'https://realestate.sanbadathai.com/en',
            'alternates' => [], 'image' => 'https://realestate.sanbadathai.com/image.webp',
            'schema' => [['@type' => 'WebPage']],
        ]])->render();
        $this->assertSame(1, preg_match('~<script type="application/ld\+json">(.*?)</script>~s', $html, $matches));
        $schema = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
        $this->assertSame('https://schema.org', $schema['@context']);
        $this->assertSame('WebPage', $schema['@graph'][0]['@type']);
        $this->assertStringNotContainsString('<?php', $matches[1]);
    }
}
