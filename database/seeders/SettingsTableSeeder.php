<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $setting = $this->findSetting('site.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Tiêu đề của Site',
                'value' => __('voyager::seeders.settings.site.title'),
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.post_notice');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Lưu ý khi đăng tin',
                'value' => '',
                'details' => '',
                'type' => 'rich_text_box',
                'order' => 20   ,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Mô tả site',
                'value' => __('voyager::seeders.settings.site.description'),
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.logo');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Logo',
                'value' => config('constants.DEFAULT_LOGO'),
                'details' => '',
                'type' => 'image',
                'order' => 3,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.favicon');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Site Favicon',
                'value' => config('constants.DEFAULT_FAVICON'),
                'details' => '',
                'type' => 'image',
                'order' => 4,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.category_per_page');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Số lượng danh mục hiển thị trên trang chủ',
                'value' => '14',
                'details' => '',
                'type' => 'text',
                'order' => 5,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.placeholder_search_form');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Chữ hiển thị trong ô tìm kiếm',
                'value' => 'Nhập từ khóa tìm kiếm trên Chợ máy 24h',
                'details' => '',
                'type' => 'text',
                'order' => 6,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.max_support_time');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Thời gian hỗ trợ tối đa',
                'value' => 9,
                'details' => '',
                'type' => 'text',
                'order' => 7,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.support_receive_percent');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Phần trăm hạn mức hỗ trợ',
                'value' => 1,
                'details' => '',
                'type' => 'text',
                'order' => 8,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.sale_limit_ratio');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Tỷ lệ nạp ví bán hàng',
                'value' => 10,
                'details' => '',
                'type' => 'text',
                'order' => 9,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.percent_transfer');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Phí chuyển nhượng(%)',
                'value' => 5,
                'details' => '',
                'type' => 'text',
                'order' => 9,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.bank_name');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Tên ngân hàng',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 10,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.bank_account');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Số tài khoản ngân hàng',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 11,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.bank_account_id_of_casso');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'ID tài khoản casso',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 12,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.bank_owner');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Chủ tài khoản',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 13,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.bank_branch');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Chi nhánh',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 14,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.casso_key');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Mã Casso',
                'value' => '',
                'details' => '',
                'type' => 'text',
                'order' => 15,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.amount_month_support_for_referral_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Thời gian nhận hỗ trợ từ mã giới thiệu(tháng)',
                'value' => '24',
                'details' => '',
                'type' => 'text',
                'order' => 16,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.received_support_for_referral_code');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Hạn mức bán hàng nhận từ mã giới thiệu',
                'value' => '500000',
                'details' => '',
                'type' => 'text',
                'order' => 17,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.email');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Email liên hệ',
                'value' => 'dangkhanh.dev@gmail.com',
                'details' => '',
                'type' => 'text',
                'order' => 18,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.phone');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Số điện thoại liên hệ',
                'value' => '+84376658437',
                'details' => '',
                'type' => 'text',
                'order' => 19,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.location');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Địa chỉ',
                'value' => 'Mai Dịch, Hà Nội, Việt Nam',
                'details' => '',
                'type' => 'text',
                'order' => 20,
                'group' => 'Site',
            ])->save();
        }
        $setting = $this->findSetting('site.fax');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Số máy bàn',
                'value' => 'fax number',
                'details' => '',
                'type' => 'text',
                'order' => 21,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('site.copyright');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Bản quyền',
                'value' => '@2023 copyright all by Demid Agency.',
                'details' => '',
                'type' => 'text',
                'order' => 22,
                'group' => 'Site',
            ])->save();
        }

        $setting = $this->findSetting('link.google_store');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn ứng dụng trên Google store',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 1,
                'group' => 'Link',
            ])->save();
        }
        $setting = $this->findSetting('link.apple_store');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn ứng dụng trên Apple store',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 2,
                'group' => 'Link',
            ])->save();
        }
        $setting = $this->findSetting('link.galaxy_store');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn ứng dụng trên Galaxy Store',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 3,
                'group' => 'Link',
            ])->save();
        }

        $setting = $this->findSetting('link.fanpage');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn tới trang fanpage',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 3,
                'group' => 'Link',
            ])->save();
        }

        $setting = $this->findSetting('link.youtube');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn tới trang Youtube',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 4,
                'group' => 'Link',
            ])->save();
        }

        $setting = $this->findSetting('link.tiktok');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn tới trang Tiktok',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 5,
                'group' => 'Link',
            ])->save();
        }

        $setting = $this->findSetting('link.certify');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Đường dẫn tới trang chứng nhận',
                'value' => '#',
                'details' => '',
                'type' => 'text',
                'order' => 6,
                'group' => 'Link',
            ])->save();
        }

        $setting = $this->findSetting('admin.icon_image');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Logo admin',
                'value' => config('constants.DEFAULT_LOGO'),
                'details' => '',
                'type' => 'image',
                'order' => 1,
                'group' => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.bg_image');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Ảnh nền trang quản trị',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 2,
                'group' => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Tiêu đề trang quản trị',
                'value' => 'CHO TOT 24H',
                'details' => '',
                'type' => 'text',
                'order' => 3,
                'group' => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Mô tả trang quản trị',
                'value' => __('voyager::seeders.settings.admin.description_value'),
                'details' => '',
                'type' => 'text',
                'order' => 4,
                'group' => 'Admin',
            ])->save();
        }

        $setting = $this->findSetting('admin.loader');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => 'Biểu tượng loading',
                'value' => '',
                'details' => '',
                'type' => 'image',
                'order' => 5,
                'group' => 'Admin',
            ])->save();
        }

    }

    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return [type] [description]
     */
    protected function findSetting($key)
    {
        return Setting::firstOrNew(['key' => $key]);
    }
}
