<?php
require __DIR__ . '/../app/Support/QuickContractItems.php';
use App\Support\QuickContractItems;
function checkQuick($condition) { if (!$condition) { throw new RuntimeException('Quick contract check failed'); } }
$first = ['name' => 'Website', 'name_vi' => 'Thiết kế web', 'description' => 'Design', 'description_vi' => 'Gói website', 'contract_price' => '15000000'];
$second = ['name' => 'Care', 'name_vi' => '', 'description' => 'Maintenance', 'description_vi' => '', 'contract_price' => '2000000'];
$result = QuickContractItems::build([$first, $second]);
checkQuick($result['total'] == 17000000);
checkQuick(count($result['items']) === 2 && $result['items'][1]['name'] === 'Care');
checkQuick($result['items'][0]['name'] === 'Thiết kế web');
$second['contract_price'] = 0;
checkQuick(QuickContractItems::build([$second])['total'] == 0);
$first['contract_price'] = '0.10'; $second['contract_price'] = '0.20';
checkQuick(QuickContractItems::build([$first, $second])['total'] === 0.3);
foreach ([[], [array_merge($first, ['contract_price' => null])], [array_merge($first, ['contract_price' => -1])], [array_merge($first, ['contract_price' => 9999999999999]), array_merge($second, ['contract_price' => 9999999999999])]] as $bad) {
    try { QuickContractItems::build($bad); } catch (InvalidArgumentException $e) { continue; }
    throw new RuntimeException('Invalid service pricing accepted');
}
$config = require __DIR__ . '/../config/website-contract.php';
$keys = array_merge(...array_values(array_map('array_keys', $config['fields'])));
checkQuick(in_array('PAYMENT_SCHEDULE', $keys, true));
echo "Passed quick contract totals, pricing validation and PHP 8 named-array regression checks.\n";
