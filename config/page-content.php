<?php

$field = fn ($label, $en, $vi, $type = null) => array_filter(compact('label', 'en', 'vi', 'type'));

return [
    'shared' => [
        'label' => 'Dùng chung',
        'prefix' => 'page_shared',
        'sections' => [
            'Header' => [
                'nav_projects' => $field('Menu dự án', 'Joined Projects', 'Dự án đã tham gia'),
                'nav_services' => $field('Menu dịch vụ', 'Services', 'Dịch vụ'),
                'nav_news' => $field('Menu tin tức', 'News', 'Bài viết'),
                'nav_contact' => $field('Nút liên hệ', "Let's talk", 'Liên hệ'),
            ],
            'Footer' => [
                'footer_description' => $field('Mô tả', 'Focused web experiences that turn ideas into useful products.', 'Trải nghiệm web tập trung, biến ý tưởng thành sản phẩm hữu ích.', 'textarea'),
                'footer_eyebrow' => $field('Nhãn CTA', 'HAVE A PROJECT IN MIND?', 'BẠN ĐANG CÓ MỘT DỰ ÁN?'),
                'footer_title' => $field('Tiêu đề CTA', 'Let’s build a website<br>that feels <em>different.</em>', 'Hãy tạo nên một website<br>thật <em>khác biệt.</em>', 'textarea'),
                'footer_button' => $field('Nút CTA', 'Start a project ↗', 'Bắt đầu dự án ↗'),
                'footer_copyright' => $field('Copyright', '© {year} NAFU Services.', '© {year} NAFU Services.'),
            ],
        ],
    ],
    'home' => [
        'label' => 'Home',
        'prefix' => 'home',
        'sections' => require __DIR__ . '/homepage.php',
    ],
    'services' => [
        'label' => 'Services',
        'prefix' => 'page_services',
        'sections' => [
            'SEO & Hero' => [
                'seo_title' => $field('SEO title', 'NAFU Services Services — Websites and digital products built for growth', 'Dịch vụ NAFU Services — Website và sản phẩm số cho tăng trưởng'),
                'seo_description' => $field('SEO description', "Explore FEB's website, e-commerce, custom web application and booking system services.", 'Khám phá các dịch vụ website, thương mại điện tử, web app và hệ thống đặt lịch của NAFU.', 'textarea'),
                'seo_keywords' => $field('SEO keywords', 'web design services, e-commerce development, custom web apps, booking systems', 'dịch vụ thiết kế website, thương mại điện tử, web app, hệ thống đặt lịch', 'textarea'),
                'hero_eyebrow' => $field('Nhãn Hero', 'WHAT WE DO', 'FEB LÀM GÌ'),
                'hero_title' => $field('Tiêu đề Hero', 'Digital services built<br>around <em>your growth.</em>', 'Dịch vụ số được xây dựng<br>xoay quanh <em>sự tăng trưởng.</em>', 'textarea'),
                'hero_description' => $field('Mô tả Hero', 'From the first idea to a reliable product, NAFU combines strategy, design and development to create digital experiences that work for your business.', 'Từ ý tưởng đầu tiên đến một sản phẩm đáng tin cậy, NAFU kết hợp chiến lược, thiết kế và phát triển để tạo ra trải nghiệm số hiệu quả cho doanh nghiệp.', 'textarea'),
            ],
            'Danh sách & CTA' => [
                'list_title' => $field('Nhãn danh sách', 'ALL SERVICES', 'TẤT CẢ DỊCH VỤ'),
                'card_label' => $field('Nhãn trên card', 'NAFU SERVICE', 'DỊCH VỤ FEB'),
                'empty_title' => $field('Tiêu đề khi trống', 'No services yet.', 'Chưa có dịch vụ.'),
                'empty_description' => $field('Mô tả khi trống', 'FEB services will appear here soon.', 'Các dịch vụ của NAFU sẽ sớm xuất hiện tại đây.'),
                'cta_eyebrow' => $field('Nhãn CTA', 'HAVE SOMETHING IN MIND?', 'BẠN ĐANG CÓ Ý TƯỞNG?'),
                'cta_title' => $field('Tiêu đề CTA', 'Not sure which service fits?<br><em>Let’s figure it out together.</em>', 'Chưa chắc dịch vụ nào phù hợp?<br><em>Hãy cùng nhau tìm câu trả lời.</em>', 'textarea'),
                'cta_button' => $field('Nút CTA', 'Book a call ↗', 'Đặt lịch trao đổi ↗'),
            ],
        ],
    ],
    'service_detail' => [
        'label' => 'Service Detail',
        'prefix' => 'page_service_detail',
        'sections' => [
            'SEO & Banner' => [
                'seo_suffix' => $field('Hậu tố SEO title', 'NAFU Services Services', 'Dịch vụ NAFU Services'),
                'meta_fallback' => $field('SEO description mặc định', 'A focused digital service designed and developed by NAFU.', 'Dịch vụ số được NAFU thiết kế và phát triển theo mục tiêu cụ thể.', 'textarea'),
                'back' => $field('Quay lại danh sách', '← All services', '← Tất cả dịch vụ'),
                'eyebrow' => $field('Nhãn dịch vụ', 'NAFU SERVICE', 'DỊCH VỤ FEB'),
            ],
            'Giới thiệu' => [
                'overview_eyebrow' => $field('Nhãn giới thiệu', 'BUILT AROUND YOUR BUSINESS', 'XÂY DỰNG CHO DOANH NGHIỆP'),
                'overview_title' => $field('Tiêu đề giới thiệu', 'Strategy, design and technology<br>working as <em>one.</em>', 'Chiến lược, thiết kế và công nghệ<br>vận hành như <em>một thể thống nhất.</em>', 'textarea'),
                'overview_description' => $field('Mô tả giới thiệu', 'We shape every engagement around real business goals, clear user journeys and a technical foundation that can evolve over time.', 'Mỗi dự án được xây dựng quanh mục tiêu kinh doanh thực tế, hành trình người dùng rõ ràng và nền tảng kỹ thuật có thể phát triển lâu dài.', 'textarea'),
            ],
            'Giá trị bàn giao' => [
                'feature_1_title' => $field('Giá trị 1 - Tiêu đề', 'Clear direction', 'Định hướng rõ ràng'),
                'feature_1_description' => $field('Giá trị 1 - Mô tả', 'A focused roadmap built around priorities, users and measurable outcomes.', 'Lộ trình tập trung vào ưu tiên, người dùng và kết quả có thể đo lường.', 'textarea'),
                'feature_2_title' => $field('Giá trị 2 - Tiêu đề', 'Thoughtful experience', 'Trải nghiệm chỉn chu'),
                'feature_2_description' => $field('Giá trị 2 - Mô tả', 'Interfaces that feel natural, communicate clearly and strengthen your brand.', 'Giao diện tự nhiên, truyền tải rõ ràng và củng cố hình ảnh thương hiệu.', 'textarea'),
                'feature_3_title' => $field('Giá trị 3 - Tiêu đề', 'Built to evolve', 'Sẵn sàng phát triển'),
                'feature_3_description' => $field('Giá trị 3 - Mô tả', 'Reliable technology and a maintainable foundation ready for future growth.', 'Công nghệ tin cậy và nền tảng dễ bảo trì, sẵn sàng cho tăng trưởng tương lai.', 'textarea'),
            ],
            'CTA' => [
                'cta_eyebrow' => $field('Nhãn CTA', 'READY WHEN YOU ARE', 'SẴN SÀNG KHI BẠN SẴN SÀNG'),
                'cta_title' => $field('Tiêu đề CTA', 'Let’s turn this service into<br><em>your next advantage.</em>', 'Hãy biến dịch vụ này thành<br><em>lợi thế tiếp theo của bạn.</em>', 'textarea'),
                'cta_button' => $field('Nút CTA', 'Start your project ↗', 'Bắt đầu dự án ↗'),
            ],
        ],
    ],    'projects' => [
        'label' => 'Projects',
        'prefix' => 'page_projects',
        'sections' => [
            'SEO & Hero' => [
                'seo_title' => $field('SEO title', 'NAFU Services Projects — Selected digital products and websites', 'Dự án NAFU Services — Website và sản phẩm số tiêu biểu'),
                'seo_description' => $field('SEO description', 'Explore websites, platforms and digital products designed and developed by NAFU.', 'Khám phá các website, nền tảng và sản phẩm số do NAFU thiết kế và phát triển.', 'textarea'),
                'seo_keywords' => $field('SEO keywords', 'FEB projects, website portfolio, digital products, web platforms', 'dự án NAFU, portfolio website, sản phẩm số, nền tảng web', 'textarea'),
                'hero_eyebrow' => $field('Nhãn Hero', 'SELECTED WORK', 'DỰ ÁN TIÊU BIỂU'),
                'hero_title' => $field('Tiêu đề Hero', 'Digital products built<br>to <em>move businesses.</em>', 'Sản phẩm số được xây dựng<br>để <em>thúc đẩy doanh nghiệp.</em>', 'textarea'),
                'hero_description' => $field('Mô tả Hero', 'A selection of websites and web platforms shaped around clear goals, useful experiences and sustainable growth.', 'Những website và nền tảng web được xây dựng từ mục tiêu rõ ràng, trải nghiệm hữu ích và khả năng tăng trưởng bền vững.', 'textarea'),
            ],
            'Danh sách' => [
                'list_title' => $field('Nhãn danh sách', 'ALL PROJECTS', 'TẤT CẢ DỰ ÁN'),
                'visit_button' => $field('Nút xem dự án', 'Visit project ↗', 'Xem dự án ↗'),
                'empty_title' => $field('Tiêu đề khi trống', 'No projects yet.', 'Chưa có dự án.'),
                'empty_description' => $field('Mô tả khi trống', 'New NAFU work will appear here soon.', 'Các dự án mới của NAFU sẽ sớm xuất hiện tại đây.'),
                'project_previous' => $field('Phân trang trước', '← Previous', '← Trước'),
                'project_next' => $field('Phân trang sau', 'Next →', 'Sau →'),
            ],
        ],
    ],
    'news' => [
        'label' => 'News',
        'prefix' => 'page_news',
        'sections' => [
            'SEO & Hero' => [
                'seo_title' => $field('SEO title', 'NAFU Services Insights — Web design, development and growth', 'NAFU Services Insights — Thiết kế, phát triển web và tăng trưởng'),
                'seo_description' => $field('SEO description', 'Practical insights from NAFU about fast websites, web platforms, design and digital growth.', 'Góc nhìn thực tế từ NAFU về website, nền tảng web, thiết kế và tăng trưởng số.', 'textarea'),
                'seo_keywords' => $field('SEO keywords', 'web design insights, web development, digital growth, NAFU news', 'kiến thức thiết kế web, phát triển website, tăng trưởng số, tin tức FEB', 'textarea'),
                'hero_eyebrow' => $field('Nhãn Hero', 'NAFU INSIGHTS', 'GÓC NHÌN FEB'),
                'hero_title' => $field('Tiêu đề Hero', 'Ideas for websites<br>that <em>work harder.</em>', 'Góc nhìn để website<br><em>hiệu quả hơn.</em>', 'textarea'),
                'hero_description' => $field('Mô tả Hero', 'Practical notes on strategy, design and development for businesses building on the web.', 'Những chia sẻ thực tế về chiến lược, thiết kế và phát triển website dành cho doanh nghiệp.', 'textarea'),
            ],
            'Danh sách' => [
                'list_title' => $field('Nhãn danh sách', 'LATEST ARTICLES', 'BÀI VIẾT MỚI NHẤT'),
                'read_button' => $field('Nút đọc bài', 'Read ↗', 'Xem bài ↗'),
                'empty_title' => $field('Tiêu đề khi trống', 'No articles yet.', 'Chưa có bài viết.'),
                'empty_description' => $field('Mô tả khi trống', 'New NAFU insights will appear here soon.', 'Các bài chia sẻ mới từ NAFU sẽ sớm xuất hiện tại đây.'),
                'previous' => $field('Phân trang trước', '← Previous', '← Trước'),
                'next' => $field('Phân trang sau', 'Next →', 'Sau →'),
            ],
        ],
    ],
    'news_detail' => [
        'label' => 'News Detail',
        'prefix' => 'page_news_detail',
        'sections' => [
            'Banner & Nội dung' => [
                'back' => $field('Quay lại danh sách', '← All insights', '← Tất cả bài viết'),
                'summary_label' => $field('Nhãn tóm tắt', 'ABOUT THIS ARTICLE', 'VỀ BÀI VIẾT NÀY'),
                'summary_fallback' => $field('Mô tả mặc định', 'Ideas and practical lessons from the NAFU team.', 'Góc nhìn và kinh nghiệm thực tế từ đội ngũ NAFU.', 'textarea'),
                'insights_label' => $field('Nhãn chuyên mục', 'NAFU Insights', 'Góc nhìn FEB'),
                'minute_suffix' => $field('Đơn vị phút', 'min', 'phút'),
                'read_time' => $field('Nhãn thời gian đọc', 'READ TIME', 'THỜI GIAN ĐỌC'),
                'views' => $field('Nhãn lượt xem', 'VIEWS', 'LƯỢT XEM'),
                'content_empty' => $field('Nội dung đang cập nhật', '<p>Content is being updated.</p>', '<p>Nội dung đang được cập nhật.</p>', 'textarea'),
            ],
            'Sidebar' => [
                'contact_label' => $field('Nhãn liên hệ', 'CONTACT NAFU', 'LIÊN HỆ FEB'),
                'contact_title' => $field('Tiêu đề liên hệ', 'Have a project<br>in mind?', 'Bạn đang có<br>một dự án?', 'textarea'),
                'contact_email' => $field('Email liên hệ', 'admin@nafuservices.com', 'admin@nafuservices.com'),
                'share_label' => $field('Nhãn chia sẻ', 'Share article', 'Chia sẻ bài viết'),
                'related_title' => $field('Bài liên quan', 'Read more', 'Xem thêm bài viết'),
            ],
        ],
    ],
];
