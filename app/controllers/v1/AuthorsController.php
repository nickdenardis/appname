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