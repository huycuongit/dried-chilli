<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['phone'])) {
            $data['phone_country'] = null;
        }
        $data['source'] = $data['source'] ?? 'home-book-a-call';
        $data['status'] = 'new';
        $data['ip_address'] = $request->ip();
        $data['user_agent'] = mb_substr((string) $request->userAgent(), 0, 1000);

        $contact = Contact::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Thank you! Dried Chili will be in touch shortly.',
                'id' => $contact->id,
            ], 201);
        }

        return back()->with('success', 'Thank you! Dried Chili will be in touch shortly.');
    }
}
