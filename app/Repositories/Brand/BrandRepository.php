<?php

namespace App\Repositories\Brand;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Post;

class BrandRepository extends Controller implements BrandInterface
{
    private Brand $brand;


    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function get()
    {
        return $this->brand::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->brand::find($id);
    }

    public function store($request)
    {
        try {
            $this->brand::create($request);
            return redirect()->route('admin.brands')->with('message', ['content' => __('message.create_success', ['name' => $request['name']]), 'type' => 'success']);
        } catch (\Exception $e) {
            return back()->with('message', ['content' => __('message.create_failed', ['name' => __('brand.brand_in_lang')]), 'type' => 'error']);
        }
    }

    public function update($request)
    {
        $brand = $this->brand::find($request->id);
        $brand->fill(['name' => $request->name])->save();
        return $brand;
    }

    public function destroy($id)
    {
        try {
            $brand = $this->brand::find($id);
            if ($this->hasPost($id)) {
                return response()->json(['message' => __('brand.has_post', ['name' => $brand->name])],400);
            }
            $this->deleteStorageFile($brand->image->path);
            $image = $brand->image;
            $brand->delete();
            $image->delete();
            return response()->json(['message' => __('brand.delete_success')]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('brand.delete_failed'), 500]);
        }
    }

    public function destroyAll($ids)
    {
        try {
            $brands = $this->brand::whereIn('id', $ids)->get();

            if (Post::whereIn('brand_id', $ids)->exists()) {
                return response()->json(['message' => __('brand.has_post', ['name' => ''])], 400);
            }
            foreach ($brands as $brand) {
                $this->deleteStorageFile($brand->image->path);
                $image = $brand->image;
                $brand->delete();
                $image->delete();
            }
            return response()->json(['message' => __('brand.delete_success')]);
        } catch (\Exception $exception) {
            return response()->json(['message' => __('brand.delete_failed')], 500);
        }
    }

    public function hasPost($id)
    {
        return Post::where('brand_id', $id)->exists();
    }

    public function search($query)
    {
        return $this->brand::where('name', 'LIKE', '%' . $query . '%')->paginate(config('constants.DATA_PER_PAGE'));
    }
}
