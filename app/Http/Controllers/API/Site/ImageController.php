<?php

namespace App\Http\Controllers\API\Site;

use App\Http\Controllers\Controller;
use App\Repositories\Image\ImageInterface;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private $imgRepo;
    private $public_path;
    private $upload_path;

    public function __construct(ImageInterface $imgRepo)
    {
        $this->imgRepo = $imgRepo;
        $this->public_path = config('constants.PAGE_ROOT_PATH');
        $this->upload_path = config('constants.PAGE_UPLOAD_DIR');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $this->imgRepo
                ->getById($this
                    ->uploadImage($request
                        ->file('image'), 'page-image', $this->upload_path, $this->public_path, $this->imgRepo, 'page-image')
                )
                ->path;
            return response()->json(['path' => asset($path)]);
        } else {
            return response()->json(['message' => __('message.no_image')], 400);
        }
    }
}
