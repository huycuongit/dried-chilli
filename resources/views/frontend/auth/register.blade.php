@extends('frontend.layouts.master')

@section('meta')
    <title>Create Account | Dried Chili</title>
@endsection

@section('full-content')
<main class="auth-main" style="padding-top: 140px; min-height: 80vh; background-color: var(--spice-bg-alt); display: flex; align-items: center; justify-content: center;">
    <div class="auth-container">
        <h2 class="serif-title" style="text-align: center; margin-bottom: 2rem;">Create Account</h2>
        
        <form id="register-form" class="auth-form" action="{{ route('auth.submitRegister') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="8" placeholder="Create a password (min 8 chars)">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="Confirm your password">
            </div>

            <div class="form-actions" style="margin-top: 1.5rem;">
                <button type="submit" class="btn-primary" style="width: 100%;">Create Account</button>
            </div>
        </form>

        <p class="auth-footer" style="text-align: center; margin-top: 1.5rem;">
            Already have an account? <a href="{{ route('auth.login') }}" style="color: var(--spice-primary); font-weight: bold;">Sign in</a>
        </p>
    </div>
</main>

<style>
    .auth-container {
        background: var(--spice-bg);
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        width: 100%;
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
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password_confirmation').value;

            if (password !== confirm) {
                alert('Passwords do not match!');
                return;
            }
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            
            submitBtn.innerText = 'Creating Account...';
            submitBtn.disabled = true;

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({status: response.status, body: data})))
            .then(res => {
                if (res.status === 200) {
                    window.location.href = res.body.redirect;
                } else {
                    let errorMsg = res.body.message || 'Registration failed.';
                    if (res.body.errors) {
                        errorMsg = Object.values(res.body.errors).flat().join('\n');
                    }
                    alert(errorMsg);
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
