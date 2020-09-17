<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CRUDmaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CRUDmaker {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a model, a migration to create a table, a controller with its methods, and its respective views directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data['name'] = $this->argument('name');
        $data['upperName'] = ucfirst($data['name']);
        $data['pluralName'] = $data['name'].'s';
        $data['pluralUpperName'] = $data['upperName'].'s';
    //create model and migration
        $this->call("make:model", ['name'=>$data['upperName'], '--migration'=>'default']);
    //create controller file and main methods
        $controllerPath = substr(dirname(__FILE__), 0, -16)."Http/Controllers/Admin/";
        $this->createController($data, $controllerPath);   
    //create views directory and main views files
    $viewsPath = substr(dirname(__FILE__), 0, -20)."resources/views/Admin/".$data['pluralName'];
    mkdir($viewsPath, 0755);

    $file = fopen($viewsPath."/Index.blade.php", 'x+');
    $content = view('CRUDmaker/IndexMaker', ['data' => $data]);
    fwrite($file, $content);
    fclose($file);
        
    $file = fopen($viewsPath."/Form.blade.php", 'x+');
    $content = view('CRUDmaker/FormMaker', ['data' => $data]);
    fwrite($file, $content);
    fclose($file);

    $file = fopen($viewsPath."/Edit.blade.php", 'x+');
    $content = view('CRUDmaker/EditMaker', ['data' => $data]);
    fwrite($file, $content);
    fclose($file);

    $file =  fopen($viewsPath."/Detail.blade.php", 'x+');
    $content = view('CRUDmaker/DetailMaker', ['data' => $data]);
    fwrite($file, $content);
    fclose($file);

    //create group routes
    $content = <<<CONTENT
    Route::group(['prefix' => "/{$data['pluralName']}"], function() {
    Route::get('/index', "{$data['pluralUpperName']}Controller@index")->name("{$data['pluralName']}");
    Route::get('/add', "{$data['pluralUpperName']}Controller@create")->name("{$data['pluralName']}Add");
    Route::get('/edit/{id}', "{$data['pluralUpperName']}Controller@edit")->name("{$data['pluralName']}Edit");
    Route::post('/store', "{$data['pluralUpperName']}Controller@store")->name("{$data['pluralName']}Store");
    Route::post('/update', "{$data['pluralUpperName']}Controller@update")->name("{$data['pluralName']}Update");
    Route::get('/detail/{id}', "{$data['pluralUpperName']}Controller@detail")->name("{$data['pluralName']}Detail");
    Route::get('/delete/{id}', "{$data['pluralUpperName']}Controller@delete")->name("{$data['pluralName']}Delete");
});\n\n\n
CONTENT;
$routesPath = substr(dirname(__FILE__), 0, -20)."routes/web.php";
file_put_contents($routesPath, $content, FILE_APPEND | LOCK_EX);

    }

    public function createController($data, $controllerPath)
    {
        $file = fopen($controllerPath.$data['pluralUpperName']."Controller.php", 'x+');  
        $content = view('CRUDmaker/commonController', ['data' => $data]);
        fwrite($file, $content);
        fclose($file);
    }
}