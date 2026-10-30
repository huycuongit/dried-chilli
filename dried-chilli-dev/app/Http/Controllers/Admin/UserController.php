<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected RoleRepositoryInterface $roleRepository
    ) {
    }

    public function index()
    {
        return view('admin.users.index', [
            'roles' => $this->roleRepository->filter(['active' => ACTIVE]),
            'users' => $this->userRepository->all()->count(),
            'userActive' => $this->userRepository->filter(['active' => 1])->count(),
            'userInActive' => $this->userRepository->filter(['active' => 0])->count(),
            'permissions' => Auth::user()->getAllCheckPermissions()->toArray(),
        ]);
    }

    public function create()
    {
        return view('admin.users.form', [
            'roles' => $this->roleRepository->filter(['active' => ACTIVE]),
        ]);
    }

    public function show($id)
    {
        $data = $this->userRepository->find($id);

        return view('admin.users.form', compact('data'));
    }

    public function datatables(Request $request)
    {
        return DataTables::of($this->userRepository->datatables($request->input()))
            ->addColumn('role_ids', fn ($data) => $data->roles->pluck('id')->toArray())
            ->addColumn('roles', fn ($data) => $data->roles->pluck('name')->implode(', '))
            ->addColumn('action', fn () => true)
            ->make(true);
    }

    public function edit($id)
    {
        $data = $this->userRepository->find($id);

        return view('admin.users.form', [
            'data' => $data,
            'roles' => $this->roleRepository->filter(['active' => ACTIVE]),
            'metaData' => $data->meta,
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $new = $this->userRepository->create($request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => NOTIFICATION_CREATED_SUCCESS, 'id' => $new->id], 200);
        }

        return redirect()->route('admin.users.edit', ['id' => $new->id])->with('success', NOTIFICATION_CREATED_SUCCESS);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $this->userRepository->update($id, $request->validated());

        if ($request->ajax()) {
            return response()->json(['message' => NOTIFICATION_UPDATED_SUCCESS, 'id' => $id], 200);
        }

        return redirect()->route('admin.users.edit', ['id' => $id])->with('success', NOTIFICATION_UPDATED_SUCCESS);
    }

    public function destroy($id)
    {
        $this->userRepository->delete($id);

        return response()->json(['message' => NOTIFICATION_DELETED_SUCCESS], 200);
    }

    public function filter(Request $request)
    {
        $users = $this->userRepository->filter($request->all());

        return view('admin.users.index', compact('users'));
    }

    public function getAll(Request $request)
    {
        return response()->json($this->userRepository->filter(array_merge(['active' => 1], $request->all())));
    }
}