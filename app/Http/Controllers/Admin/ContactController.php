<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Datatables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index', [
            'permissions' => Auth::user()->getAllCheckPermissions()->toArray(),
        ]);
    }

    public function datatables(Request $request): JsonResponse
    {
        $contacts = Contact::query()
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = $request->string('keyword')->trim()->toString();
                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('full_name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%")
                        ->orWhere('phone', 'like', "%{$keyword}%")
                        ->orWhere('company', 'like', "%{$keyword}%")
                        ->orWhere('message', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('id');

        return DataTables::of($contacts)
            ->editColumn('created_at', fn (Contact $contact) => optional($contact->created_at)->format('d/m/Y H:i'))
            ->addColumn('action', fn () => true)
            ->make(true);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['new', 'contacted', 'done'])],
        ]);

        $contact = Contact::query()->findOrFail($id);
        $contact->update($data);

        return response()->json(['message' => 'Contact status updated successfully.']);
    }
}
