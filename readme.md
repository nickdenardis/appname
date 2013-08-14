# Base Laravel App Proof of Concept

Basically proof that Laraval is possible to start re-writing our API and other things.

## Setup

    git clone git@github.com:nickdenardis/appname.git
    chmod -R 755 app/storage
    composer install
    chmod -R 755 vendor/way/generators/src/Way/
    php artisan migrate --seed
    vendor/phpunit/phpunit/phpunit.php
    sass public/scss/foundation.scss:public/css/foundation.css
    sass public/scss/normalize.scss:public/css/normalize.css
    sass --watch public/scss/app.scss:public/css/app.css
    php artisan serve

## Make sure the memory limit is at least 64 megs
	php -r 'phpinfo();' | grep 'php.ini'
	memory_limit = 128M

## Adding a model/controller/view
Things that you have to do to get new things rolling

### Generate the new model and things
    php artisan generate:resource author --fields="name:string, email:string, website:string"

### Move the views to the frontend
    mv app/views/authors public/views/authors

### app/routes.php
	App::bind('AuthorRepositoryInterface', 'EloquentAuthorRepository');
	...
	Route::group(array('prefix' => 'v1'), function(){
    	...
    	Route::resource('authors', 'V1\AuthorsController'); //notice the namespace
    }
    ...
    Route::resource('authors', 'AuthorsController');

### Move the controller to the v1 dir
    mv app/controllers/AuthorsController.php app/controllers/V1/

### app/database/seeds/AuthorsTableSeeder.php
	$authors = array(
		array(
			'name'    => 'John Doe',
			'email'   => 'john.doe@gmail.com',
			'website' => 'http://johndoe.com/',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		),
		array(
			'name'    => 'Jane Doe',
			'email'   => 'jane.doe@gmail.com',
			'website' => 'http://janedoe.com/',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		),
		array(
			'name'    => 'Captain Planet',
			'email'   => 'captian.planet@gmail.com',
			'website' => 'http://captainplanet.com/',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		),
	);

	// Uncomment the below to run the seeder
	DB::table('authors')->truncate();
	DB::table('authors')->insert($authors);

### Seed the new database table
	php artisan migrate --seed

### Make sure there isn't any failing tests before continuing
	vendor/phpunit/phpunit/phpunit.php

### Make the controller test
	touch app/tests/controllers/AuthorsControllerTest.php

### app/tests/controllers/AuthorsControllerTest.php
	<?php
	 
	class AuthorsControllerTest extends TestCase {
	 
	  /**
	   * Test Basic Route Responses
	   */
	  public function testIndex()
	  {
	    $response = $this->call('GET', route('v1.authors.index'));
	    $this->assertTrue($response->isOk());
	  }
	 
	  public function testShow()
	  {
	    $response = $this->call('GET', route('v1.authors.show', array(1)));
	    $this->assertTrue($response->isOk());
	  }
	 
	  public function testCreate()
	  {
	    $response = $this->call('GET', route('v1.authors.create'));
	    $this->assertTrue($response->isOk());
	  }
	 
	  public function testEdit()
	  {
	    $response = $this->call('GET', route('v1.authors.edit', array(1)));
	    $this->assertTrue($response->isOk());
	  }
	 
	  /**
	   * Test that controller calls repo as we expect
	   */
	  public function testIndexShouldCallFindAllMethod()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('findAll')->once()->andReturn('foo');
	    App::instance('AuthorRepositoryInterface', $mock);
	 
	    $response = $this->call('GET', route('v1.authors.index'));
	    $this->assertTrue(!! $response->original);
	  }
	 
	  public function testShowShouldCallFindById()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('findById')->once()->andReturn('foo');
	    App::instance('AuthorRepositoryInterface', $mock);
	 
	    $response = $this->call('GET', route('v1.authors.show', array(1)));
	    $this->assertTrue(!! $response->original);
	  }
	 
	  public function testCreateShouldCallInstanceMethod()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('instance')->once()->andReturn(array());
	    App::instance('AuthorRepositoryInterface', $mock);
	    
	 
	    $response = $this->call('GET', route('v1.authors.create'));
	    $this->assertViewHas('author');
	  }
	 
	  public function testEditShouldCallFindByIdMethod()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('findById')->once()->andReturn(array());
	    App::instance('AuthorRepositoryInterface', $mock);
	 
	    $response = $this->call('GET', route('v1.authors.edit', array(1)));
	    $this->assertViewHas('author');
	  }
	 
	  public function testStoreShouldCallStoreMethod()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('store')->once()->andReturn('foo');
	    App::instance('AuthorRepositoryInterface', $mock);
	 
	    $response = $this->call('POST', route('v1.authors.store'));
	    $this->assertTrue(!! $response->original);
	  }
	 
	  public function testUpdateShouldCallUpdateMethod()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('update')->once()->andReturn('foo');
	    App::instance('AuthorRepositoryInterface', $mock);
	 
	    $response = $this->call('PUT', route('v1.authors.update', array(1)));
	    $this->assertTrue(!! $response->original);
	  }
	 
	  public function testDestroyShouldCallDestroyMethod()
	  {
	    $mock = Mockery::mock('AuthorRepositoryInterface');
	    $mock->shouldReceive('destroy')->once()->andReturn(true);
	    App::instance('AuthorRepositoryInterface', $mock);
	 
	    $response = $this->call('DELETE', route('v1.authors.destroy', array(1)));
	    $this->assertTrue( empty($response->original) );
	  }
	 
	}

