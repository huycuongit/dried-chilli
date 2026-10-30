from pathlib import Path
from lxml import html
import re, json, hashlib

root = Path(__file__).resolve().parents[1]
doc = html.parse(str(root / 'tmp/mrfix-home2.html'))
sections = doc.xpath('//body//section')
selected = []
started = False
for section in sections:
    if 'about-1-section' in section.get('class', '').split(): started = True
    if started: selected.append(section)
    if section.get('id') == 'Footer': break
assets = {}
def asset(url):
    if not url.startswith('https://cdn.prod.website-files.com/'): return url
    name = url.split('/')[-1].split('?')[0]
    local = 'assets/nafu/' + name
    assets[url] = local
    return "{{ asset('" + local + "') }}"

for section in selected:
    for el in section.iter():
        for attr in list(el.attrib):
            if attr.startswith('data-w') or attr == 'srcset' or attr == 'sizes': el.attrib.pop(attr)
        if el.get('style'):
            style = re.sub(r'(?:^|;)(?:opacity|(?:-\w+-)?transform|transform-style):[^;]*', '', el.get('style'))
            if style.strip(';'): el.set('style', style)
            else: el.attrib.pop('style')
        if el.get('src'): el.set('src', asset(el.get('src')))
        if el.tag == 'a':
            url = el.get('href', '')
            if url.startswith('tel:') or url.startswith('mailto:'):
                el.set('href', '#contact-modal'); el.set('class', el.get('class','') + ' js-open-contact')
            elif url == '/contact-us':
                el.set('href', '#contact-modal'); el.set('class', el.get('class','') + ' js-open-contact')
            elif url == '/about-us': el.set('href', '#about')
            elif url.startswith('/services'): el.set('href', '#home-services')
            elif url.startswith('/project'): el.set('href', '#home-projects')
            elif url.startswith('/blog'): el.set('href', '#home-blog')
            elif url == '/': el.set('href', '#top')
            elif url.startswith('/') or 'mrfix' in url or 'webflow' in url or 'themetechmount' in url:
                el.set('href', '#contact-modal'); el.set('class', el.get('class','') + ' js-open-contact')
            elif url.startswith('https:'):
                el.set('href', '#contact-modal'); el.set('class', el.get('class','') + ' js-open-contact'); el.attrib.pop('target',None)
        if el.tag == 'form':
            for attr in ('action','method','data-name','name'): el.attrib.pop(attr,None)
            el.set('class', el.get('class','') + ' nafu-newsletter-form')
            for inp in el.xpath('.//input'):
                if inp.get('type') == 'email': inp.set('required','required')
    for el in section.xpath('.//*[contains(concat(" ",normalize-space(@class)," ")," w-form-done ") or contains(concat(" ",normalize-space(@class)," ")," w-form-fail ")]'): el.set('hidden','hidden')

ids = {'about-1-section':'about','service-1-section':'home-services','project-1-section':'home-projects','pricing-section':'home-pricing','blog-1-section':'home-blog'}
for section in selected:
    for cls, ident in ids.items():
        if cls in section.get('class','').split(): section.set('id',ident)

footer = selected.pop()
footer.set('class', footer.get('class','') + ' nafu-footer')
logo = footer.xpath('.//img[contains(@class,"footer-logo")]')[0]
brand = html.fragment_fromstring('<a class="nafu-footer-brand" href="#top">Nafu<span>HOME CARE</span></a>')
logo.getparent().replace(logo, brand)
for node in footer.xpath('.//*[contains(@class,"copyright-text")]'):
    node.clear(); node.set('class','copyright-text'); node.text = '© {{ date("Y") }} Nafu Home Care. All rights reserved.'
for node in footer.xpath('.//*[contains(@class,"footer-bottom-text")]'):
    node.clear(); node.set('class','footer-bottom-text'); node.text = 'Home care'
