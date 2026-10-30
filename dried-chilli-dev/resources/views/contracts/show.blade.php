<!doctype html>
<html lang="{{ $contract->locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow,noarchive">
    <title>{{ $contract->contract_number }} — {{ $contract->provider_name }}</title>
    <link rel="icon" href="{{ asset('assets/favicon/favicon.ico') }}">
    <style>
        :root{--ink:#111827;--muted:#687083;--line:#dfe4ec;--blue:#0868f4;--paper:#fff}*{box-sizing:border-box}body{margin:0;color:var(--ink);background:#eef2f7;font:15px/1.55 Arial,sans-serif}.toolbar{position:sticky;top:0;z-index:10;padding:12px 20px;display:flex;justify-content:center;gap:10px;background:rgba(238,242,247,.9);backdrop-filter:blur(12px)}button{font:inherit}.button{padding:10px 17px;color:#fff;background:#0868f4;border:0;border-radius:20px;font-weight:700;cursor:pointer}.button.secondary{color:#263145;background:#fff;border:1px solid var(--line)}.paper{width:min(920px,calc(100% - 28px));margin:14px auto 50px;padding:64px 70px;background:var(--paper);box-shadow:0 18px 60px rgba(22,34,55,.1)}.brand{display:flex;justify-content:space-between;align-items:flex-start;padding-bottom:26px;border-bottom:2px solid var(--ink)}.brand img{width:70px;height:70px;object-fit:contain}.brand-address{text-align:right;color:var(--muted);font-size:12px}.contract-heading{text-align:center;padding:34px 0}.contract-heading h1{margin:0;font-size:27px}.contract-heading p{margin:6px 0 0;color:var(--muted)}.party-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:30px}.party{padding:20px;border:1px solid var(--line);border-radius:20px 20px 20px 0 20px;font-size:14px;text-transform:uppercase;letter-spacing:.08em}.party p{margin:4px 0}.section{margin-top:30px}.preline{white-space:pre-line}.items{width:100%;border-collapse:collapse}.items th,.items td{padding:12px 10px;text-align:left;border:1px solid var(--line);vertical-align:top}.items th{background:#f5f7fa;font-size:12px}.items .number{text-align:right;white-space:nowrap}.summary{width:min(380px,100%);margin:18px 0 0 auto}.summary div{display:flex;justify-content:space-between;padding:5px 0}.summary .total{margin-top:6px;padding-top:12px;border-top:2px solid var(--ink);font-size:18px;font-weight:700}.signatures{display:grid;grid-template-columns:1fr 1fr;gap:28px;margin-top:45px}.signature-box{min-height:170px;padding:20px;text-align:center;border:1px solid var(--line);border-radius:20px 20px;max-width:230px;max-height:110px;margin:10px auto}.signature-form{margin-top:40px;padding:28px;border:1px solid #bcd3ff;border-radius:20px;background:#f6f9ff}.signature-form h2{margin-top:0}.signature-form input[type=text]{width:100%;padding:12px;border:1px solid var(--line);border-radius:20px;font:inherit}.signature-pad{width:100%;height:210px;margin:12px 0 8px;display:block;touch-action:none;background:#fff;border:1px dashed #8da4ca;border-radius:20px;align-items:flex-start;gap:9px;margin:17px 0}.notice{padding:13px 16px;margin-bottom:18px;border-radius:20px;background:#def7e8;color:#126d3b}.error{color:#b42318;font-size:13px}.audit{margin-top:30px;padding:15px;border-radius:20px;background:#f5f7fa;color:var(--muted);font-size:12px;word-break:break-all}@media(max-width:700px){.paper{padding:34px 20px}.party-grid,.signatures{grid-template-columns:1fr}.brand{display:block}.brand-address{text-align:left;margin-top:15px}.items{font-size:12px}.items th,.items td{padding:8px 6px}.hide-mobile{display:none}}@media print{body{background:#fff}.toolbar,.signature-form{display:none!important}.paper{width:100%;margin:0;padding:25px;box-shadow:none}} 
        .mobile-description{display:none}.appendix th{width:32%}.appendix td{overflow-wrap:anywhere}.party{overflow-wrap:anywhere}.preline{overflow-wrap:anywhere}
        @media(max-width:700px){.mobile-description{display:block;font-size:12px;margin-top:6px}.items .number{white-space:normal}.items{min-width:100%}}
        @media print{.appendix{break-before:page}.items tr,.signatures,.signature-box{break-inside:avoid}thead{display:table-header-group}.section h2{break-after:avoid}.hide-mobile{display:table-cell}.mobile-description{display:none}}
    </style>
</head>
<body>
@php
    $money = fn ($amount) => number_format((float) $amount, $contract->currency === 'VND' ? 0 : 2, ',', '.') . ' ' . $contract->currency;
    $incomplete = !$contract->isSigned() && $contract->hasUnfilledTerms();
    $website = $contract->website_details !== null;
    $expired = $contract->expires_at && $contract->expires_at->copy()->endOfDay()->isPast();
@endphp
<div class="toolbar"><button class="button secondary" type="button" onclick="window.print()">In / Lưu PDF</button>@if (!$contract->isSigned() && !$expired && !$incomplete)<button class="button" type="button" onclick="document.querySelector('.signature-form').scrollIntoView({behavior:'smooth'})">Ký hợp đồng</button>@endif</div>
<article class="paper">
    @if (session('signed_success'))<div class="notice">✓ {{ session('signed_success') }}</div>@endif
    <header class="brand"><img src="{{ asset('assets/imgs/logo.webp') }}" alt="{{ $contract->provider_name }}"><div class="brand-address"><strong>{{ $contract->provider_legal_name ?: $contract->provider_name }}</strong>@if($contract->provider_tax_id)<br>MST: {{ $contract->provider_tax_id }}@endif @if($contract->provider_address)<br>{{ $contract->provider_address }}@endif @if($contract->provider_email)<br>{{ $contract->provider_email }}@endif @if($contract->provider_phone)<br>{{ $contract->provider_phone }}@endif</div></header>
    <div class="contract-heading">@if($website)<p><strong>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong><br>Độc lập - Tự do - Hạnh phúc</p>@endif<h1>{{ $contract->title }}</h1><p>Số: {{ $contract->contract_number }} · Ngày hiệu lực: {{ optional($contract->effective_date)->format('d/m/Y') ?: 'Theo ngày ký' }}</p></div>

    <div class="party-grid"><section class="party"><h2>Bên cung cấp dịch vụ (Bên A)</h2><p><strong>{{ $contract->provider_legal_name ?: $contract->provider_name }}</strong></p>@if($contract->provider_tax_id)<p>MST: {{ $contract->provider_tax_id }}</p>@endif @if($contract->provider_address)<p>{{ $contract->provider_address }}</p>@endif@if($website)<p>Đại diện: {{ $contract->website_details['FEB_REPRESENTATIVE'] ?? '' }}</p><p>Chức vụ: {{ $contract->website_details['FEB_POSITION'] ?? '' }}</p><p class="preline">Tài khoản: {{ $contract->website_details['FEB_BANK_INFO'] ?? '' }}</p>@endif</section><section class="party"><h2>Bên sử dụng dịch vụ (Bên B)</h2><p><strong>{{ $contract->customer_company ?: $contract->customer_name }}</strong></p><p>Đại diện: {{ $contract->customer_name }}</p>@if($website)<p>Chức vụ: {{ $contract->website_details['CUSTOMER_POSITION'] ?? '' }}</p>@endif<p>{{ $contract->customer_email }}@if($contract->customer_phone) · {{ $contract->customer_phone }}@endif</p>@if($contract->customer_tax_id)<p>MST / CCCD: {{ $contract->customer_tax_id }}</p>@endif @if($contract->customer_address)<p>{{ $contract->customer_address }}</p>@endif</section></div>

    @if($contract->scope_summary)<section class="section"><h2>Phạm vi công việc</h2><div class="preline">{{ $contract->resolvedText($contract->scope_summary) }}</div></section>@endif
    <section class="section"><h2>{{ $website ? 'Điều 1. Nội dung dịch vụ và giá trị hợp đồng' : 'Sản phẩm và dịch vụ cung cấp' }}</h2><div style="overflow-x:auto"><table class="items"><thead><tr><th>#</th><th>Hạng mục</th><th class="hide-mobile">Mô tả / tính năng</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead><tbody>@foreach($contract->items as $index => $item)<tr><td>{{ $index + 1 }}</td><td><strong>{{ $item->name }}</strong><span class="mobile-description preline">{{ $item->description }}</span></td><td class="hide-mobile preline">{{ $item->description }}</td><td>{{ rtrim(rtrim(number_format((float)$item->quantity,2,'.',''),'0'),'.') }} {{ $item->unit }}</td><td class="number">{{ $money($item->unit_price) }}</td><td class="number">{{ $money($item->amount) }}</td></tr>@endforeach</tbody></table></div><div class="summary"><div><span>Tạm tính</span><span>{{ $money($contract->subtotal) }}</span></div><div><span>Thuế ({{ rtrim(rtrim($contract->tax_rate,'0'),'.') }}%)</span><span>{{ $money($contract->tax_amount) }}</span></div><div class="total"><span>Tổng cộng</span><span>{{ $money($contract->total) }}</span></div></div></section>

    @if($website)<p>{{ config('website-contract.tax_note') }}</p>@endif
    @if($contract->payment_terms)<section class="section"><h2>{{ $website ? 'Điều 2. Thanh toán' : 'Điều khoản thanh toán' }}</h2><div class="preline">{{ $contract->resolvedText($contract->payment_terms) }}</div></section>@endif

    <section class="section"><h2>Điều khoản hợp đồng</h2><div class="preline">{{ $contract->resolvedText($contract->terms) }}</div></section>
    @if($website)
        @include('contracts.website-appendix')
    @endif

    <div class="signatures"><div class="signature-box"><strong>ĐẠI DIỆN BÊN CUNG CẤP</strong><p>{{ $contract->provider_legal_name ?: $contract->provider_name }}</p>@if($website)<p>{{ $contract->website_details['FEB_REPRESENTATIVE'] ?? '' }}</p>@endif</div><div class="signature-box"><strong>ĐẠI DIỆN KHÁCH HÀNG</strong>@if($contract->isSigned())<img src="{{ $contract->signature_data }}" alt="Chữ ký của {{ $contract->signature_name }}"><p><strong>{{ $contract->signature_name }}</strong><br>Đã ký lúc {{ $contract->signed_at->format('d/m/Y H:i:s') }}</p>@else<p>Chưa ký</p>@endif</div></div>

    @if ($contract->isSigned())
        <div class="audit">Mã xác thực nội dung: {{ $contract->signed_payload_hash }}<br>Thời gian ký: {{ $contract->signed_at->toIso8601String() }} · IP: {{ $contract->signature_ip }}</div>
    @elseif ($incomplete)
        <div class="signature-form"><h2>Hợp đồng đang được hoàn thiện</h2><p>Vui lòng liên hệ {{ $contract->provider_name }} để bổ sung thông tin trước khi ký.</p></div>
    @elseif ($expired)
        <div class="signature-form"><h2>Hợp đồng đã hết hạn ký</h2><p>Vui lòng liên hệ {{ $contract->provider_name }} để được cấp lại hợp đồng.</p></div>
    @else
        <form class="signature-form" method="POST" action="{{ route('contracts.sign', $contract->public_token) }}" id="signature-form">
            @csrf
            <h2>Ký xác nhận hợp đồng</h2><p>Vui lòng nhập họ tên và ký trực tiếp trong khung bên dưới.</p>
            @if(isset($errors) && $errors->any())<div class="error"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <label>Họ và tên người ký<input type="text" name="signature_name" required value="{{ old('signature_name', $contract->customer_name) }}"></label>
            <canvas class="signature-pad" id="signature-pad"></canvas><input type="hidden" name="signature_data" id="signature-data"><button class="button secondary" id="clear-signature" type="button">Ký lại</button>
            <label class="consent"><input type="checkbox" name="signature_consent" value="1" required><span>Tôi đã đọc và đồng ý toàn bộ nội dung hợp đồng cùng phụ lục kèm theo (nếu có), xác nhận có thẩm quyền ký và chữ ký điện tử này do tôi thực hiện.</span></label>
            <button class="button" type="submit">Xác nhận và ký hợp đồng</button>
        </form>
    @endif
</article>
@if (!$contract->isSigned() && !$expired && !$incomplete)
<script>
(() => {
    const canvas = document.querySelector('#signature-pad'); const form = document.querySelector('#signature-form'); const output = document.querySelector('#signature-data'); if (!canvas || !form || !output) return;
    const context = canvas.getContext('2d'); let drawing = false; let hasSignature = false;
    const resize = () => { const ratio = Math.max(window.devicePixelRatio || 1, 1); const rect = canvas.getBoundingClientRect(); canvas.width = rect.width * ratio; canvas.height = rect.height * ratio; context.setTransform(ratio,0,0,ratio,0,0); context.lineWidth = 2.2; context.lineCap = 'round'; context.strokeStyle = '#111827'; };
    const point = (event) => { const rect = canvas.getBoundingClientRect(); return {x:event.clientX-rect.left,y:event.clientY-rect.top}; };
    canvas.addEventListener('pointerdown', (event) => { drawing=true; hasSignature=true; canvas.setPointerCapture(event.pointerId); const p=point(event); context.beginPath(); context.moveTo(p.x,p.y); });
    canvas.addEventListener('pointermove', (event) => { if(!drawing)return; const p=point(event); context.lineTo(p.x,p.y); context.stroke(); });
    ['pointerup','pointercancel'].forEach(name => canvas.addEventListener(name, () => drawing=false));
    document.querySelector('#clear-signature').addEventListener('click', () => { context.clearRect(0,0,canvas.width,canvas.height); hasSignature=false; output.value=''; });
    form.addEventListener('submit', (event) => { if(!hasSignature){event.preventDefault(); alert('Vui lòng ký tên trong khung chữ ký.'); return;} output.value=canvas.toDataURL('image/png'); });
    resize();
})();
</script>
@endif
</body>
</html>
