<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public $articles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->articles = factory(Article::class, 10)->create();
    }

    /**
     * @test
     */
    public function indexArticleAll(): void
    {
        $response = $this->json('GET', 'api/articles');
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $this->articles[0]->id,
                     'title' => $this->articles[0]->title,
                     'body' => $this->articles[0]->body,
                 ],[
                    'id' => $this->articles[5]->id,
                    'title' => $this->articles[5]->title,
                    'body' => $this->articles[5]->body,
                 ]);
    }

    /**
     * @test
     */
    public function createArticle(): void
    {
        $articleCount = Article::count();
        $params = [
            'title' => 'タイトル',
            'body' => '本文'
        ];

        $response = $this->json('POST', '/api/articles', $params);
        $response->assertStatus(201);

        $this->assertSame(Article::count(), $articleCount + 1);
    }
}
