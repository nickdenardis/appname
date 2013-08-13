<?php
/**
 * Represent a Post Item, or Collection
 */
class Post extends Eloquent {
 
  /**
   * Items that are "fillable"
   * meaning we can mass-assign them from the constructor
   * or $post->fill()
   * @var array
   */
  protected $fillable = array(
    'title', 'content', 'author_name'
  );
 
  /**
   * Validation Rules
   * this is just a place for us to store these, you could
   * alternatively place them in your repository
   * @var array
   */
  public static $rules = array(
    'title'    => 'required',
    'author_name' => 'required'
  );
 
  /**
   * Define the relationship with the comments table
   * @return Collection collection of Comment Models
   */
  public function comments()
  {
    return $this->hasMany('Comment');
  }
 
}