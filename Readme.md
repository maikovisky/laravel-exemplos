

# Criando Modelo Category 

```bash
$ php artisan make:model -m -c -r Category
```

Criará os arquivos:

* app/Category.php
* app/Http/Controller/CategoryController.php
* database/migrations/2016_12_20_131440_create_categories_table.php

## Códigos

### app/Category.php
``php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    
    public function parent() {
        return $this->belongsTo('App\Category', 'parent_id');
    }
    
    public function children() {
        return $this->hasMany('App\Category', 'parent_id');
    }
}
```

### app/Http/Controller/CategoryController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
```

### database/migrations/2016_12_20_131440_create_categories_table.php
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->foreign('parent_id')
				->references('id')
				->on('categories')
				->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
```
# Criando semente usando Faker

## database/factories/ModelFactory.php

```php
<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class, function(Faker\Generator $faker) {

    if(\App\Category::count())
        $id = (rand()%100) > 25? \App\Category::all()->random()->id : NULL;
    else $id = NULL;
    
    return [
        'name' => $faker->word,
        'parent_id' => $id
    ];

});
```

## database/seeds/FakerSeeder.php
```php
<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class, 10)->create();
        factory(App\Category::class, 20)->create();
        factory(App\Category::class, 30)->create();
    }
}
```


```bash
$ php artisan db:seed --class=FakerSeeder
```
