{!! '<'.'?xml version="1.0" encoding="UTF-8"?'.'>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach($rows as $row)
<url><loc>{{ $row['url'] }}</loc>@if($row['updated'])<lastmod>{{ $row['updated'] }}</lastmod>@endif
@foreach($row['alternates'] as $language => $alternate)
<xhtml:link rel="alternate" hreflang="{{ $language }}" href="{{ $alternate }}" />
@endforeach
<xhtml:link rel="alternate" hreflang="x-default" href="{{ $row['alternates']['ru'] }}" />
</url>
@endforeach
</urlset>
