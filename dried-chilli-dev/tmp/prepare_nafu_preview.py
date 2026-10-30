from pathlib import Path
from urllib.parse import unquote
import re, json

root = Path(__file__).resolve().parents[1]
for path in (root / 'public/assets/nafu').iterdir():
    if '%' in path.name: path.rename(path.with_name(unquote(path.name)))
for name in ('nafu-home-sections','nafu-footer'):
    path = root / f'resources/views/frontend/layouts/partials/{name}.blade.php'
    text = unquote(path.read_text(encoding='utf-8'))
    text = re.sub(r'\sdata-turnstile-sitekey="[^"]*"','',text)
    text = text.replace('><','>\n<')
    path.write_text(text,encoding='utf-8')

css_path = root / 'public/assets/nafu/mrfix-home2.css'
css = css_path.read_text(encoding='utf-8')
urls = list(dict.fromkeys(re.findall(r'url\((https:[^)]+)\)',css)))
assets = []
for url in urls:
    name = unquote(url.split('/')[-1])
    css = css.replace(url,'./'+name)
    assets.append({'url':url,'path':'assets/nafu/'+name})
css_path.write_text(css,encoding='utf-8')
(root/'tmp/nafu-background-assets.json').write_text(json.dumps(assets),encoding='utf-8')

home = (root / 'resources/views/home.blade.php').read_text(encoding='utf-8')
header = (root / 'resources/views/frontend/layouts/partials/header.blade.php').read_text(encoding='utf-8-sig')
sections = (root / 'resources/views/frontend/layouts/partials/nafu-home-sections.blade.php').read_text(encoding='utf-8')
footer = (root / 'resources/views/frontend/layouts/partials/nafu-footer.blade.php').read_text(encoding='utf-8')
body = home.split("@section('full-content')",1)[1].rsplit('@endsection',1)[0]
body = body.replace("@include('frontend.layouts.partials.nafu-home-sections')", sections)
body = re.sub(r'(?s)@php.*?@endphp','',body)
copy = dict(re.findall(r"'([a-z_0-9]+)'\s*=>\s*'([^']*)'",home.split('@endphp',1)[0]))
def render(text):
    text = re.sub(r'(?s)@php.*?@endphp', '', text)
    text = text.replace('{{ $nafuFooterHome }}', '')
    text = re.sub(r"\{\{\s*request\(\)->routeIs\('home'\)\s*\?\s*'([^']*)'.*?\}\}", lambda m:m[1], text)
    text = text.replace('{{ date("Y") }}', '2026')
    text = text.replace("{{ $locale === 'vi' ? 'Khác' : 'Other' }}", 'Other')
    text = re.sub(r"\{\{\s*asset\('([^']+)'\)\s*\}\}",lambda m:'/'+m[1],text)
    text = re.sub(r"\{!!\s*\$homeSetting\('([^']+)'[^)]*\)\s*!!\}",lambda m:copy.get(m[1],'Done'),text)
    text = text.replace('@csrf','')
    text = re.sub(r'(?s)\{\{.*?\}\}', '#', text)
    return text
styles = re.search(r"@push\('styles'\)(.*?)@endpush",home,re.S)[1]
preview = '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Nafu Home Care — Full preview</title><link rel="stylesheet" href="/assets/css/feb-header.css"><link rel="stylesheet" href="/assets/css/feb-footer.css">'+render(styles)+'</head><body class="home-page">'+render(header+body+footer)+'</body></html>'
(root/'public/nafu-banner-preview.html').write_text(preview,encoding='utf-8')
print('Background assets:',len(assets),'Preview updated')
