from pathlib import Path
import re
root = Path(__file__).resolve().parents[1]
p = root / 'resources/views/frontend/layouts/partials/nafu-home-sections.blade.php'
s = p.read_text(encoding='utf-8')
s = re.sub(r'<section class="blog-1-section.*?</section>', "@include('frontend.layouts.partials.nafu-home-blog')", s, count=1, flags=re.S)
p.write_text(s, encoding='utf-8')
p = root / 'resources/views/home.blade.php'
s = p.read_text(encoding='utf-8').replace('nafu-home.js\') }}?v=20260918-4', 'nafu-home.js\') }}?v=20260918-5')
p.write_text(s, encoding='utf-8')
p = root / 'public/assets/css/nafu-blog.css'
s = p.read_text(encoding='utf-8')
s += '''
.home-page .nafu-blog-card-link{display:block;height:100%;color:#fff}.home-page .blog-1-content-block,.home-page .blog-1-btn-block{pointer-events:none}.home-page .blog-1-item-block:focus-within .blog-1-btn-block{opacity:1}.home-page .nafu-blog-card-link:focus-visible{outline:3px solid #333f23;outline-offset:5px}
.nafu-blog-page .blog-rich-text h2,.nafu-blog-page .blog-rich-text h3{font-family:Sora,Arial,sans-serif}.nafu-blog-page .blog-rich-text h2{font-size:38px;line-height:1.3}.nafu-blog-page .blog-rich-text p{font-size:16px;line-height:1.7}.nafu-blog-page .blog-rich-text img{max-width:100%;height:auto}.nafu-blog-page .blog-rich-text{overflow-wrap:anywhere}.nafu-news-back{display:inline-block;margin-top:40px;color:#333f23;font-weight:600}.nafu-blog-page .blog-desc-image{object-fit:cover}
@media(max-width:480px){.nafu-blog-page .blog-rich-text h2{font-size:28px}.nafu-blog-page .blog-single-meta-block{flex-wrap:wrap}.nafu-blog-page .blog-rich-text table{display:block;overflow-x:auto}}
'''
p.write_text(s, encoding='utf-8')
# Home cards use the same presentation styles as the blog list.
p = root / 'resources/views/home.blade.php'
s = p.read_text(encoding='utf-8')
needle = "<link rel=\"stylesheet\" href=\"{{ asset('assets/css/nafu-home.css') }}"
idx = s.index(needle)
end = s.index('>', idx) + 1
s = s[:end] + '\n    <link rel="stylesheet" href="{{ asset(\'assets/css/nafu-blog.css\') }}?v=20260918-2">' + s[end:]
p.write_text(s, encoding='utf-8')
