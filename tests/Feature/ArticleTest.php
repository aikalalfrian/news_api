<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Article;


class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function user_can_browse_posts_index_page()
    {
        // generate 2 record baru di table `posts`
        $article1 = Article::create([
            'name' => 'test',
            'tags' => 'test',
            'topic' => 'test',
            'image' => 'test',
            'status_article' => 'test',
        ]);

        $article2 = Article::create([
            'name' => 'test2',
            'tags' => 'test2',
            'topic' => 'test2',
            'image' => 'test2',
            'status_article' => 'test2',
        ]);

        $this->get('/api/articles');

        $this->see('test1');
        $this->see('test2');
    }

    public function user_can_create_a_post()
    {
        $this->get('/api/articles');

        $this->submitForm('Save', [
            'name' => 'test',
            'tags' => 'test',
            'topic' => 'test',
            'image' => 'test',
            'status_article' => 'test',
        ]);

        $this->seeInDatabase('articles', [
            'name' => 'test',
            'tags' => 'test',
            'topic' => 'test',
            'image' => 'test',
            'status_article' => 'test',
        ]);

        $this->see('test');
        $this->see('Article Created Successfully');
    }

    public function user_can_edit_existing_post()
    {
        $article = Article::create([
            'name' => 'test',
            'tags' => 'test',
            'topic' => 'test',
            'image' => 'test',
            'status_article' => 'test',
        ]);

        $this->get('/api/articles');

        $this->get("api/articles/{$article->id}");

        $this->seePageIs("api/articles/{$article->id}");

        $this->submitForm('Update', [
            'title' => 'belajar laravel 8 [update]'
        ]);

        $this->seeInDatabase('news_api', [
            'name' => 'test',
            'tags' => 'test',
            'topic' => 'test',
            'image' => 'test',
            'status_article' => 'test',
        ]);
    }


    public function user_can_delete_existing_post()
    {
        $article = Article::create([
            'name' => 'test',
            'tags' => 'test',
            'topic' => 'test',
            'image' => 'test',
            'status_article' => 'test',
        ]);

        $this->post('/api/articles/' . $article->id, [
            '_method' => 'DELETE'
        ]);

        $this->dontSeeInDatabase('articles', [
            'id' => $article->id
        ]);
    }
}
