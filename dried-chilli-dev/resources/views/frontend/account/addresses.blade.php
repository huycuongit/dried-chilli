@extends('frontend.account.layout')

@section('title', 'Address Book')

@section('account-content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 class="serif-title" style="margin-bottom: 0;">Address Book</h2>
        <button class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem;">Add New Address</button>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        @forelse($addresses as $address)
        <div class="account-card" style="margin-bottom: 0; {{ $address->is_default ? 'border: 2px solid var(--spice-primary);' : '' }}">
            <div class="card-body">
                <h5 style="margin: 0 0 1rem 0; font-family: var(--font-heading); font-size: 1.2rem; display: flex; justify-content: space-between; align-items: center;">
                    {{ $address->name }}
                    @if($address->is_default) 
                        <span class="status-badge" style="background: var(--spice-primary); color: white; font-size: 0.65rem;">Default</span>
                    @endif
                </h5>
                <p style="margin: 0 0 0.5rem 0; color: #5C4B41;"><strong>Phone:</strong> {{ $address->phone }}</p>
                <p style="margin: 0 0 1.5rem 0; color: #888; line-height: 1.5;">{{ $address->address }}<br>{{ $address->city }}</p>
                
                <div style="display: flex; gap: 1rem; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1rem;">
                    <a href="#" style="color: var(--spice-primary); text-decoration: none; font-weight: 600; font-size: 0.9rem;">Edit</a>
                    <a href="#" style="color: #d9534f; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Delete</a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1;">
            <p class="empty-state">You have not saved any addresses yet.</p>
        </div>
        @endforelse
    </div>
@endsection
