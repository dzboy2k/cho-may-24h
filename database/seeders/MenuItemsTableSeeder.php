<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::where('name', 'admin')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('admin.dashboard'),
            'url' => '',
            'route' => 'voyager.dashboard',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-boat',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Lịch sử giao dịch',
            'url' => '',
            'route' => 'admin.transactions',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-window-list',
                'color' => null,
                'parent_id' => null,
                'order' => 17,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Yêu cầu rút tiền',
            'url' => '',
            'route' => 'admin.withdraws',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-dollar',
                'color' => null,
                'parent_id' => null,
                'order' => 17,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Trang',
            'url' => '',
            'route' => 'admin.pages',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-documentation',
                'color' => null,
                'parent_id' => null,
                'order' => 8,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Gói đăng tin',
            'url' => '',
            'route' => 'admin.post-plans',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-harddrive',
                'color' => null,
                'parent_id' => null,
                'order' => 8,
            ])->save();
        }

        $post_menu_id = $menuItem->id;
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Quản lý gói đăng tin',
            'url' => '',
            'route' => 'admin.post-plans',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-harddrive',
                'color' => null,
                'parent_id' => $post_menu_id,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Người dùng đã đăng kí',
            'url' => '',
            'route' => 'admin.user.posting.plan',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-person',
                'color' => null,
                'parent_id' => $post_menu_id,
                'order' => 2,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Tin Đăng',
            'url' => '',
            'route' => 'admin.posts',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-documentation',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $post_menu_id = $menuItem->id;
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Quản lý tin đăng',
            'url' => '',
            'route' => 'admin.posts',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-documentation',
                'color' => null,
                'parent_id' => $post_menu_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Tin Đăng Chờ Duyệt',
            'url' => '',
            'route' => 'admin.posts.unverify',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-news',
                'color' => null,
                'parent_id' => $post_menu_id,
                'order' => 2,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Quản lý thương hiệu',
            'url' => '',
            'route' => 'admin.brands',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-certificate',
                'color' => null,
                'parent_id' => $post_menu_id,
                'order' => 3,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => 'Trạng thái',
            'url' => '',
            'route' => 'admin.status',
        ]);

        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-activity',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('admin.media'),
            'url' => '',
            'route' => 'voyager.media.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-images',
                'color' => null,
                'parent_id' => null,
                'order' => 5,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('admin.users'),
            'url' => '',
            'route' => 'voyager.users.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-person',
                'color' => null,
                'parent_id' => null,
                'order' => 3,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('categories.category_in_lang'),
            'url' => '',
            'route' => 'admin.categories',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-list',
                'color' => null,
                'parent_id' => null,
                'order' => 3,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('admin.roles'),
            'url' => '',
            'route' => 'voyager.roles.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-lock',
                'color' => null,
                'parent_id' => null,
                'order' => 2,
            ])->save();
        }

        $toolsMenuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('admin.tools'),
            'url' => '',
        ]);
        if (!$toolsMenuItem->exists) {
            $toolsMenuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-tools',
                'color' => null,
                'parent_id' => null,
                'order' => 9,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('voyager::seeders.menu_items.menu_builder'),
            'url' => '',
            'route' => 'voyager.menus.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-list',
                'color' => null,
                'parent_id' => $toolsMenuItem->id,
                'order' => 10,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('voyager::seeders.menu_items.database'),
            'url' => '',
            'route' => 'voyager.database.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-data',
                'color' => null,
                'parent_id' => $toolsMenuItem->id,
                'order' => 11,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('voyager::seeders.menu_items.compass'),
            'url' => '',
            'route' => 'voyager.compass.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-compass',
                'color' => null,
                'parent_id' => $toolsMenuItem->id,
                'order' => 12,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('voyager::seeders.menu_items.bread'),
            'url' => '',
            'route' => 'voyager.bread.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-bread',
                'color' => null,
                'parent_id' => $toolsMenuItem->id,
                'order' => 13,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title' => __('admin.settings'),
            'url' => '',
            'route' => 'voyager.settings.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'voyager-settings',
                'color' => null,
                'parent_id' => null,
                'order' => 14,
            ])->save();
        }

        $header_menu = Menu::where('name', 'header')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $header_menu->id,
            'title' => 'Trang chủ',
            'url' => '',
            'route' => 'home',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $header_menu->id,
            'title' => 'Tin đăng',
            'url' => '',
            'route' => 'post.filter',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'color' => null,
                'special_tag' => '',
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $header_menu->id,
            'title' => 'Blog',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $header_menu->id,
            'title' => 'Liên hệ',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $user_menu = Menu::where('name', 'user')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Quản lý đơn hàng',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => 'title',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Đơn mua',
            'url' => '',
            'route' => 'site.history.order_history.buy',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/orders.svg',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Đơn bán',
            'url' => '',
            'route' => 'site.history.order_history.sell',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/sells.svg',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Dịch vụ trả phí',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/vip.svg',
                'special_tag' => 'title',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Đồng máy',
            'url' => '',
            'route' => 'deposit.method',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/dm-coin-icon.png',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Gói đăng tin ưu tiên',
            'url' => '',
            'route' => 'site.post-plans',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/post_plan_icon.png',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Tiện ích',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/heart-fill.svg',
                'special_tag' => 'title',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Tin đăng đã lưu',
            'url' => '',
            'route' => 'saved.posts',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/heart.svg',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Khác',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/conf.svg',
                'special_tag' => 'title',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Cài đặt tài khoản',
            'url' => '/user',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/conf.svg',
                'special_tag' => 'action',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Trợ giúp',
            'url' => '/user',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/help.svg',
                'special_tag' => 'action',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $user_menu->id,
            'title' => 'Đăng xuất',
            'url' => '',
            'route' => 'auth.logout',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '/images/logout.svg',
                'special_tag' => 'auth',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $submenu = Menu::where('name', 'submenu')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Chợ máy 24h official',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Thu mua đồng hồ',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Thu mua điện thoại',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Gói đăng tin ưu tiên',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Thu mua Ô tô',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Nạp đồng máy',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Nâng hạn mức bán hàng',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Giới thiệu tổng quan',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $submenu->id,
            'title' => 'Tin đăng đã lưu',
            'url' => '',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-solid fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }

        $footer_menu = Menu::where('name', 'footer')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Về chúng tôi',
            'url' => '/about',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => 'title',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $about_id = $menuItem->id;
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Hỗ trợ',
            'url' => '/helps',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => 'title',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $helper_id = $menuItem->id;
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Giới thiệu',
            'url' => '/introduce',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Quy chế hoạt động',
            'url' => '/terms',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Chính sách bảo mật',
            'url' => '/security',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Giải quyết tranh chấp',
            'url' => '/resolve',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Tuyển dụng',
            'url' => '/recruitment',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Blog',
            'url' => '/blog',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Điều khoản sử dụng',
            'url' => '/term-of-use',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $about_id,
                'order' => 1,
            ])->save();
        }

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Trung Tâm trợ giúp',
            'url' => '/helper-center',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'An toàn mua bán',
            'url' => '/self-trade',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Liên hệ hỗ trợ',
            'url' => '/lien-he-ho-tro',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Telegram',
            'url' => '/telegram',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Ticket',
            'url' => '/ticket',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Call Center',
            'url' => '/call-center',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_menu->id,
            'title' => 'Help',
            'url' => '/help',
            'route' => '',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => '',
                'special_tag' => '',
                'color' => null,
                'parent_id' => $helper_id,
                'order' => 1,
            ])->save();
        }
        $footer_nav_mobile = Menu::where('name', 'footer_nav_mobile')->firstOrFail();
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_nav_mobile->id,
            'title' => 'Trang chủ',
            'url' => '',
            'route' => 'home',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-regular fa-house',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 1,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_nav_mobile->id,
            'title' => 'Quản lý tin',
            'url' => '',
            'route' => 'user.info',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-regular fa-list',
                'special_tag' => config('constants.MANAGER_FEAT'),
                'color' => null,
                'parent_id' => null,
                'order' => 2,
            ])->save();
        }
        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $footer_nav_mobile->id,
            'title' => 'Đăng tin',
            'url' => '',
            'route' => 'post.create.form',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target' => '_self',
                'icon_class' => 'fa-regular fa-pen-to-square',
                'special_tag' => '',
                'color' => null,
                'parent_id' => null,
                'order' => 3,
            ])->save();
        }
    }
}
