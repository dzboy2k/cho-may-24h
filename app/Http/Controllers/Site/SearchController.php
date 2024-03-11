<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Post\PostInterface;
use App\Repositories\SearchRepository\SearchRepositoryInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $searchRepo;

    public function __construct(SearchRepositoryInterface $searchRepo)
    {
        $this->searchRepo = $searchRepo;
    }

    public function index(Request $request)
    {
        return view('site.search.index', ['result'=>$this->searchRepo->search($request)]);
    }
}