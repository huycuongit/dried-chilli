<?php
// Isolated process-level rotation test; no application or production database is used.
putenv('APP_ENV=testing');
require __DIR__.'/../../vendor/autoload.php';
$app=require __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$dbPath=$argv[1]??null;
if(!$dbPath){
 $dbPath=tempnam(sys_get_temp_dir(),'admin-jwt-race-');
 $gate=$dbPath.'.gate';
}else{$gate=$argv[3];}
config(['app.env'=>'testing','app.key'=>'base64:'.base64_encode(str_repeat('k',32)), 'database.default'=>'sqlite', 'database.connections.sqlite.database'=>$dbPath, 'session.secure'=>false]);
Illuminate\Support\Facades\DB::purge();
$makeRequest=function(){ $r=Illuminate\Http\Request::create('/admin/auth/refresh','POST'); $s=new Illuminate\Session\Store('test',new Illuminate\Session\ArraySessionHandler(120));$s->start();$r->setLaravelSession($s);return $r; };
if(isset($argv[2])){
 $r=$makeRequest();$r->cookies->set(App\Support\AdminJwt::REFRESH_COOKIE,$argv[2]);
 $deadline=microtime(true)+10;while(!file_exists($gate)&&microtime(true)<$deadline)usleep(10000);
 if(!file_exists($gate)){fwrite(STDERR,"gate timeout\n");exit(2);}
 echo (new App\Support\AdminJwt())->rotate($r) ? 'accepted' : 'rejected';
 exit;
}
try {
 $schema=Illuminate\Support\Facades\Schema::getFacadeRoot();
 $schema->create('admins',function($t){$t->id();$t->string('password');$t->boolean('active');});
 require __DIR__.'/../../database/migrations/2026_11_01_000002_create_admin_auth_sessions_table.php';(new CreateAdminAuthSessionsTable())->up();
 Illuminate\Support\Facades\DB::table('admins')->insert(['id'=>1,'password'=>'test-hash','active'=>1]);
 $admin=App\Models\Admin::findOrFail(1);$r=$makeRequest();$service=new App\Support\AdminJwt();$cookies=$service->start($r,$admin,true);$token=$cookies[1]->getValue();
 $processes=[];
 for($i=0;$i<2;$i++){
  $p=proc_open([PHP_BINARY,__FILE__,$dbPath,$token,$gate],[0=>['pipe','r'],1=>['pipe','w'],2=>['pipe','w']],$pipes);
  if(!is_resource($p))throw new RuntimeException('Unable to start worker');
  fclose($pipes[0]);$processes[]=[$p,$pipes];
 }
 usleep(500000);touch($gate);
 $out=[];foreach($processes as [$p,$pipes]){$out[]=stream_get_contents($pipes[1]);$err=stream_get_contents($pipes[2]);fclose($pipes[1]);fclose($pipes[2]);if(proc_close($p)!==0)throw new RuntimeException('Worker failed: '.$err);}
 sort($out);if($out!==['accepted','rejected'])throw new RuntimeException('Unexpected refresh outcomes: '.implode(',',$out));
 echo "PASS: two processes use one refresh token; exactly one rotation succeeds\n";
}finally{Illuminate\Support\Facades\DB::disconnect();if(is_file($gate))unlink($gate);if(is_file($dbPath))unlink($dbPath);}
