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