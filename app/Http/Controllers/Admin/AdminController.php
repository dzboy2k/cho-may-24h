<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Site;

class AdminController extends Controller
{
    public function index()
    {
        $user_count = User::count();
        $post_count = Post::where('post_state', config('constants.POST_STATUS')['VERIFIED'])->count();
        $unverify_post_count = Post::where('post_state', config('constants.POST_STATUS')['UNVERIFIED'])->count();
//        TODO: handle when we have payment or transaction service
        $successfully_transaction_count = 0;
        $total_charge = 0;
        $site = Site::first();
        return view('admin.index', compact('user_count', 'post_count', 'unverify_post_count', 'successfully_transaction_count', 'total_charge','site'));
    }

    public function getChargeData()
    {
        $charge_data_sum_by_month = [1150002000, 200000200, 150002000, 250002003, 220002000, 30000200, 280002000, 280000023, 280113123, 28213124, 28232333, 282323232, 282312311];
        return response()->json($charge_data_sum_by_month);
    }

    public function fallback()
    {
        return view('admin.errors.404');
    }
}
