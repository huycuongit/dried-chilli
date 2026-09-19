<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceStoreRequest;
use App\Http\Requests\Admin\ServiceUpdateRequest;
use App\Repositories\ServiceRepositoryInterface;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct(protected ServiceRepositoryInterface $repository) {}
    public function index() { return view('admin.services.index', ['permissions' => Auth::user()->getAllCheckPermissions()->toArray()]); }
    public function create() { return view('admin.services.form'); }
    public function show($id) { $service = $this->repository->find($id); return view('admin.services.form', ['data' => $service, 'metaData' => $service->meta]); }
    public function edit($id) { $service = $this->repository->find($id); return view('admin.services.form', ['data' => $service, 'metaData' => $service->meta]); }
    public function datatables(Request $request) { return DataTables::of($this->repository->datatables($request->input()))->addColumn('action', fn () => true)->make(true); }

    public function store(ServiceStoreRequest $request)
    {
        $service = $this->repository->create($request->validated());
        return redirect()->route('admin.services.edit', $service->id)->with('success', 'Service created successfully.');
    }

    public function update(ServiceUpdateRequest $request, $id)
    {
        $this->repository->update($id, $request->validated());
        return redirect()->route('admin.services.edit', $id)->with('success', 'Service updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $this->repository->delete($id);
        return $request->expectsJson()
            ? response()->json(['message' => 'Service deleted successfully.'])
            : redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}
