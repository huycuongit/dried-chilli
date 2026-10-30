<?php
namespace App\Support;

use InvalidArgumentException;

class QuickContractItems
{
    public static function build(array $services): array
    {
        if (!$services) { throw new InvalidArgumentException('Vui lòng chọn ít nhất một dịch vụ.'); }
        $items = [];
        $cents = 0;
        foreach ($services as $service) {
            if (!isset($service['contract_price']) || !is_numeric($service['contract_price']) || $service['contract_price'] < 0) {
                throw new InvalidArgumentException('Dịch vụ ' . $service['name'] . ' chưa được cấu hình giá hợp lệ.');
            }
            $price = (int) round((float) $service['contract_price'] * 100);
            $cents += $price;
            if ($cents > 999999999999999) { throw new InvalidArgumentException('Tổng giá trị hợp đồng vượt giới hạn cho phép.'); }
            $items[] = [
                'name' => $service['name_vi'] ?: $service['name'],
                'description' => strip_tags($service['description_vi'] ?: $service['description']),
                'quantity' => 1, 'unit' => 'gói', 'unit_price' => $price / 100,
            ];
        }
        return ['items' => $items, 'total' => $cents / 100];
    }
}
