<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

use App\Traits\UploadsImageNoObjectTrait;

class System extends Model
{
    use UploadsImageNoObjectTrait;

    protected $fillable = [
        "key",
        "content"
    ];

    protected static $system;

    public $system_key = [
        'company_name',
        'company_legal_name',
        'company_tax_id',
        'company_email',
        'company_address',
        'company_hotline',
        'company_hotline_2',
        'password_default',
        'company_copyright',
        'company_map',
        'google_site_verification',
        
        'logo_app',
        'logo_app_2',
        'banner_app',

        'link_clause',
        'link_support',
        'link_introduce',

        'link_facebook',
        'link_messenger',

        'link_zalo',

        'api_user_password',
        'api_user_id',
        'api_key_private',
        'api_key_base',

        'project_title',
        'project_description',
        'project_img_1',
        'project_img_2',
        'project_img_3',
        'project_img_4',
        'project_img_5',

        'brand_title',
        'brand_description',
        'brand_content',
        'brand_img_1',

        'core_value',
        'director_name',
        'director_description',
        'director_image',

        'home_mission',
        'company_introduce',

        'sale_page_banner',
        'sale_page_title',
        'sale_page_active_big_sale',

        'google_type',
        'google_project_id',
        'google_client_email',
        'google_client_id',
        'google_private_key_id',
        'google_private_key',
    ];

    public static function content($key, $default = null)
    {
        $model = self::$system ?? self::$system = self::select('key', 'content')
            ->pluck('content', 'key')
            ->toArray();

        if (!empty($model[$key]) && is_array($model[$key])) {
            $locale = App::getLocale();
            return $model[$key][$locale] ?? $default;
        }

        return $model[$key] ?? $default;
    }
}
