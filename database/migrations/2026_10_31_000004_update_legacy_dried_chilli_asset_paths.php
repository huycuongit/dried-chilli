<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateLegacyDriedChilliAssetPaths extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('systems')) return;

        foreach ([
            'assets/dried-chilli/nafu-home.js' => 'assets/dried-chilli/dried-chilli-home.js',
            'assets/dried-chilli/nafu-services.js' => 'assets/dried-chilli/dried-chilli-services.js',
            'assets/dried-chilli/nafu-logo.png' => 'images/logo_dried.png',
        ] as $old => $new) {
            DB::table('systems')->where('content', $old)->update(['content' => $new]);
            DB::table('systems')->where('content', '/' . $old)->update(['content' => '/' . $new]);
        }
    }

    public function down()
    {
        // Preserve settings changed by an administrator after this migration.
    }
}
