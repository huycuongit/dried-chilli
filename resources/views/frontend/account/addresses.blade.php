@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('account.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action">Order History</a>
                <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action active">Address Book</a>
                <a href="#" class="list-group-item list-group-item-action">Account Details</a>
                <a href="#" class="list-group-item list-group-item-action text-danger">Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Address Book</h2>
                <button class="btn btn-primary">Add New Address</button>
            </div>
            
            <div class="row">
                @forelse($addresses as $address)
                <div class="col-md-6 mb-3">
                    <div class="card h-100 {{ $address->is_default ? 'border-primary' : '' }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $address->name }} @if($address->is_default) <span class="badge bg-primary">Default</span> @endif</h5>
                            <p class="card-text mb-1"><i class="fas fa-phone"></i> {{ $address->phone }}</p>
                            <p class="card-text text-muted">{{ $address->address }}, {{ $address->city }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="#" class="text-decoration-none me-3">Edit</a>
                            <a href="#" class="text-danger text-decoration-none">Delete</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">You have not saved any addresses yet.</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
