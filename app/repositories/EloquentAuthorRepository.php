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