### Make the repositor test
	touch app/tests/repositories/EloquentAuthorRepositoryTest.php

### app/tests/repositories/EloquentAuthorRepositoryTest.php
	<?php
 
	class EloquentAuthorRepositoryTest extends TestCase {
	 
	  public function setUp()
	  {
	    parent::setUp();
	    $this->repo = App::make('EloquentAuthorRepository');
	  }
	 
	  public function testFindByIdReturnsModel()
	  {
	    $author = $this->repo->findById(1,1);
	    $this->assertTrue($author instanceof Illuminate\Database\Eloquent\Model);
	  }
	 
	  public function testFindAllReturnsCollection()
	  {
	    $authors = $this->repo->findAll(1);
	    $this->assertTrue($authors instanceof Illuminate\Database\Eloquent\Collection);
	  }
	 
	  public function testValidatePasses()
	  {
	    $reply = $this->repo->validate(array(
	      'name'   => 'Superman',
	      'email' => 'superman@gmail.com',
	      'website' => 'http://superman.com/'
	    ));
	 
	    $this->assertTrue($reply);
	  }
	 
	  public function testValidateFailsWithoutEmail()
	  {
	    try {
	      $reply = $this->repo->validate(array(
	        'name'   => 'Superman',
	        'website' => 'http://superman.com/'
	      ));
	    }
	    catch(ValidationException $expected)
	    {
	      return;
	    }
	 
	    $this->fail('ValidationException was not raised');
	  }
	  
	  public function testValidateFailsWithoutAuthorName()
	  {
	    try {
	      $reply = $this->repo->validate(array(
	        'email' => 'superman@gmail.com',
	        'website' => 'http://superman.com/'
	      ));
	    }
	    catch(ValidationException $expected)
	    {
	      return;
	    }
	 
	    $this->fail('ValidationException was not raised');
	  }
	 
	  public function testStoreReturnsModel()
	  {
	    $author_data = array(
	      'name'   => 'Superman',
	      'email' => 'superman@gmail.com',
	      'website' => 'http://superman.com/'
	    );
	 
	    $author = $this->repo->store($author_data);
	 
	    $this->assertTrue($author instanceof Illuminate\Database\Eloquent\Model);
	    $this->assertTrue($author->name === $author_data['name']);
	    $this->assertTrue($author->email === $author_data['email']);
	  }

	  public function testUpdateSaves()
	  {
	    $author_data = array(
	      'website' => 'http://supermanwins.com/'
	    );
	 
	    $author = $this->repo->update(1, $author_data);
	 
	    $this->assertTrue($author instanceof Illuminate\Database\Eloquent\Model);
	    $this->assertTrue($author->website === $author_data['website']);
	  }

	  public function testDestroySaves()
	  {
	    $reply = $this->repo->destroy(1);
	    $this->assertTrue($reply);
	 
	    try {
	      $this->repo->findById(1);
	    }
	    catch(NotFoundException $expected)
	    {
	      return;
	    }
	 
	    $this->fail('NotFoundException was not raised');
	  }
	 
	  public function testInstanceReturnsModel()
	  {
	    $author = $this->repo->instance();
	    $this->assertTrue($author instanceof Illuminate\Database\Eloquent\Model);
	  }
	 
	  public function testInstanceReturnsModelWithData()
	  {
	    $author_data = array(
	      'name' => 'Super Man'
	    );
	 
	    $comment = $this->repo->instance($author_data);
	    $this->assertTrue($comment instanceof Illuminate\Database\Eloquent\Model);
	    $this->assertTrue($comment->name === $author_data['name']);
	  }
	 
	}

