@extends('frontend.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4 fw-bold">Terms of Service</h1>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <p class="text-muted">Last updated: {{ date('F d, Y') }}</p>
                    
                    <h4 class="fw-bold mt-4">1. Acceptance of Terms</h4>
                    <p>By accessing and using this website, you accept and agree to be bound by the terms and provisions of this agreement.</p>
                    
                    <h4 class="fw-bold mt-4">2. User Accounts</h4>
                    <p>You are responsible for maintaining the confidentiality of your account credentials. You agree to accept responsibility for all activities that occur under your account.</p>
                    
                    <h4 class="fw-bold mt-4">3. Pricing & Availability</h4>
                    <p>All prices are subject to change without notice. We reserve the right to modify or discontinue products at any time. In the event of a pricing error, we reserve the right to cancel any orders placed for that item.</p>
                    
                    <h4 class="fw-bold mt-4">4. Governing Law</h4>
                    <p>These terms shall be governed by and construed in accordance with the laws of the jurisdiction in which our company is registered, without regard to its conflict of law provisions.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
