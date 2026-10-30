<section class="section appendix">
    <h2>Phụ lục 01 · Phạm vi công việc và quyền bàn giao</h2>
    <p>Kèm theo Hợp đồng số {{ $contract->contract_number }}</p>
    <table class="items"><tbody>
        @foreach (config('website-contract.fields.project') as $key => $label)
            <tr><th>{{ $label }}</th><td class="preline">{{ $contract->website_details[$key] ?? 'Chưa cung cấp' }}</td></tr>
        @endforeach
        <tr><th>Quyền sử dụng website</th><td>Bên B được quyền sử dụng website theo Điều 8 của Hợp đồng.</td></tr>
        <tr><th>Mã nguồn</th><td>NAFU Services giữ mã nguồn; KHÔNG bàn giao mặc định.</td></tr>
    </tbody></table>
    <h2 style="margin-top:24px">Thông tin NAFU Care</h2>
    <table class="items"><tbody>
        @foreach (config('website-contract.fields.care') as $key => $label)
            <tr><th>{{ $label }}</th><td class="preline">{{ $contract->website_details[$key] ?? 'Chưa cung cấp' }}</td></tr>
        @endforeach
    </tbody></table>
</section>
