<?php
 
class PostsTableSeeder extends Seeder {
 
  public function run()
  {
    $posts = array(
      array(
        'title'    => 'Test Post',
        'content'   => 'Lorem ipsum Reprehenderit velit est irure in enim in magna aute occaecat qui velit ad.',
        'author_id' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ),
      array(
        'title'    => 'Another Test Post',
        'content'   => 'Lorem ipsum Reprehenderit velit est irure in enim in magna aute occaecat qui velit ad.',
        'author_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ),
      array(
        'title'    => 'A third Test Post',
        'content'   => 'Lorem ipsum Reprehenderit velit est irure in enim in magna aute occaecat qui velit ad.',
        'author_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ),
    );
 
    // Uncomment the below to run the seeder
    DB::table('posts')->truncate();
    DB::table('posts')->insert($posts);
  }
 
}