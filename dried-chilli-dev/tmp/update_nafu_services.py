from pathlib import Path
import re
root = Path(__file__).resolve().parents[1]
p = root / 'resources/views/frontend/layouts/partials/nafu-home-sections.blade.php'
s = p.read_text(encoding='utf-8')
s = re.sub(r'<section class="service-1-section.*?</section>', "@include('frontend.layouts.partials.nafu-services')", s, count=1, flags=re.S)
p.write_text(s, encoding='utf-8')
p = root / 'resources/views/home.blade.php'
s = p.read_text(encoding='utf-8')
s = re.sub(r'<option value="general-repairs">.*?</option><option value="electrical">.*?</option>', "@foreach(config('nafu-services') as $slug => $service)\n                                <option value=\"{{ $slug }}\">{{ $service['name'] }}</option>\n                            @endforeach", s)
s = s.replace('nafu-home.js\')}}?v=20260918-2', 'nafu-home.js\')}}?v=20260918-3')
s = s.replace('nafu-home.js\') }}?v=20260918-2', 'nafu-home.js\') }}?v=20260918-3')
p.write_text(s, encoding='utf-8')
p = root / 'resources/views/frontend/layouts/partials/nafu-footer.blade.php'
s = p.read_text(encoding='utf-8')
start = s.index('<ul role="list" class="footer-nav-list">', s.index('Our services'))
end = s.index('</ul>', start) + len('</ul>')
s = s[:start] + '''<ul role="list" class="footer-nav-list">
@foreach(config('nafu-services') as $service)
<li class="footer-nav-list-item">
<a href="{{ $nafuFooterHome }}#home-services" class="footer-nav-list-list">{{ $service['name'] }}</a>
</li>
@endforeach
</ul>''' + s[end:]
p.write_text(s, encoding='utf-8')
p = root / 'app/Http/Requests/StoreContactRequest.php'
s = p.read_text(encoding='utf-8').replace("'in:business-website,ecommerce,custom-web-app,booking-system,general-repairs,plumbing,electrical,other'", "\\Illuminate\\Validation\\Rule::in(array_merge(array_keys(config('nafu-services')), ['business-website', 'ecommerce', 'custom-web-app', 'booking-system', 'general-repairs', 'plumbing', 'electrical', 'other']))")
p.write_text(s, encoding='utf-8')
p = root / 'public/assets/nafu/nafu-home.js'
s = p.read_text(encoding='utf-8').replace("dialog.close(); document.querySelector('.site-header .talk-button.js-open-contact')?.click(); });", "dialog.close(); document.querySelector('.site-header .talk-button.js-open-contact')?.click(); const type = document.querySelector('#contact-project-type'); if (type && card.dataset.serviceSlug) type.value = card.dataset.serviceSlug; });")
p.write_text(s, encoding='utf-8')
p = root / 'tmp/check_nafu_contact.php'
s = p.read_text(encoding='utf-8').replace("['general-repairs', 'plumbing', 'electrical', 'other']", "array_merge(array_keys(config('nafu-services')), ['general-repairs', 'plumbing', 'electrical', 'other'])")
p.write_text(s, encoding='utf-8')
icons = {
 'repairs': '<path d="M29 6a11 11 0 0 0-14 14L5 30a5 5 0 0 0 7 7l10-10A11 11 0 0 0 36 13l-7 7-7-7z"/>',
 'painting': '<rect x="5" y="5" width="27" height="12" rx="3"/><path d="M32 10h7v13H19v6"/><rect x="15" y="29" width="8" height="14" rx="2"/>',
 'flooring': '<path d="M5 7h38v34H5zM5 18h38M5 30h38M18 7v11M31 18v12M18 30v11"/>',
 'handover': '<path d="m4 23 20-17 20 17M10 19v23h28V19M19 42V29h10v13"/><path d="m18 22 4 4 8-9"/>',
 'property': '<path d="M7 43V5h25v38M32 18h9v25M3 43h42M14 12h3m7 0h2M14 20h3m7 0h2M14 28h3m7 0h2M17 43v-8h7v8"/>',
}
for name, paths in icons.items():
 (root / f'public/assets/nafu/service-{name}.svg').write_text(f'<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">{paths}</svg>', encoding='utf-8')
preview = (root / 'tmp/preview_nafu_blog.php').read_text(encoding='utf-8').split('$samples =')[0].replace('/en/news', '/en').replace("'{locale}/news'", "'{locale}'").replace("name('news.index')", "name('home')")
preview += '''$html = view('home')->render();
if (substr_count($html, 'data-service-slug=') !== 5) throw new RuntimeException('Expected five Nafu services');
foreach (config('nafu-services') as $slug => $service) {
    if (!str_contains($html, 'value="' . $slug . '"')) throw new RuntimeException('Missing enquiry option');
}
file_put_contents(__DIR__ . '/../public/nafu-banner-preview.html', $html);
echo "Homepage rendered with five Nafu services and matching enquiry options.\\n";
'''
(root / 'tmp/preview_nafu_home.php').write_text(preview, encoding='utf-8')
