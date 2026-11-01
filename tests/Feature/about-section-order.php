<?php
putenv('APP_ENV=testing');putenv('CACHE_DRIVER=array');
$tempDir=sys_get_temp_dir().'/about-order-test-'.bin2hex(random_bytes(6));mkdir($tempDir,0700,true);
file_put_contents($tempDir.'/packages.php','<?php return [];');
putenv('APP_PACKAGES_CACHE='.$tempDir.'/packages.php');putenv('APP_SERVICES_CACHE='.$tempDir.'/services.php');putenv('VIEW_COMPILED_PATH='.$tempDir);
register_shutdown_function(function()use($tempDir){foreach(glob($tempDir.'/*') as $file)@unlink($file);@rmdir($tempDir);});
require __DIR__.'/../../vendor/autoload.php';
$providers=(require __DIR__.'/../../config/app.php')['providers'];
file_put_contents($tempDir.'/services.php','<?php return '.var_export(['providers'=>$providers,'eager'=>$providers,'deferred'=>[],'when'=>[]],true).';');
$app=require __DIR__.'/../../bootstrap/app.php';if(DIRECTORY_SEPARATOR==='\\')$app->addAbsoluteCachePathPrefix(substr($tempDir,0,3));
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['database.default'=>'sqlite','database.connections.sqlite.database'=>':memory:','session.driver'=>'array']);Illuminate\Support\Facades\DB::purge();
Illuminate\Support\Facades\Schema::create('systems',function($t){$t->id();$t->string('key')->unique();$t->longText('content')->nullable();$t->timestamps();});
$check=function($ok,$message){if(!$ok)throw new RuntimeException($message);};
$sections=App\Support\PageContentGroups::sections();$about=App\Support\PageContentGroups::fromSections($sections)['About Us'];
$check(isset($about['About Us - Hero'],$about['About Us - Section 1'],$about['About Us - Customer reviews'],$about['About Us - Call to Action']),'expected sections');
$default=App\Support\AboutSectionOrder::arrange($about,null);$defaultNames=array_keys($default);
$check(array_search('About Us - Section 1',$defaultNames)<array_search('About Us - Call to Action',$defaultNames),'default public order');
$oldOrder=array_values(array_filter($defaultNames,fn($name)=>$name!=='About Us - Customer reviews'));
$upgraded=array_keys(App\Support\AboutSectionOrder::arrange($about,json_encode($oldOrder)));
$check(array_search('About Us - Customer reviews',$upgraded)===array_search('About Us - Why Trust Us',$upgraded)+1,'existing saved order must place reviews after trust');
$content=[];foreach($about as $fields)foreach($fields as $key=>$field)if(!preg_match('/\.(css|js)(\?.*)?$/i',$field['value']??''))$content[$key]=(string)($field['value']??'');
$custom=$about['About Us - Section 1'];foreach($custom as $key=>$field){if(str_ends_with($key,'_published'))$content[$key]='1';if(str_ends_with($key,'_title'))$content[$key]='Unique custom marker';}
$order=['About Us - Section 1','About Us - What We Do','About Us - Hero'];foreach($defaultNames as $name)if(!in_array($name,$order,true))$order[]=$name;
$makeRequest=function($input)use($app){$r=Illuminate\Http\Request::create('/admin?page=About%20Us','PUT',$input);$s=new Illuminate\Session\Store('test',new Illuminate\Session\ArraySessionHandler(120));$s->start();$r->setLaravelSession($s);$app->instance('request',$r);return $r;};
$controller=new App\Http\Controllers\Admin\HomepageController();$controller->update($makeRequest(['selected_page'=>'About Us','content'=>$content,'section_order'=>$order]));
$settings=app(App\Support\SystemSettings::class)->all();$check(json_decode($settings[App\Support\AboutSectionOrder::STORAGE_KEY],true)===$order,'saved order');
view()->share('errors',new Illuminate\Support\ViewErrorBag());
$html=(new App\Http\Controllers\HomeController())->about()->render();
$posCustom=strpos($html,'<section class="about-pillar-section bg-alt about-custom-section">');$posCraft=strpos($html,'<section id="what-we-do"');$posHero=strpos($html,'<section class="about-hero-section">');
$check($posCustom!==false && $posCraft!==false && $posHero!==false && $posCustom<$posCraft && $posCraft<$posHero,'public order');
class AboutOrderTestAdmin extends App\Models\Admin {public function hasPermission($p){return true;}public function hasAnyPermission($p){return true;}public function getAllCheckPermissions(){return collect();}}
$admin=new AboutOrderTestAdmin();$admin->setRawAttributes(['id'=>1,'name'=>'Test','user_name'=>'Admin']);$admin->setRelation('roles',collect());auth()->guard('admin')->setUser($admin);
$editor=view('admin.homepage',['sections'=>$sections,'values'=>$settings,'faqs'=>collect()])->render();
$a=strpos($editor,'data-section-name="About Us - Section 1"');$b=strpos($editor,'data-section-name="About Us - What We Do"');$c=strpos($editor,'data-section-name="About Us - Hero"');
$check($a!==false&&$b!==false&&$c!==false&&$a<$b&&$b<$c,'admin restored order');
$check(str_contains($editor,'name="section_order[]"')&&str_contains($editor,'section-sort-handle')&&str_contains($editor,'data-move="up"'),'drag and keyboard controls');
$short=$order;array_pop($short);try{$controller->update($makeRequest(['selected_page'=>'About Us','content'=>$content,'section_order'=>$short]));throw new RuntimeException('incomplete order accepted');}catch(Illuminate\Validation\ValidationException $e){}
$bad=$order;$bad[0]='Unknown';try{$controller->update($makeRequest(['selected_page'=>'About Us','content'=>$content,'section_order'=>$bad]));throw new RuntimeException('unknown section accepted');}catch(Illuminate\Validation\ValidationException $e){}
$more=$about;$more['About Us - Section 99']=[];unset($more['About Us - Section 2']);$arranged=App\Support\AboutSectionOrder::arrange($more,json_encode($order));
$check(!isset($arranged['About Us - Section 2'])&&isset($arranged['About Us - Section 99'])&&count($arranged)===count($more),'removed and new sections reconciled');
$controller->deleteSection($makeRequest(['section'=>'About Us - Section 1']));
$savedAfterDelete=app(App\Support\SystemSettings::class)->all();
$remaining=json_decode($savedAfterDelete[App\Support\AboutSectionOrder::STORAGE_KEY],true);
$check(!in_array('About Us - Section 1',$remaining,true),'deleted section remains in saved order');
$controller->addSection($makeRequest(['selected_page'=>'About Us','page'=>'About Us','type'=>'text-image','content'=>$content,'section_order'=>$remaining]));
$newSections=App\Support\PageContentGroups::fromSections(App\Support\PageContentGroups::sections())['About Us'];
$newSettings=app(App\Support\SystemSettings::class)->all();
$newOrder=App\Support\AboutSectionOrder::arrange($newSections,$newSettings[App\Support\AboutSectionOrder::STORAGE_KEY] ?? null);
$newKeys=array_keys($newOrder);
$check(end($newKeys)==='About Us - Section 1','reused section number should be appended');
echo "PASS: default order, save/reload, public ordering, drag controls, validation, new/deleted sections\n";
