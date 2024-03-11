<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function mapDataToParamsIfNeeded($data, $hypothetical_parameter, $params = [])
    {
        foreach ($hypothetical_parameter as $param) {
            if (isset($data[$param]) && $data[$param]) {
                $params[] = [$param, $data[$param]];
            }
        }
        return $params;
    }
    protected function mapDataToGetParamsIfNeeded($request, $hypothetical_parameter, $params = [])
    {
        foreach ($hypothetical_parameter as $param) {
            if ($request->has($param) && $request[$param]) {
                $params[] = [$param, $request[$param]];
            }
        }
        return $params;
    }

    protected function uploadImage($image, $name, $upload_dir, $public_dir, $imageRepo, $alt, $id = null)
    {
        $filename = now()->unix() . '-' . Str::slug($name, '-') . '.' . $image->extension();
        if ($image->storeAs($upload_dir, $filename)) {
            if ($id !== null) {
                return $imageRepo->update(['path' => $public_dir . '/' . $filename, 'alt' => $alt], $id);
            }
            return $imageRepo->store(['path' => $public_dir . '/' . $filename, 'alt' => $alt]);
        }
        return null;
    }

    protected function deleteStorageFile($path)
    {
        Storage::disk('public')->delete(str_replace('storage', '', $path));
    }
}
