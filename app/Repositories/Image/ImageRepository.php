<?php

namespace App\Repositories\Image;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Str;

class ImageRepository extends Controller implements ImageInterface
{
    private Image $image;

    private $upload_dir;
    private $root_path;

    public function __construct(Image $image)
    {
        $this->image = $image;
        $this->upload_dir = config('constants.POST_UPLOAD_DIR');
        $this->root_path = config('constants.POST_ROOT_PATH');
    }

    public function get($request)
    {
        return $this->image::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->image::find($id);
    }

    public function store($request)
    {
        return $this->image::insertGetId([
            'path' => $request['path'],
            'alt' => $request['alt'],
        ]);
    }

    public function update($request, $id)
    {
        try {
            $image = $this->image::find($id);
            $image->fill($request);
            $image->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id)
    {
        $this->image::find($id)->delete();
    }

    public function savePostImage($post_id, $request)
    {
        $image_ids = [];
        foreach ($request->file('images') as $image) {
            $filename = $image->getClientOriginalName() . now()->timestamp . '_' . Str::random(10) . '_' . Str::slug($request->title, '-') . '.' . $image->extension();
            if ($image->storeAs($this->upload_dir, $filename)) {
                $id = $this->store(['path' => $this->root_path . '/' . $filename, 'alt' => 'post_image']);
                $image_ids[] = $id;
            }
        }

        $post_saved = Post::find($post_id);
        foreach ($image_ids as $image_id) {
            $post_saved->images()->attach($image_id);
        }
    }

    public function getByPath($image)
    {
        return $this->image::where('path', $image)->first();
    }
}
