<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $services = [
            [
                'name' => 'Apartment repairs',
                'slug' => 'apartment-repairs',
                'description' => 'Practical repairs for apartments across Melbourne’s CBD and inner suburbs, with a booked arrival window, clear pricing and photos of the completed work.',
                'content' => '<ul><li>Repair plaster damage, sticking doors, locks and cabinet hardware</li><li>Fix dripping taps, toilet issues, shower sealant and grout</li><li>Repair blinds, shelving, balcony doors and window fittings</li></ul>',
                'position' => 1,
            ],
            [
                'name' => 'Apartment painting',
                'slug' => 'apartment-painting',
                'description' => 'Refresh a room or the entire apartment with careful surface preparation and low odour paint. Furniture and floors are protected, and rooms are reset at the end of each day.',
                'content' => '<ul><li>Repaint interiors, ceilings, doors and skirting boards</li><li>Prepare cracks, dents and water stains before painting</li><li>Match existing colours, add feature walls or touch up before moving out</li></ul>',
                'position' => 2,
            ],
            [
                'name' => 'Apartment flooring',
                'slug' => 'apartment-flooring',
                'description' => 'From a damaged board to a complete replacement, Nafu supplies and installs apartment flooring or fits materials you already own, coordinating building access and acoustic requirements.',
                'content' => '<ul><li>Install timber, engineered wood, laminate, vinyl and hybrid floors</li><li>Replace damaged boards and repair tiles or grout</li><li>Fit acoustic underlay and trims, then remove the old flooring</li></ul>',
                'position' => 3,
            ],
            [
                'name' => 'End of lease make good',
                'slug' => 'end-of-lease',
                'description' => 'Prepare an apartment for handover with coordinated patching, painting and repairs. Work is planned around the vacate date, with an itemised invoice and photos for the bond claim.',
                'content' => '<ul><li>Remove wall fixings, patch holes and restore painted surfaces</li><li>Repair damaged doors, skirtings, tiles and flooring</li><li>Document each completed item with before and after photographs</li></ul>',
                'position' => 4,
            ],
            [
                'name' => 'For property managers',
                'slug' => 'property-managers',
                'description' => 'Apartment maintenance for property managers and owners corporations, with agreed response windows and clear job reports.',
                'content' => '<ul><li>Arrange repairs, tenancy changeovers, painting and flooring work</li><li>Resolve common property defects and apartment hardware issues</li><li>Receive photo reports, condition notes and consolidated monthly invoicing</li></ul>',
                'position' => 5,
            ],
        ];

        foreach ($services as $service) {
            $legacyContent = $service['content'];
            $service['content'] = $this->richContent($service);
            preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $service['content'], $benefitMatches);
            $service['benefits'] = collect($benefitMatches[1] ?? [])->map(fn ($item) => trim(strip_tags($item)))->implode("\n");
            $images = [
                'apartment-repairs' => 'services-repairs.avif',
                'apartment-painting' => 'services-painting.avif',
                'apartment-flooring' => 'services-flooring.avif',
                'end-of-lease' => 'services-handover.avif',
                'property-managers' => 'services-property.avif',
            ];
            $image = 'assets/nafu/' . $images[$service['slug']];
            $existing = DB::table('services')->where('slug', $service['slug'])->first();

            if (!$existing) {
                DB::table('services')->insert(array_merge([
                    'avatar' => $image,
                    'contract_price' => null,
                    'active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], $service));
            } else {
                $updates = [];
                if (!$existing->avatar) {
                    $updates['avatar'] = $image;
                }
                if (blank($existing->benefits ?? null)) {
                    $updates['benefits'] = $service['benefits'];
                    $updates['updated_at'] = $now;
                }
                // Upgrade only our original starter content, never an admin's edits.
                if (trim((string) $existing->content) === '' || $existing->content === $legacyContent) {
                    $updates['content'] = $service['content'];
                    $updates['updated_at'] = $now;
                }
                if ($updates) {
                    DB::table('services')->where('id', $existing->id)->update($updates);
                }
            }
        }
    }

    private function richContent(array $service): string
    {
        $details = [
            'apartment-repairs' => [
                'images' => ['services-repairs.avif', 'services-cta.avif'],
                'benefit' => 'Clear quotes and completion photos to keep you informed',
                'steps' => [
                    ['Booking inspection', 'Send photos and details of the work. Our team will arrange a visit to confirm the scope.'],
                    ['Work planning', 'Agree on the price and timing before work begins, including access arrangements for your building.'],
                    ['Fix and install', 'Repairs and installation completed with care, followed by a clean space and photographs of the finished work.'],
                ],
            ],
            'apartment-painting' => [
                'images' => ['services-painting.avif', 'services-handover.avif'],
                'benefit' => 'A tidy finish, protected furnishings and a clear schedule for your home',
                'steps' => [
                    ['Colour consultation', 'Tell us about your rooms, preferred colours and move-in date. We confirm the surfaces and help you plan the finish.'],
                    ['Prepare and protect', 'Cover floors and furnishings, repair minor imperfections and prepare surfaces for a consistent result.'],
                    ['Paint and review', 'Apply the agreed paint system, check the details together and leave your apartment clean and ready to enjoy.'],
                ],
            ],
            'apartment-flooring' => [
                'images' => ['service-detail-flooring-1.avif', 'service-detail-flooring-2.avif'],
                'benefit' => 'A practical flooring solution selected around your lifestyle and building requirements',
                'steps' => [
                    ['Measure and advise', 'We measure your apartment, inspect the existing floor and discuss materials, finishes and acoustic requirements.'],
                    ['Plan the installation', 'Confirm the quote, delivery, lift bookings and access before arranging removal and preparation of the existing floor.'],
                    ['Install and finish', 'Fit your new flooring, complete trims and transitions, then walk through the finished space and explain ongoing care.'],
                ],
            ],
            'end-of-lease' => [
                'images' => ['services-handover.avif', 'services-painting.avif'],
                'benefit' => 'One coordinated team to help meet your agreed handover requirements',
                'steps' => [
                    ['Review the checklist', 'Share your agent’s repair list, inspection notes and vacate date so we can identify the work needed.'],
                    ['Coordinate the works', 'Approve an itemised scope and schedule. We organise patching, painting and repairs around your handover.'],
                    ['Ready for handover', 'Receive completion photos and an itemised invoice for your records, with a tidy apartment ready for the final inspection.'],
                ],
            ],
            'property-managers' => [
                'images' => ['services-property.avif', 'services-repairs.avif'],
                'benefit' => 'A single point of contact for maintenance across your Melbourne portfolio',
                'steps' => [
                    ['Send a work order', 'Provide the property address, maintenance issue and contact details. We confirm access and the next available appointment.'],
                    ['Approve and coordinate', 'Receive a clear scope and quote where required. We coordinate tenants, building access and suitable local trades.'],
                    ['Receive the report', 'Get completion photos, practical condition notes and an itemised invoice to keep owners informed and your records up to date.'],
                ],
            ],
        ];
        $detail = $details[$service['slug']];
        $html = '<h2>Benefits of our services</h2><p>' . e($service['description']) . '</p>';
        $html .= str_replace('</ul>', '<li>' . e($detail['benefit']) . '</li></ul>', $service['content']);
        foreach ($detail['images'] as $index => $image) {
            $part = $index === 0 ? 'gallery-left' : 'gallery-right';
            $html .= '<p data-service-part="' . $part . '"><img src="' . e(asset('assets/nafu/' . $image)) . '" alt="' . e($service['name'] . ' by Nafu') . '"></p>';
        }
        // Native Quill blocks stay editable; the presentation stylesheet groups them into columns.
        foreach ($detail['steps'] as $index => $step) {
            $number = $index + 1;
            $html .= '<p data-service-part="icon-' . $number . '"><img src="' . e(asset('assets/nafu/service-work-' . $number . '.svg')) . '" alt=""></p>';
        }
        foreach ($detail['steps'] as $index => $step) {
            $html .= '<h3 data-service-part="title-' . ($index + 1) . '">' . e($step[0]) . '</h3>';
        }
        foreach ($detail['steps'] as $index => $step) {
            $html .= '<p data-service-part="body-' . ($index + 1) . '">' . e($step[1]) . '</p>';
        }
        return $html;
    }
}
