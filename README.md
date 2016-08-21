# Laravel 5 Repositories

Laravel 5 Repositories is used to abstract the data layer, making our application more flexible to maintain.

You want to know a little more about the Repository pattern? [Read this great article](http://bit.ly/1IdmRNS).

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
    - <a href="#laravel">Laravel</a>
- <a href="#methods">Methods</a>
    - <a href=“#farrrrrepositorycontractsrepositoryinterface">RepositoryInterface</a>
    - <a href="#farrrrrepositorycontractsrepositorycriteriainterface">RepositoryCriteriaInterface</a>
    - <a href="#farrrrrepositorycontractspresenterinterface">PresenterInterface</a>
    - <a href="#farrrrrepositorycontractscriteriainterface">CriteriaInterface</a>
- <a href="#usage">Usage</a>
	- <a href="#create-a-model">Create a Model</a>
	- <a href="#create-a-repository">Create a Repository</a>
	- <a href="#generators">Generators</a>
	- <a href="#use-methods">Use methods</a>
	- <a href="#create-a-criteria">Create a Criteria</a>
	- <a href="#using-the-criteria-in-a-controller">Using the Criteria in a Controller</a>
- <a href="#presenters">Presenters</a>
    - <a href="#fractal-presenter">Fractal Presenter</a>
        - <a href="#create-a-presenter">Create a Fractal Presenter</a>
        - <a href="#implement-interface">Model Transformable</a>
    - <a href="#enabling-in-your-repository-1">Enabling in your Repository</a>

## Installation

### Composer

Execute the following command to get the latest version of the package:

```terminal
composer require farrrr/repository
```

### Laravel

In your `config/app.php` add `Farrrr\Repository\Providers\RepositoryServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
    Farrrr\Repository\Providers\RepositoryServiceProvider::class,
],
```

If Lumen

```php
$app->register(Farrrr\Repository\Providers\LumenRepositoryServiceProvider::class);
```

Publish Configuration

```shell
php artisan vendor:publish
```

## Methods

### Farrrr\Repository\Contracts\RepositoryInterface

- all($columns = array('*'))
- first($columns = array('*'))
- paginate($limit = null, $columns = ['*'])
- find($id, $columns = ['*'])
- findByField($field, $value, $columns = ['*'])
- findWhere(array $where, $columns = ['*'])
- findWhereIn($field, array $where, $columns = [*])
- findWhereNotIn($field, array $where, $columns = [*])
- create(array $attributes)
- update(array $attributes, $id)
- updateOrCreate(array $attributes, array $values = [])
- delete($id)
- orderBy($column, $direction = 'asc');
- with(array $relations);
- has(string $relation);
- whereHas(string $relation, closure $closure);
- hidden(array $fields);
- visible(array $fields);
- scopeQuery(Closure $scope);
- getFieldsSearchable();
- setPresenter($presenter);
- skipPresenter($status = true);


### Farrrr\Repository\Contracts\RepositoryCriteriaInterface

- pushCriteria($criteria)
- popCriteria($criteria)
- getCriteria()
- getByCriteria(CriteriaInterface $criteria)
- skipCriteria($status = true)
- getFieldsSearchable()

### Farrrr\Repository\Contracts\PresenterInterface

- present($data);

### Farrrr\Repository\Contracts\Presentable

- setPresenter(PresenterInterface $presenter);
- presenter();

### Farrrr\Repository\Contracts\CriteriaInterface

- apply($model, RepositoryInterface $repository);

### Farrrr\Repository\Contracts\Transformable

- transform();


## Usage

### Create a Model

Create your model normally, but it is important to define the attributes that can be filled from the input form data.

```php
namespace App;

class Post extends Eloquent { // or Ardent, Or any other Model Class

    protected $fillable = [
        'title',
        'author',
        ...
     ];

     ...
}
```

### Create a Repository

```php
namespace App;

use Farrrr\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Post";
    }
}
```

### Generators

Create your repositories easily through the generator.

#### Config

You must first configure the storage location of the repository files. By default is the "app" folder and the namespace "App". Please note that, values in the `paths` array are acutally used as both *namespace* and file paths. Relax though, both foreward and backward slashes are taken care of during generation.

```php
    ...
    'generator'=>[
        'basePath'=>app_path(),
        'rootNamespace'=>'App\\',
        'paths'=>[
            'models'       => 'Entities',
            'repositories' => 'Repositories',
            'interfaces'   => 'Repositories',
            'transformers' => 'Transformers',
            'presenters'   => 'Presenters',
            'validators'   => 'Validators',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'RepositoryServiceProvider',
            'criteria'     => 'Criteria',
        ]
    ]
```

You may want to save the root of your project folder out of the app and add another namespace, for example

```php
    ...
     'generator'=>[
        'basePath'      => base_path('src/Lorem'),
        'rootNamespace' => 'Lorem\\'
    ]
```

Additionally, you may wish to customize where your generated classes end up being saved.  That can be accomplished by editing the `paths` node to your liking.  For example:

```php
    'generator'=>[
        'basePath'=>app_path(),
        'rootNamespace'=>'App\\',
        'paths'=>[
            'models'=>'Models',
            'repositories'=>'Repositories\\Eloquent',
            'interfaces'=>'Contracts\\Repositories',
            'transformers'=>'Transformers',
            'presenters'=>'Presenters'
            'validators'   => 'Validators',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'RepositoryServiceProvider',
            'criteria'     => 'Criteria',
        ]
    ]
```

#### Commands

To generate everything you need for your Model, run this command:

```terminal
php artisan make:entity Post
```

This will create the Controller, the Validator, the Model, the Repository, the Presenter and the Transformer classes.
It will also create a new service provider that will be used to bind the Eloquent Repository with its corresponding Repository Interface.
To load it, just add this to your AppServiceProvider@register method:

```php
    $this->app->register(RepositoryServiceProvider::class);
```

You can also pass the options from the ```repository``` command, since this command is just a wrapper.

To generate a repository for your Post model, use the following command

```terminal
php artisan make:repository Post
```

To generate a repository for your Post model with Blog namespace, use the following command

```terminal
php artisan make:repository "Blog\Post"
```

Added fields that are fillable

```terminal
php artisan make:repository "Blog\Post" --fillable="title,content"
```

To add validations rules directly with your command you need to pass the `--rules` option and create migrations as well:

```terminal
php artisan make:entity Cat --fillable="title:string,content:text" --rules="title=>required|min:2, content=>sometimes|min:10"
```

The command will also create your basic RESTfull controller so just add this line into your `routes.php` file and you will have a basic CRUD:

 ```php
 Route::resource('cats', CatsController::class);
 ```

When running the command, you will be creating the "Entities" folder and "Repositories" inside the folder that you set as the default.

Done, done that just now you do bind its interface for your real repository, for example in your own Repositories Service Provider.

```php
App::bind('{YOUR_NAMESPACE}Repositories\PostRepository', '{YOUR_NAMESPACE}Repositories\PostRepositoryEloquent');
```

And use

```php
public function __construct({YOUR_NAMESPACE}Repositories\PostRepository $repository){
    $this->repository = $repository;
}
```

Alternatively, you could use the artisan command to do the binding for you.

```php
php artisan make:bindings Cats
```

### Use methods

```php
namespace App\Http\Controllers;

use App\PostRepository;

class PostsController extends BaseController {

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }

    ....
}
```

Find all results in Repository

```php
$posts = $this->repository->all();
```

Find all results in Repository with pagination

```php
$posts = $this->repository->paginate($limit = null, $columns = ['*']);
```

Find by result by id

```php
$post = $this->repository->find($id);
```

Hiding attributes of the model

```php
$post = $this->repository->hidden(['country_id'])->find($id);
```

Showing only specific attributes of the model

```php
$post = $this->repository->visible(['id', 'state_id'])->find($id);
```

Loading the Model relationships

```php
$post = $this->repository->with(['state'])->find($id);
```

Find by result by field name

```php
$posts = $this->repository->findByField('country_id','15');
```

Find by result by multiple fields

```php
$posts = $this->repository->findWhere([
    //Default Condition =
    'state_id'=>'10',
    'country_id'=>'15',
    //Custom Condition
    ['columnName','>','10']
]);
```

Find by result by multiple values in one field

```php
$posts = $this->repository->findWhereIn('id', [1,2,3,4,5]);
```

Find by result by excluding multiple values in one field

```php
$posts = $this->repository->findWhereNotIn('id', [6,7,8,9,10]);
```

Find all using custom scope

```php
$posts = $this->repository->scopeQuery(function($query){
    return $query->orderBy('sort_order','asc');
})->all();
```

Create new entry in Repository

```php
$post = $this->repository->create( Input::all() );
```

Update entry in Repository

```php
$post = $this->repository->update( Input::all(), $id );
```

Delete entry in Repository

```php
$this->repository->delete($id)
```

### Create a Criteria

#### Using the command

```terminal
php artisan make:criteria My
```

Criteria are a way to change the repository of the query by applying specific conditions according to your needs. You can add multiple Criteria in your repository.

```php

use Farrrr\Repository\Contracts\RepositoryInterface;
use Farrrr\Repository\Contracts\CriteriaInterface;

class MyCriteria implements CriteriaInterface {

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('user_id','=', Auth::user()->id );
        return $model;
    }
}
```

### Using the Criteria in a Controller

```php

namespace App\Http\Controllers;

use App\PostRepository;

class PostsController extends BaseController {

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }


    public function index()
    {
        $this->repository->pushCriteria(new MyCriteria1());
        $this->repository->pushCriteria(MyCriteria2::class);
        $posts = $this->repository->all();
		...
    }

}
```

Getting results from Criteria

```php
$posts = $this->repository->getByCriteria(new MyCriteria());
```

Setting the default Criteria in Repository

```php
use Farrrr\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    public function boot(){
        $this->pushCriteria(new MyCriteria());
        // or
        $this->pushCriteria(AnotherCriteria::class);
        ...
    }

    function model(){
       return "App\\Post";
    }
}
```

### Skip criteria defined in the repository

Use `skipCriteria` before any other chaining method

```php
$posts = $this->repository->skipCriteria()->all();
```

### Popping criteria

Use `popCriteria` to remove a criteria

```php
$this->repository->popCriteria(new Criteria1());
// or
$this->repository->popCriteria(Criteria1::class);
```


### Presenters

Presenters function as a wrapper and renderer for objects.

#### Fractal Presenter

Requires [Fractal](http://fractal.thephpleague.com/). `composer require league/fractal`

There are two ways to implement the Presenter, the first is creating a TransformerAbstract and set it using your Presenter class as described in the Create a Transformer Class.

The second way is to make your model implement the Transformable interface, and use the default Presenter ModelFractarPresenter, this will have the same effect.

##### Transformer Class

###### Create a Transformer using the command

```terminal
php artisan make:transformer Post
```

This wil generate the class beneath.

###### Create a Transformer Class

```php
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    public function transform(\Post $post)
    {
        return [
            'id'      => (int) $post->id,
            'title'   => $post->title,
            'content' => $post->content
        ];
    }
}
```

###### Create a Presenter using the command

```terminal
php artisan make:presenter Post
```

The command will prompt you for creating a Transformer too if you haven't already.
###### Create a Presenter

```php
use Farrrr\Repository\Presenter\FractalPresenter;

class PostPresenter extends FractalPresenter {

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PostTransformer();
    }
}
```

###### Enabling in your Repository

```php
use Farrrr\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    ...

    public function presenter()
    {
        return "App\\Presenter\\PostPresenter";
    }
}
```

Or enable it in your controller with

```php
$this->repository->setPresenter("App\\Presenter\\PostPresenter");
```

###### Using the presenter after from the Model

If you recorded a presenter and sometime used the `skipPresenter()` method or simply you do not want your result is not changed automatically by the presenter.
You can implement Presentable interface on your model so you will be able to present your model at any time. See below:

In your model, implement the interface `Farrrr\Repository\Contracts\Presentable` and `Farrrr\Repository\Traits\PresentableTrait`

```php
namespace App;

use Farrrr\Repository\Contracts\Presentable;
use Farrrr\Repository\Traits\PresentableTrait;

class Post extends Eloquent implements Presentable {

    use PresentableTrait;

    protected $fillable = [
        'title',
        'author',
        ...
     ];

     ...
}
```

There, now you can submit your Model individually, See an example:

```php
$repository = app('App\PostRepository');
$repository->setPresenter("Farrrr\\Repository\\Presenter\\ModelFractalPresenter");

//Getting the result transformed by the presenter directly in the search
$post = $repository->find(1);

print_r( $post ); //It produces an output as array

...

//Skip presenter and bringing the original result of the Model
$post = $repository->skipPresenter()->find(1);

print_r( $post ); //It produces an output as a Model object
print_r( $post->presenter() ); //It produces an output as array

```

You can skip the presenter at every visit and use it on demand directly into the model, for it set the `$skipPresenter` attribute to true in your repository:

```php
use Farrrr\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    /**
    * @var bool
    */
    protected $skipPresenter = true;

    public function presenter()
    {
        return "App\\Presenter\\PostPresenter";
    }
}
```

##### Model Class

###### Implement Interface

```php
namespace App;

use Farrrr\Repository\Contracts\Transformable;

class Post extends Eloquent implements Transformable {
     ...
     /**
      * @return array
      */
     public function transform()
     {
         return [
             'id'      => (int) $this->id,
             'title'   => $this->title,
             'content' => $this->content
         ];
     }
}
```

###### Enabling in your Repository

`Farrrr\Repository\Presenter\ModelFractalPresenter` is a Presenter default for Models implementing Transformable

```php
use Farrrr\Repository\Eloquent\BaseRepository;

class PostRepository extends BaseRepository {

    ...

    public function presenter()
    {
        return "Farrrr\\Repository\\Presenter\\ModelFractalPresenter";
    }
}
```

Or enable it in your controller with

```php
$this->repository->setPresenter("Farrrr\\Repository\\Presenter\\ModelFractalPresenter");
```

### Skip Presenter defined in the repository

Use *skipPresenter* before any other chaining method

```php
$posts = $this->repository->skipPresenter()->all();
```

or

```php
$this->repository->skipPresenter();

$posts = $this->repository->all();
```