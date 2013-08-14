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