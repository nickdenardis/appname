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
    $this->assertViewHas('post');
  }
 
  public function testEditShouldCallFindByIdMethod()
  {
    $mock = Mockery::mock('AuthorRepositoryInterface');
    $mock->shouldReceive('findById')->once()->andReturn(array());
    App::instance('AuthorRepositoryInterface', $mock);
 
    $response = $this->call('GET', route('v1.authors.edit', array(1)));
    $this->assertViewHas('post');
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