### app/controllers/V1/AuthorsController.php
	<?php
	namespace V1;
	 
	use BaseController; 
	use AuthorRepositoryInterface; 
	use Input;
	use View;
	 
	class AuthorsController extends BaseController {
	 
	  /**
	   * We will use Laravel's dependency injection to auto-magically
	   * "inject" our repository instance into our controller
	   */
	  public function __construct(AuthorRepositoryInterface $authors)
	  {
	    $this->authors = $authors;
	  }
	 
	  /**
	   * Display a listing of the resource.
	   *
	   * @return Response
	   */
	  public function index()
	  {
	    return $this->authors->findAll();
	  }
	 
	  /**
	   * Show the form for creating a new resource.
	   *
	   * @return Response
	   */
	  public function create()
	  {
	    $author = $this->authors->instance();
	    return View::make('authors._form', compact('author'));
	  }
	 
	  /**
	   * Store a newly created resource in storage.
	   *
	   * @return Response
	   */
	  public function store()
	  {
	    return $this->authors->store( Input::all() );
	  }
	 
	  /**
	   * Display the specified resource.
	   *
	   * @param int $id
	   * @return Response
	   */
	  public function show($id)
	  {
	    return $this->authors->findById($id);
	  }
	 
	  /**
	   * Show the form for editing the specified resource.
	   *
	   * @param int $id
	   * @return Response
	   */
	  public function edit($id)
	  {
	    $author = $this->authors->findById($id);
	    return View::make('authors._form', compact('author'));
	  }
	 
	  /**
	   * Update the specified resource in storage.
	   *
	   * @param int $id
	   * @return Response
	   */
	  public function update($id)
	  {
	    return $this->authors->update($id, Input::all());
	  }
	 
	  /**
	   * Remove the specified resource from storage.
	   *
	   * @param int $id
	   * @return Response
	   */
	  public function destroy($id)
	  {
	    $this->authors->destroy($id);
	    return '';
	  } 
	}

### app/routes.php
	App::bind('AuthorRepositoryInterface', 'EloquentAuthorRepository');

### Make the Repository Interface
	touch app/repositories/AuthorRepositoryInterface.php

### app/repositories/AuthorRepositoryInterface.php
	<?php
	 
	interface AuthorRepositoryInterface {
	  public function findById($id);
	  public function findAll();
	  public function paginate($limit = null);
	  public function store($data);
	  public function update($id, $data);
	  public function destroy($id);
	  public function validate($data);
	  public function instance();
	}

### Make the Eloquent Repository
	touch app/repositories/EloquentAuthorRepository.php

