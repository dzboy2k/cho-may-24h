<?php

namespace App\Repositories\Status;

use App\Models\Post;
use App\Models\Status;
use App\Http\Controllers\Controller;
use Mockery\Exception;

class StatusRepository extends Controller implements StatusInterface
{
    private Status $status;

    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    public function get()
    {
        return $this->status::paginate(config('constants.DATA_PER_PAGE'));
    }

    public function getById($id)
    {
        return $this->status::find($id);
    }

    public function store($request)
    {
        try {
            $this->status::create([
                'name' => $request->name,
                'type' => $request->type
            ]);
            return redirect()->route('admin.status')->with('message', ['content' => __('message.create_success', ['name' => $request->name]), 'type' => 'success']);
        } catch (Exception $exception) {
            return back()->with('message', ['content' => __('message.create_failed', ['name' => $request->name]), 'type' => 'error']);
        }
    }

    public function update($request)
    {
        try {
            $this->status::find($request->id)->fill(['name' => $request->name, 'type' => $request->type])->save();
            return redirect()->route('admin.status')->with('message', ['content' => __('message.update_success', ['name' => $request->name]), 'type' => 'success']);
        } catch (Exception $exception) {
            return back()->with('message', ['content' => __('message.update_failed', ['name' => $request->name]), 'type' => 'error']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->status::find($id)->delete();
            if ($this->hasPost($id)) {
                return response()->json(['message' => __('status.has_post')], 400);
            }
            return response()->json(['message' => __('status.delete_success')]);
        } catch (Exception $exception) {
            return response()->json(['message' => __('status.delete_failed')], 500);
        }
    }

    public function destroyAll($ids)
    {
        try {
            if (Post::whereIn('status_id', $ids)->exists()) {
                return response()->json(['message' => __('status.has_post')], 400);
            }
            $this->status::whereIn('id', $ids)->delete();
            return response()->json(['message' => __('status.delete_success')]);
        } catch (Exception $exception) {
            return response()->json(['message' => __('status.delete_failed')], 500);
        }
    }

    public function search($query)
    {
        return $this->status::where('name', 'LIKE', '%' . $query . '%')->paginate(config('constants.DATA_PER_PAGE'));
    }

    protected function hasPost($id)
    {
        return Post::where('status_id', $id)->exists();
    }
}
