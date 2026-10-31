<!doctype html>
<html lang="en">
<body style="margin:0;background:#f3f6fa;font-family:Arial,sans-serif;color:#111827">
    <div style="max-width:620px;margin:30px auto;padding:34px;background:#fff;border-radius:20px">
        <img src="{{ asset('assets/imgs/logo-hori.webp') }}" alt="{{ $contract->provider_name }}" style="width:150px;height:auto">
        <h1 style="font-size:24px;margin:28px 0 12px">Service agreement {{ $contract->contract_number }}</h1>
        <p>Hello {{ $contract->customer_name }},</p>
        <p>{{ $contract->provider_name }} has sent you a service agreement to review and sign online.</p>
        <p style="margin:28px 0">
            <a href="{{ $contract->publicUrl() }}" style="display:inline-block;padding:13px 20px;color:#fff;background:#0868f4;border-radius:20px;text-decoration:none;font-weight:bold">Review and sign the agreement</a>
        </p>
        <p style="font-size:12px;color:#687083">This is a private link. Please do not forward this email to anyone who is not authorized to sign.</p>
    </div>
</body>
</html>
