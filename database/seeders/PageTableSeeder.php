<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::factory()->count(6)->create();
        $admin = User::where('role_id', 1)->first();
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Chợ máy 24h official',
            'slug' => 'officials',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Thu mua đồng hồ',
            'slug' => 'thu-mua-dong-ho',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Thu mua điện thoại',
            'slug' => 'thu-mua-dien-thoai',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Thu mua Ô tô',
            'slug' => 'thu-mua-oto',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Nạp đồng máy',
            'slug' => '/transaction/deposit',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Nâng hạn mức bán hàng',
            'slug' => '/transaction/deposit/to-sale-wallet',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Gói đăng tin ưu tiên',
            'slug' => '/post-plans',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Giới thiệu tổng quan',
            'slug' => 'gioi-thieu-tong-quan',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
        Page::create([
            'author_id' => $admin->id,
            'title' => 'Tin đăng đã lưu',
            'slug' => 'user/saved-posts',
            'body' => '',
            'meta_description' => '',
            'show_in_home_slide' => 0,
            'show_in_header' => 0,
            'is_service' => 1,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ]);
    }
}
