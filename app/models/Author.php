<?php
/**
 * Represent an Author
 */
class Author extends Eloquent {

  public $connection = 'cms_prod';
 
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

  /**
   * Define the relationship with the posts table
   * @return Collection collection of Posts Models
   */
  public function posts()
  {
    return $this->hasMany('Post');
  }
}