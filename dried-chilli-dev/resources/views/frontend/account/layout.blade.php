@extends('frontend.layouts.master')

@section('meta')
    <title>@yield('title', 'My Account') | Dried Chili</title>
@endsection

@section('full-content')
<main class="account-main" style="padding-top: 140px; min-height: 80vh; background-color: var(--spice-bg-alt);">
    <div class="account-container">
        
        <!-- Sidebar -->
        <aside class="account-sidebar">
            <h2 class="sidebar-title">My Account</h2>
            <nav class="account-nav">
                <a href="{{ route('account.dashboard') }}" class="account-link {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('account.orders') }}" class="account-link {{ request()->routeIs('account.orders') || request()->routeIs('account.order_detail') ? 'active' : '' }}">Order History</a>
                <a href="{{ route('account.addresses') }}" class="account-link {{ request()->routeIs('account.addresses') ? 'active' : '' }}">Address Book</a>
                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();" class="account-link text-danger">Logout</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <section class="account-content">
            @yield('account-content')
        </section>
    </div>
</main>

<style>
    .account-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 3rem;
    }

    .sidebar-title {
        font-family: var(--font-heading);
        font-size: 2rem;
        color: #3B2A20;
        margin-bottom: 2rem;
    }

    .account-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .account-link {
        padding: 1rem 1.5rem;
        border-radius: 20px;
        color: #5C4B41;
        text-decoration: none;
        font-family: var(--font-body);
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .account-link:hover {
        background: rgba(255,255,255,0.5);
    }

    .account-link.active {
        background: var(--spice-bg);
        border: 1px solid rgba(0,0,0,0.05);
        color: var(--spice-primary);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .account-link.text-danger {
        color: #d9534f;
    }

    .welcome-text {
        font-size: 1.1rem;
        color: #5C4B41;
        margin-bottom: 2rem;
    }

    .account-card {
        background: var(--spice-bg);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        background: rgba(0,0,0,0.02);
        padding: 1.5rem 2rem;
        font-family: var(--font-body);
        font-weight: 800;
        font-size: 1.2rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        color: #3B2A20;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-body {
        padding: 2rem;
    }

    .empty-state {
        color: #888;
        font-style: italic;
    }

    .account-table {
        width: 100%;
        border-collapse: collapse;
    }

    .account-table th {
        text-align: left;
        padding: 1rem;
        border-bottom: 2px solid rgba(0,0,0,0.1);
        color: #5C4B41;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .account-table td {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        color: #3B2A20;
        vertical-align: middle;
    }

    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
    }
    
    .status-badge.pending { background: #ffeeba; color: #856404; }
    .status-badge.processing { background: #b8daff; color: #004085; }
    .status-badge.delivered { background: #c3e6cb; color: #155724; }
    .status-badge.canceled { background: #f5c6cb; color: #721c24; }

    .btn-outline-small {
        padding: 0.5rem 1rem;
        border: 1px solid #3B2A20;
        border-radius: 20px;
        color: #3B2A20;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-outline-small:hover {
        background: #3B2A20;
        color: #fff;
    }

    @media (max-width: 768px) {
        .account-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
