<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectStoreRequest;
use App\Http\Requests\Admin\ProjectUpdateRequest;
use App\Repositories\ProjectRepositoryInterface;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct(protected ProjectRepositoryInterface $repository) {}
    public function index() { return view('admin.projects.index', ['permissions' => Auth::user()->getAllCheckPermissions()->toArray()]); }
    public function create() { return view('admin.projects.form'); }
    public function show($id) { return view('admin.projects.form', ['data' => $this->repository->find($id)]); }
    public function edit($id) { return view('admin.projects.form', ['data' => $this->repository->find($id)]); }
    public function datatables(Request $request) { return DataTables::of($this->repository->datatables($request->input()))->addColumn('action', fn() => true)->make(true); }
    public function store(ProjectStoreRequest $request) { $project = $this->repository->create($request->validated()); return redirect()->route('admin.projects.edit', $project->id)->with('success', 'Project created successfully.'); }
    public function update(ProjectUpdateRequest $request, $id) { $this->repository->update($id, $request->validated()); return redirect()->route('admin.projects.edit', $id)->with('success', 'Project updated successfully.'); }
    public function destroy(Request $request, $id) {
        $this->repository->delete($id);
        return $request->expectsJson()
            ? response()->json(['message' => 'Project deleted successfully'])
            : redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
