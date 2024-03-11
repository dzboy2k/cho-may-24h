<?php

namespace App\Repositories\Page;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PageRepository extends Controller implements PageInterface
{
    private Page $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function get()
    {
        return $this->page::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->page::find($id);
    }

    public function store($request)
    {
        $page = $this->page::firstOrNew(['slug' => $request['slug']]);
        $page->fill($request);
        $page->save();
    }

    public function update($request)
    {
        $page = $this->page::find($request['id']);
        $page->fill($request)->save();
    }

    public function destroy($id)
    {
        try {
            $this->page::find($id)->delete();
            return response()->json(['message' => __('message.delete_success', ['name' => __('page.page')])]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('message.delete_failed')], 500);
        }
    }

    public function getHomeSlide($limit)
    {
        return $this->page
            ::where([['show_in_home_slide', '=', 1], ['status', '=', 'ACTIVE']])
            ->limit($limit)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function search($search_query)
    {
        return $this->page::where('title', 'LIKE', '%' . $search_query . '%')->paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getServicePage()
    {
        return $this->page::where([['is_service', '=', 1], ['status', '=', 'ACTIVE']])->orderBy('created_at', 'desc')->limit(config('constants.SERVICE_PER_PAGE'))->get();
    }

    public function getBySlug($slug)
    {
        return $this->page::where('slug', $slug)->first();
    }
}
