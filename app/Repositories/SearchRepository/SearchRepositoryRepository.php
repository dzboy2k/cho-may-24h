<?php

namespace App\Repositories\SearchRepository;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;

class SearchRepositoryRepository extends Controller implements SearchRepositoryInterface
{
    public function search($request){
        $usersResult = User::where("name","LIKE","%".$request->search_query."%")->orWhere("referral_code","LIKE","%".$request->search_query."%")->get();
        $postResult = Post::where([
                ["title","LIKE","%".$request->search_query."%"],
                ['post_state', '!=', config('constants.POST_STATUS')['SOLD']],
                ['post_state','=',config('constants.POST_STATUS')['VERIFIED']]
                ])->get();
        $pageResult = Page::where([
                ["title","LIKE","%".$request->search_query."%"],
                ['status','=','ACTIVE'],
            ])->get();
        return ["users"=>$usersResult,"posts"=>$postResult,'pages'=>$pageResult];
    }
}
