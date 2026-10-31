<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $projects = [
            [
                'title' => 'CBD Apartment Repair & Refresh',
                'slug' => 'cbd-apartment-repair-refresh',
                'description' => 'A coordinated repair program restoring damaged walls, doors, cabinetry and bathroom fittings in a Melbourne CBD apartment.',
                'content' => '<p>Nafu completed a practical apartment refresh with minimal disruption to the resident and building.</p><p>The scope covered plaster repairs, door adjustments, cabinet hardware and bathroom sealing, followed by a detailed completion report.</p>',
                'avatar' => 'assets/dried-chilli/services-repairs.avif',
            ],
            [
                'title' => 'Southbank Interior Repaint',
                'slug' => 'southbank-interior-repaint',
                'description' => 'A full interior repaint with careful surface preparation, low-odour coatings and protection for floors and furniture.',
                'content' => '<p>This Southbank apartment was prepared and repainted before the owners returned home.</p><p>Cracks and dents were repaired first, followed by ceilings, walls, doors and skirting boards in a clean neutral finish.</p>',
                'avatar' => 'assets/dried-chilli/services-painting.avif',
            ],
            [
                'title' => 'Docklands Flooring Upgrade',
                'slug' => 'docklands-flooring-upgrade',
                'description' => 'Old flooring replaced with a durable hybrid system, acoustic underlay and new trims throughout the living areas.',
                'content' => '<p>Nafu coordinated building access, removed the existing floor and installed acoustic underlay suitable for apartment living.</p><p>The new hybrid boards and trims delivered a durable, low-maintenance finish.</p>',
                'avatar' => 'assets/dried-chilli/services-flooring.avif',
            ],
            [
                'title' => 'End of Lease Make Good',
                'slug' => 'end-of-lease-make-good',
                'description' => 'Patching, painting and minor repairs completed to prepare a rental apartment for inspection and handover.',
                'content' => '<p>The work was planned around the vacate date and combined several trades into one clear schedule.</p><p>Wall fixings were removed, damaged surfaces repaired and all completed items documented for the property manager.</p>',
                'avatar' => 'assets/dried-chilli/services-handover.avif',
            ],
            [
                'title' => 'Portfolio Maintenance Program',
                'slug' => 'portfolio-maintenance-program',
                'description' => 'Responsive maintenance and tenancy changeover work delivered across a portfolio of inner-Melbourne apartments.',
                'content' => '<p>Nafu provides one point of contact for routine repairs, urgent maintenance and changeover works.</p><p>Each job includes clear status updates, condition notes, completion photos and consolidated reporting.</p>',
                'avatar' => 'assets/dried-chilli/services-property.avif',
            ],
        ];

        foreach ($projects as $project) {
            $legacyContent = $project['content'];
            $project['content'] = $this->richContent($project['slug']);
            $existing = DB::table('projects')->where('slug', $project['slug'])->first();
            if (!$existing) {
                DB::table('projects')->insert(array_merge([
                    'website_url' => null,
                    'active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ], $project));
            } elseif (!$existing->avatar) {
                DB::table('projects')->where('id', $existing->id)->update(['avatar' => $project['avatar'], 'updated_at' => $now]);
            }
            if ($existing && (blank($existing->content) || $existing->content === $legacyContent)) {
                DB::table('projects')->where('id', $existing->id)->update(['content' => $project['content'], 'updated_at' => $now]);
            }
        }
    }

    private function richContent(string $slug): string
    {
        $content = [
            'cbd-apartment-repair-refresh' => [
                'heading' => 'A practical refresh for everyday living',
                'intro' => 'This Melbourne CBD apartment needed several small defects resolved without turning the home into a long renovation. Nafu coordinated the work as one clear scope and kept the resident informed throughout.',
                'features' => ['Plaster repairs and seamless paint touch-ups', 'Door, lock and cabinet hardware adjustments', 'Bathroom resealing and minor fixture repairs', 'Completion photographs and a clear handover summary'],
                'result' => 'The apartment was left clean, secure and ready to enjoy, with every agreed item checked before handover.',
            ],
            'southbank-interior-repaint' => [
                'heading' => 'A calm, consistent interior finish',
                'intro' => 'The owners wanted to brighten their Southbank apartment while protecting existing flooring, joinery and furniture. Work was scheduled room by room to minimise disruption.',
                'features' => ['Repair cracks, dents and previous fixing points', 'Prepare ceilings, walls, doors and skirting boards', 'Apply low-odour premium interior coatings', 'Complete a detailed clean and final colour review'],
                'result' => 'Careful preparation delivered an even finish that feels lighter and refreshed throughout the apartment.',
            ],
            'docklands-flooring-upgrade' => [
                'heading' => 'Durable flooring designed for apartment life',
                'intro' => 'Nafu replaced tired flooring with a durable hybrid system selected for easy maintenance and everyday comfort. Building access and acoustic requirements were confirmed before installation.',
                'features' => ['Remove and responsibly clear the existing floor', 'Prepare and level the substrate where required', 'Install compliant acoustic underlay and hybrid boards', 'Finish edges, trims and transitions neatly'],
                'result' => 'The new floor created a consistent, hard-wearing finish across the living areas with clean transitions into adjoining rooms.',
            ],
            'end-of-lease-make-good' => [
                'heading' => 'A coordinated handover without the hassle',
                'intro' => 'With a fixed vacate date, the apartment needed patching, painting and several minor repairs completed in the right order. One coordinated schedule kept the process simple.',
                'features' => ['Remove wall fixings and patch damaged surfaces', 'Touch up paint and repair doors and skirting', 'Resolve minor bathroom and kitchen maintenance items', 'Provide completion photos for the property manager'],
                'result' => 'All listed works were completed before the final inspection, leaving the apartment tidy and ready for handover.',
            ],
            'portfolio-maintenance-program' => [
                'heading' => 'Reliable maintenance across every property',
                'intro' => 'Nafu supports a portfolio of inner-Melbourne apartments with one point of contact for routine maintenance, urgent repairs and tenancy changeovers.',
                'features' => ['Coordinate tenants, owners and building access', 'Deliver responsive repairs across multiple trades', 'Supply clear quotes before non-urgent work begins', 'Report with notes, photographs and itemised invoices'],
                'result' => 'The program gives property managers consistent communication and a dependable record of completed work across the portfolio.',
            ],
        ][$slug];

        $items = collect($content['features'])->map(fn ($item) => '<li>' . e($item) . '</li>')->implode('');
        return '<h2>' . e($content['heading']) . '</h2><p>' . e($content['intro']) . '</p><h3>Project features</h3><ul>' . $items . '</ul><h3>The result</h3><p>' . e($content['result']) . '</p>';
    }
}
