<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\System;

class UpdateSystemsTable extends Command
{
    protected $signature = 'systems:update';
    protected $description = 'Updates the Systems table with default keys';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $defaultValues = [
            'company_email' => 'sunnydays@dayoneasia.co',
            'company_hotline' => '1800 646 821',
            'password_default' => 'Dayone@123',

            'logo_app' => '/storage/systems/logo_app.png',
            'banner_app' => '/storage/systems/welcome_login.jpg',

            'link_clause' => 'https://sunnydays.vn/privacy-policy',
            'link_support' => 'https://support.sunnydays.vn',
            'link_introduce' => 'https://app.sunnydays.vn',

            'link_facebook' => 'https://facebook.com',
            'link_messenger' => 'https://facebook.com?messengerid=1',

            'link_zalo' => 'https://zalo.me?0949992539',

            'api_user_password' => '$2y$10$6DyHLep0XQcd4jZNEVSrbuG7Ul5Z0V1ZxCWzc8qFH6hLTJS2x28i.',
            'api_user_id' => 'api_key_private',
            'api_key_private' => 's0iUb5MYgwQhnCWuCHuVWGba8LFD0sRw3ITSFoot',
            'api_key_base' => '03jC0U7CvFbUCYqQra2x',

            'type_otp' => '1',
            'limit_otp' => '3',
            'limit_forget' => '5',

            'shareholder_class_limit_day' => '2',
            'shareholder_class_limit_week' => '2',
            'shareholder_class_cancel_limit_month' => '4',
            'shareholder_class_not_yet_limit_month' => '3',
            'shareholder_class_cancel_time' => '2',
            'shareholder_class_limit_cancel_time' => '30',

            'instrument_practice_row' => '5',
            'book_practice_time_start' => '08:00',
            'book_practice_time_end' => '20:30',
            'book_practice_time_step' => '5',
            'shareholder_practice_limit_day' => '1',
            'shareholder_practice_limit_week' => '7',
            'shareholder_practice_cancel_limit_month' => '4',
            'shareholder_practice_not_yet_limit_month' => '3',
            'shareholder_practice_cancel_time' => '2',

            'shareholder_suspend_days' => '14',

            'shareholder_cancel_text_show_student' => '<div><div style=\'color: #6A6A6A; font-size: 12px; font-family: \'Be Vietnam Pro\', sans-serif; font-weight: 400;\'>__SPAN__Bạn có chắc chắn muốn hủy lịch đặt này?</div><div style=\'padding: 10px 0; border-bottom: 0.5px solid #E1E1E1;\'><div style=\'color: #8D8D8D; font-size: 10px; font-family: \'Be Vietnam Pro\', sans-serif; font-weight: 400; line-height: 14px;\'>Số lần đã hủy lịch: __CANCELLED__/__LIMIT__ lần</div></div><div><span style=\'color: #FF7979; font-size: 12px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 17px; word-wrap: break-word\'>Lưu ý:</span><span style=\'color: #FF4646; font-size: 12px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 17px; word-wrap: break-word\'> </span><span style=\'color: #8D8D8D; font-size: 12px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 17px; word-wrap: break-word\'>Nhằm đảm bảo trải nghiệm dịch vụ của mỗi khách hàng, tính năng hủy lịch đặt chỉ được tối đa __LIMIT__ lần. Nếu hủy quá số lần quy định tính năng này sẽ tạm ngưng __SUSPEND__ ngày. Xin Quý Khách vui lòng liên hệ tổng đài __HOTLINE__ để được hỗ trợ trong thời gian sớm nhất. Cảm ơn Quý khách</span></div>',
            'shareholder_cancel_exceeded_text_show_student' => "<span style='color: #FF4646;'>Bạn đã hủy vượt quá số lần quy định!</span>",
            'shareholder_statistic_practice' => '<div style=\'width: 337px\'><span style=\'color: #FF4646; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>Lưu ý:<br/></span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>Không được Hủy quá </span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>__LIMIT__ lần/tháng</span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'> và trước __CONDITION_TIME__h thời gian bắt đầu của buổi học. <br/>Học viên không đến lớp (đặt lịch nhưng không đi học) không được quá __BOM__ lần/tháng<br/></span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>Nếu vi phạm, hệ thống đặt lịch trên ứng dụng sẽ bị ngưng __SUSPEND__ ngày<br/>Xin chân thành cảm ơn!</span></div>',
            'shareholder_statistic_class' => '<div style=\'width: 337px\'><span style=\'color: #FF4646; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>Lưu ý:<br/></span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>Không được Hủy quá </span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>__LIMIT__ lần/tháng</span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'> và trước __CONDITION_TIME__h thời gian bắt đầu của buổi học. <br/>Học viên không đến lớp (đặt lịch nhưng không đi học) không được quá __BOM__ lần/tháng<br/></span><span style=\'color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word\'>Nếu vi phạm, hệ thống đặt lịch trên ứng dụng sẽ bị ngưng __SUSPEND__ ngày<br/>Xin chân thành cảm ơn!</span></div>',
            'shareholder_limit_exceeded' => "<div style='display: flex; flex-direction: column; align-items: center; gap: 4px;'><div style='color: #3B3B3B; font-size: 12px; font-family: 'Be Vietnam Pro'; font-weight: 400; line-height: 17px; text-align: center;'>Ngày mở lại tính năng: __EXPIRED__</div><div style='color: #8D8D8D; font-size: 12px; font-family: 'Be Vietnam Pro'; font-weight: 400; line-height: 17px; text-align: center;'>Nhằm đảm bảo trải nghiệm dịch vụ của mỗi khách hàng, tính năng đặt lịch của Quý Khách sẽ tạm ngưng trong __SUSPEND__ ngày vì đã hủy quá số lần quy định trong tháng. Xin Quý Khách vui lòng liên hệ tổng đài __HOTLINE__ để được hỗ trợ trong thời gian sớm nhất. Cảm ơn Quý khách!</div></div>",
            'shareholder_practice_cancel_text_show_student' => "<p>Bạn có chắc chắn muốn hủy lịch đặt này?</p><p>Số lần đã hủy lịch: __CANCELLED__/__LIMIT__ lần</p><p><span style='color: rgb(255, 121, 121);'>Lưu ý:</span><span style='color: rgb(255, 70, 70);'> </span><span style='color: rgb(141, 141, 141);'>Nhằm đảm bảo trải nghiệm dịch vụ của mỗi khách hàng, tính năng hủy lịch đặt chỉ được tối đa __LIMIT__ lần. Cảm ơn Quý khách</span></p>",
            'student_update_request_notice_text' => "<div style='color: #9B9B9B; font-size: 10px; font-family: Be Vietnam Pro; font-weight: 400; line-height: 14px; word-wrap: break-word'>*Yêu cầu cập nhật: Sunny Days sẽ liên hệ đến Quý Khách hàng<br/>trong thời gian sớm nhất</div>",

            'shareholder_class_cancel_time_message' => '<p>Bạn không thể hủy buổi học trong vòng __MINUTES_CLASS__ phút trước khi bắt đầu.</p>',
            'shareholder_practice_cancel_time_message' => '<p>Bạn không thể hủy buổi học trong vòng __MINUTES_PRACTICE__ phút trước khi bắt đầu.</p>',
        ];

        foreach ($defaultValues as $key => $value) {
            System::updateOrCreate(
                ['key' => $key],
                ['content' => $value, 'active' => true, 'order' => 0]
            );
        }

        $this->info('Systems table updated successfully.');
    }
}
