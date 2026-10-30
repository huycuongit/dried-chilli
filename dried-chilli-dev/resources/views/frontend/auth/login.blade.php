@extends('frontend.layouts.master')

@section('meta')
    <title>Login | Dried Chili</title>
@endsection

@section('full-content')
<main class="auth-main" style="min-height: 80vh; background-color: var(--spice-bg-alt); display: flex; align-items: center; justify-content: center;">
    <div class="auth-container">
        <h2 class="serif-title" style="text-align: center; margin-bottom: 2rem;">Welcome Back</h2>
        
        <form id="login-form" class="auth-form" action="{{ route('auth.submitLogin') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>

            <div class="form-actions" style="margin-top: 1.5rem;">
                <button type="submit" class="btn-primary" style="width: 100%;">Sign In</button>
            </div>
        </form>

        <p class="auth-footer" style="text-align: center; margin-top: 1.5rem;">
            Don't have an account? <a href="{{ route('auth.register') }}" style="color: var(--spice-primary); font-weight: bold;">Create one</a>
        </p>
    </div>
</main>

<style>
    .auth-container {
        background: var(--spice-bg);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        max-width: 450px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-family: var(--font-body);
        font-weight: 600;
        color: #3B2A20;
    }

    .form-group input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid rgba(59, 42, 32, 0.2);
        border-radius: 20px;
        font-family: var(--font-body);
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--spice-primary);
        box-shadow: 0 0 0 3px rgba(219, 123, 82, 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            
            submitBtn.innerText = 'Signing in...';
            submitBtn.disabled = true;

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Đăng nhập thành công') {
                    window.location.href = "{{ route('page.index') }}";
                } else {
                    alert(data.message || 'Login failed. Please check your credentials.');
                    submitBtn.innerText = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                submitBtn.innerText = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
@endsection
