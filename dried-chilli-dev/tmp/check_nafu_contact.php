<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$request = new App\Http\Requests\StoreContactRequest();
$payload = ['full_name' => 'Nafu Preview', 'email' => 'preview@example.com', 'message' => 'Please help with home repairs.'];
foreach (array_merge(array_keys(config('nafu-services')), ['general-repairs', 'plumbing', 'electrical', 'other']) as $service) {
    $validator = Illuminate\Support\Facades\Validator::make($payload + ['project_type' => $service], $request->rules());
    if ($validator->fails()) { throw new RuntimeException($validator->errors()->toJson()); }
}
$invalid = Illuminate\Support\Facades\Validator::make($payload + ['project_type' => 'invalid-service'], $request->rules());
if (!$invalid->fails()) { throw new RuntimeException('Unknown service was accepted'); }
echo "Nafu service validation passed. No records created.\n";
