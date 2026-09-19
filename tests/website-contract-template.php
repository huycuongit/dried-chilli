<?php
// Standalone tests for template content; no database or vendor installation needed.
require __DIR__ . '/../app/Support/WebsiteContractTemplate.php';
use App\Support\WebsiteContractTemplate as Template;
$config = require __DIR__ . '/../config/website-contract.php';
$checks = 0;
function check($condition, $message) {
    global $checks;
    if (!$condition) { throw new RuntimeException($message); }
    $checks++;
}
$details = [];
foreach ($config['fields'] as $fields) {
    foreach ($fields as $key => $label) { $details[$key] = 'Không áp dụng'; }
}
$details['PROJECT_TIMELINE'] = '30 ngày';
$text = $config['terms'] . "\n" . $config['payment_terms'];
$resolved = Template::resolve($text, $details, '13/09/2026');
check(!Template::incomplete($resolved, $details, $config['fields']), 'Completed contract must be signable');
check(strpos($resolved, '30 ngày') !== false, 'Timeline must be substituted');
check(strpos($resolved, '13/09/2026') !== false, 'Effective date must be substituted');
check(Template::incomplete($text, [], $config['fields']), 'Blank draft must not be signable');
$missing = $details; unset($missing['SOURCE_HANDOVER']);
check(Template::incomplete($resolved, $missing, $config['fields']), 'Missing appendix field must block signing');
$missing = $details; $missing['BACKUP_POLICY'] = '  ';
check(Template::incomplete($resolved, $missing, $config['fields']), 'Whitespace is not completed information');
check(Template::incomplete('[UNKNOWN]', $details, $config['fields']), 'Unknown placeholders must block signing');
check(!Template::incomplete('Existing general contract', null, $config['fields']), 'Legacy contracts must not require website fields');
check(Template::resolve('[EFFECTIVE_DATE]', [], 'ngày ký') === 'ngày ký', 'Date fallback');
check(strpos($resolved, '8.7.') !== false && strpos($resolved, '12.4.') !== false, 'Source-code and final clauses must be present');
for ($i = 3; $i <= 12; $i++) { check(strpos($config['terms'], "ĐIỀU {$i}.") !== false, "Missing article {$i}"); }
preg_match_all('/\[([A-Z_]+)\]/', $text, $matches);
foreach ($matches[1] as $key) { check($key === 'EFFECTIVE_DATE' || array_key_exists($key, $details), "No input defined for {$key}"); }
echo "Passed {$checks} template checks.\n";
