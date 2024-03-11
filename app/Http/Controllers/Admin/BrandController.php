<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Repositories\Brand\BrandInterface;
use App\Repositories\Image\ImageInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandRepo;
    private $imgRepo;
    private $upload_dir;
    private $public_dir;

    public function __construct(ImageInterface $imgRepo, BrandInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
        $this->imgRepo = $imgRepo;
        $this->upload_dir = config('constants.BRAND_UPLOAD_DIR');
        $this->public_dir = config('constants.BRAND_ROOT_PATH');
    }

    public function index()
    {
        $brands = $this->brandRepo->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function showCreateForm()
    {
        $is_add = true;
        return view('admin.brands.edit-add', compact('is_add'));
    }

    public function showEditForm($id)
    {
        $is_add = false;
        $brand = $this->brandRepo->getById($id);
        return view('admin.brands.edit-add', compact('is_add', 'brand'));
    }

    public function create(CreateBrandRequest $request)
    {
        $brand_image = $request->file('image');
        $image_id = $this->uploadImage($brand_image, $request->name, $this->upload_dir, $this->public_dir, $this->imgRepo, 'brand image');
        return $this->brandRepo->store(['name' => $request->name, 'image_id' => $image_id]);
    }

    public function edit(UpdateBrandRequest $request)
    {
        try {
            $brand = $this->brandRepo->getById($request->id);
            if ($request->hasFile('image')) {
                $this->uploadImage($request->file('image'), $request->name, $this->upload_dir, $this->public_dir, $this->imgRepo, 'brand image', $brand->image->id  );
            }
            $this->brandRepo->update($request);
            return redirect()->route('admin.brands')->with('message', ['content' => __('message.update_success', ['name' => $request->name]), 'type' => 'success']);
        } catch (\Exception $e) {
            return back()->with('message', ['content' => __('message.update_failed', ['name' => __('brand.brand_in_lang')]), 'type' => 'error'])->withInput();
        }
    }

    public function delete($id)
    {
        return $this->brandRepo->destroy($id);
    }

    public function deleteAll(Request $request)
    {
        return $this->brandRepo->destroyAll($request->json()->all());
    }

    public function detail($id)
    {
        $brand = $this->brandRepo->getById($id);
        return view('admin.brands.browser', compact('brand'));
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $brands = $this->brandRepo->search($query);
        return view('admin.brands.index', compact('brands', 'query'));
    }
}
