<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateStatusRequest;
use App\Http\Requests\Admin\UpdateStatusRequest;
use App\Repositories\Status\StatusInterface;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    private $statusRepo;

    public function __construct(StatusInterface $status)
    {
        $this->statusRepo = $status;
    }

    public function index()
    {
        $status = $this->statusRepo->get();
        return view('admin.status.index', compact('status'));
    }

    public function showCreateForm()
    {
        $is_add = true;
        return view('admin.status.edit-add', compact('is_add'));
    }

    public function create(CreateStatusRequest $request)
    {
        return $this->statusRepo->store($request);
    }

    public function showEditForm($id)
    {
        $is_add = false;
        $status = $this->statusRepo->getById($id);
        return view('admin.status.edit-add', compact('is_add', 'status'));
    }

    public function edit(UpdateStatusRequest $request)
    {
        return $this->statusRepo->update($request);
    }

    public function delete($id)
    {
        return $this->statusRepo->destroy($id);
    }

    public function deleteAll(Request $request)
    {
        return $this->statusRepo->destroyAll($request->json()->all());
    }

    public function detail($id)
    {
        $status = $this->statusRepo->getById($id);
        return view('admin.status.browser', compact('status'));
    }

    public function search(Request $request)
    {
        $query = $request->search_query;
        $status = $this->statusRepo->search($request->search_query);
        return view('admin.status.index', compact('status', 'query'));
    }
}
