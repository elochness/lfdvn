<?php

namespace App\Tests\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functional test for the controllers defined inside BlogController.
 *
 * See https://symfony.com/doc/current/testing.html#functional-tests
 *
 * Execute the application tests using this command (requires PHPUnit to be installed):
 *
 *     $ cd your-symfony-project/
 *     $ ./vendor/bin/phpunit
 */
class ArticleControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertResponseIsSuccessful();

        $this->assertCount(
            Article::NUM_ITEMS,
            $crawler->filter('article.index'),
            'The homepage displays the right number of articles.'
        );
    }
}