for node in footer.xpath('.//*[contains(@class,"footer-contact-address-text")]'): node.text = 'Nafu Home Care — Here for your home'
for node in footer.xpath('.//a[contains(@class,"footer-contact-link")]'):
    node.text = 'Get in touch' if 'call-link' in node.get('class','') else 'Talk to Nafu Home Care'
for node in footer.xpath('.//*[contains(@class,"footer-title-2")]'):
    if 'Utility' in node.text_content(): node.text = 'Our services'
utility = footer.xpath('.//a[contains(@href,"contact-modal") and contains(@class,"footer-nav-list-list")]')
for node, text in zip(utility, ['Contact us','General repairs','Plumbing','Electrical work','Home improvements','Request a quote','Contact our team','Facebook','Twitter','Behance','Dribbble','Instagram']):
    node.text = text

# Keep the original layout and write original Nafu copy into placeholder paragraphs.
for section in selected:
    for p in section.xpath('.//p'):
        if 'Lorem' in p.text_content():
            p.text = 'Reliable repairs, thoughtful improvements and quality workmanship. Nafu Home Care makes looking after your home simple, from the first conversation to the final detail.'
            for child in list(p): p.remove(child)
    for node in section.xpath('.//*[contains(@class,"pretitle-text")]'):
        if '120,000' in node.text_content(): node.text = 'Care that fits your home'
    for node in section.xpath('.//*[contains(@class,"pricing-list-item-text")]'):
        if 'Venenatis' in node.text_content() or 'Sem quis' in node.text_content(): node.text = 'Clear quotes and dependable workmanship'

serialize = lambda nodes: '\n'.join(html.tostring(x,encoding='unicode',method='html') for x in nodes)
partial = root / 'resources/views/frontend/layouts/partials/nafu-home-sections.blade.php'
partial.write_text('<div class="nafu-home-content">\n' + serialize(selected) + '\n</div>',encoding='utf-8')
(root / 'resources/views/frontend/layouts/partials/nafu-footer.blade.php').write_text(serialize([footer]),encoding='utf-8')
home_path = root / 'resources/views/home.blade.php'
home = home_path.read_text(encoding='utf-8-sig')
start = home.index('        <section class="work-wall"')
end = home.index('    <div class="contact-modal"',start)
home = home[:start] + "        @include('frontend.layouts.partials.nafu-home-sections')\n    </main>\n" + home[end:]
# The booking selector no longer depends on the removed FEB service cards.
home = home.replace('            @foreach ($serviceCards as $service)\n                                <option value="{{ $service[\'slug\'] }}">{{ $locale === \'vi\' ? $service[\'name_vi\'] : $service[\'name\'] }}</option>\n                            @endforeach', '<option value="general-repairs">General repairs & maintenance</option><option value="plumbing">Plumbing fixes & installations</option><option value="electrical">Electrical repairs & upgrades</option>')
# Remove legacy organization schema and floating FEB contacts.
start = home.index('    @php\n        $contactEmail')
end = home.index('    <script>\n        (() => {',start)
home = home[:start] + home[end:]
home = home.replace('<span class="contact-modal__eyebrow">FEB</span>', '<span class="contact-modal__eyebrow">NAFU HOME CARE</span>')
home = home.replace('FEB will get back to you shortly.', 'Nafu Home Care will get back to you shortly.')
home = home.replace('    <link rel="stylesheet" href="{{ asset(\'assets/css/feb-hero.css\') }}?v=20260918-2">', '''    <link rel="stylesheet" href="{{ asset('assets/nafu/mrfix-home2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/feb-hero.css') }}?v=20260918-3">
    <link rel="stylesheet" href="{{ asset('assets/css/nafu-home.css') }}?v=20260918-1">''')
home_path.write_text(home,encoding='utf-8')
css_url = doc.xpath('//link[@rel="stylesheet"]/@href')[0]
assets[css_url] = 'assets/nafu/mrfix-home2.css'
(root / 'tmp/nafu-assets.json').write_text(json.dumps([{'url':u,'path':p} for u,p in assets.items()]),encoding='utf-8')
print('Sections:', [x.get('class') for x in selected], 'Assets:',len(assets))