### app/repositories/EloquentAuthorRepository.php
	<?php
 
	class EloquentAuthorRepository implements AuthorRepositoryInterface {
	 
	  public function findById($id)
	  {
	    $author = Author::where('id', $id)->first();
	 
	    if(!$author) throw new NotFoundException('Author Not Found');
	    return $author;
	  }
	 
	  public function findAll()
	  {
	    return Author::orderBy('created_at', 'desc')->get();
	  }
	 
	  public function paginate($limit = null)
	  {
	    return Author::paginate($limit);
	  }
	 
	  public function store($data)
	  {
	    $this->validate($data);
	    return Author::create($data);
	  }
	 
	  public function update($id, $data)
	  {
	    $author = $this->findById($id);
	    $author->fill($data);
	    $this->validate($author->toArray());
	    $author->save();
	    return $author;
	  }
	 
	  public function destroy($id)
	  {
	    $author = $this->findById($id);
	    $author->delete();
	    return true;
	  }
	 
	  public function validate($data)
	  {
	    $validator = Validator::make($data, Author::$rules);
	    if($validator->fails()) throw new ValidationException($validator);
	    return true;
	  }
	 
	  public function instance($data = array())
	  {
	    return new Author($data);
	  }
	 
	}

### app/models/Author.php
	<?php
	/**
	 * Represent an Author
	 */
	class Author extends Eloquent {
	 
	  /**
	   * Items that are "fillable"
	   * meaning we can mass-assign them from the constructor
	   * or $post->fill()
	   * @var array
	   */
	  protected $fillable = array(
	    'name', 'email', 'website'
	  );
	 
	  /**
	   * Validation Rules
	   * this is just a place for us to store these, you could
	   * alternatively place them in your repository
	   * @var array
	   */
	  public static $rules = array(
	    'name'    => 'required',
	    'email' => 'required'
	  );
	}

### Rename and create the views to .mustache
	mv public/views/authors/index.blade.php public/views/authors/index.mustache
	mv public/views/authors/show.blade.php public/views/authors/show.mustache
	mv public/views/authors/create.blade.php public/views/authors/create.mustache
	mv public/views/authors/edit.blade.php public/views/authors/edit.mustache
	touch public/views/authors/_post.mustache
	touch public/views/authors/_form.mustache

### public/views/authors/index.mustache
	<div class="row">
		<div class="twelve columns">
			{{#authors}}
			  {{> authors._post}}
			{{/authors}}
		</div>
	</div>

### public/views/authors/show.mustache
	<div class="row">
		<div class="twelve columns">
			<article>
			  <h3>
			    {{ author.name }} {{ author.id }}
			    <small>{{ author.email }}</small>
			  </h3>
			  <div>
			    {{ author.website }}
			  </div>
			</article>
		</div>
	</div>

### public/views/authors/_post.mustache
	<article data-target="authors/{{ id }}">
	  <h3><a href="authors/{{ id }}">{{ name }} {{ id }}</a></h3>
	  <cite>{{ email }} on {{ website }}</cite>
	</article>

### public/views/authors/_form.mustache
	{{#exists}}
	  <form action="/v1/authors/{{ author.id }}" method="post">
	    <input type="hidden" name="_method" value="PUT" />
	{{/exists}}
	{{^exists}}
	  <form action="/v1/authors" method="post">
	{{/exists}}
	 
	  <fieldset>
	 
	    <div class="control-group">
	      <label class="control-label"></label>
	      <div class="controls">
	        <input type="text" name="name" value="{{ author.name }}" />
	      </div>
	    </div>
	 
	    <div class="control-group">
	      <label class="control-label"></label>
	      <div class="controls">
	        <input type="text" name="email" value="{{ author.email }}" />
	      </div>
	    </div>
	 
	    <div class="control-group">
	      <label class="control-label"></label>
	      <div class="controls">
	        <input type="text" name="website" value="{{ author.website }}" />
	      </div>
	    </div>
	 
	    <div class="form-actions">
	      <input type="submit" class="btn btn-primary" value="Save" />
	    </div>
	 
	  </fieldset>
	</form>

### Flush the composer auto load
	composer dump-autoload

### Run your tests one last time
	vendor/phpunit/phpunit/phpunit.php