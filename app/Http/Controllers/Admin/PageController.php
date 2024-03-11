<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Repositories\Image\ImageInterface;
use App\Repositories\Page\PageInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class PageController extends Controller
{
    private $pageRepo;

    private $imgRepo;
    private $upload_dir;
    private $public_dir;

    public function __construct(PageInterface $pageRepo, ImageInterface $imgRepo)
    {
        $this->pageRepo = $pageRepo;
        $this->imgRepo = $imgRepo;
        $this->public_dir = config('constants.PAGE_ROOT_PATH');
        $this->upload_dir = config('constants.PAGE_UPLOAD_DIR');
    }

    public function index()
    {
        return view('admin.pages.index', ['pages' => $this->pageRepo->get()]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.edit-add', ['is_add' => true]);
    }

    public function create(CreatePageRequest $request)
    {
        try {
            $image_path = "";
            if ($request->hasFile('image')) {
                $image_path = $this->imgRepo->getById($this->uploadImage($request->file('image'), $request->slug, $this->upload_dir, $this->public_dir, $this->imgRepo, 'page-image'))->path;
            }
            $request->image_path = $image_path;
            $this->pageRepo->store($this->getMergePageData($request));
            return redirect()->route('admin.pages')->with('message', ['content' => __('message.create_success', ['name' => strtolower(__('page.page'))]), 'type' => 'success']);
        } catch (\Exception $exception) {
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    protected function getMergePageData($request)
    {
        return array_merge($request->all(), [
            'image' => $request->image_path,
            'author_id' => Auth::id(),
            'show_in_home_slide' => $request->show_in_home_slide ? 1 : 0,
            'is_service' => $request->is_service ? 1 : 0,
            'show_in_header' => $request->show_in_header ? 1 : 0,
        ]);
    }

    public function showEditForm($id)
    {
        $page = $this->pageRepo->getById($id);
        if ($page != null) {
            return view('admin.pages.edit-add', ['page' => $page, 'is_add' => false]);
        } else {
            return redirect()->route('admin.not_found');
        }
    }

    public function edit(UpdatePageRequest $request)
    {
        try {
            $page = $this->pageRepo->getById($request->id);
            $old_image = $this->imgRepo->getByPath($page->image);
            $image_path = "";
            if ($request->hasFile('image')) {
                if ($old_image) {
                    $image_path = $this->imgRepo->getById($this->uploadImage($request->file('image'), $request->slug, $this->upload_dir, $this->public_dir, $this->imgRepo, "page-image", $old_image->id))->path;
                } else {
                    $image_path = $this->imgRepo->getById($this->uploadImage($request->file('image'), $request->slug, $this->upload_dir, $this->public_dir, $this->imgRepo, "page-image"))->path;
                }
            }
            $request->image_path = $image_path != '' ? $image_path : @$old_image->path;
            $this->pageRepo->update($this->getMergePageData($request));
            return redirect()->route('admin.pages')->with('message', ['content' => __('message.update_success', ['name' => __('page.page')]), 'type' => 'success']);
        } catch (Exception $exception) {
            return back()->with('message', ['content' => __('message.server_error'), 'type' => 'error']);
        }
    }

    public function delete($id)
    {
        return $this->pageRepo->destroy($id);
    }

    public function detail($id)
    {
        $page = $this->pageRepo->getById($id);
        return view('admin.pages.browser', compact('page'));
    }

    public function search(Request $request)
    {
        $pages = [];
        if ($request->search_query) {
            $pages = $this->pageRepo->search($request->search_query);
        }
        return view('admin.pages.index', ['pages' => $pages, 'query' => $request->search_query]);
    }
}
