@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4 fw-bold">Privacy Policy</h1>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted">Last updated: {{ date('F d, Y') }}</p>
                    
                    <h4 class="fw-bold mt-4">1. Information We Collect</h4>
                    <p>We collect personal information such as your name, email address, shipping address, and payment details when you create an account or make a purchase.</p>
                    
                    <h4 class="fw-bold mt-4">2. How We Use Your Information</h4>
                    <p>Your information is used to process your orders, provide customer support, and improve our services. We may also send you promotional emails if you have opted in.</p>
                    
                    <h4 class="fw-bold mt-4">3. Data Security</h4>
                    <p>We implement industry-standard security measures to protect your personal information from unauthorized access, alteration, or disclosure.</p>
                    
                    <h4 class="fw-bold mt-4">4. Third-Party Sharing</h4>
                    <p>We do not sell or rent your personal information to third parties. We may share necessary details with trusted service providers (like shipping couriers) to fulfill your orders.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
