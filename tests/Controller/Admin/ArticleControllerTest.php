<?php

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Controller\Admin;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Functional test for the controllers defined inside the articleController used
 * for managing the article in the backend.
 *
 * See https://symfony.com/doc/current/book/testing.html#functional-tests
 *
 * Whenever you test resources protected by a firewall, consider using the
 * technique explained in:
 * https://symfony.com/doc/current/cookbook/testing/http_authentication.html
 *
 * Execute the application tests using this command (requires PHPUnit to be installed):
 *
 *     $ cd your-symfony-project/
 *     $ ./vendor/bin/phpunit
 */
class ArticleControllerTest extends WebTestCase
{
//    /**
//     * @dataProvider getUrlsForRegularUsers
//     */
//    public function testAccessDeniedForRegularUsers(string $httpMethod, string $url)
//    {
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'tom_admin@symfony.com',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//
//        $client->request($httpMethod, $url);
//        $this->assertSame(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
//    }
//
//    public function getUrlsForRegularUsers()
//    {
//        yield ['GET', '/admin/?action=list&entity=Article'];
//        yield ['GET', '/admin/?action=show&entity=Article&id=1'];
//        yield ['GET', '/admin/?action=edit&entity=Article&id=1'];
//        yield ['POST', '/admin/?action=delete&entity=Article&id=1'];
//    }
//
//    public function testAdminBackendHomePage()
//    {
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'jane_admin@symfony.com',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//
//        $crawler = $client->request('GET', '/admin/?action=list&entity=Article');
//        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
//
//        $this->assertGreaterThanOrEqual(
//            1,
//            $crawler->filter('body#admin_post_index #main tbody tr')->count(),
//            'The backend homepage displays all the available posts.'
//        );
//    }
//
//    /**
//     * This test changes the database contents by creating a new article. However,
//     * thanks to the DAMADoctrineTestBundle and its PHPUnit listener, all changes
//     * to the database are rolled back when this test completes. This means that
//     * all the application tests begin with the same database contents.
//     */
//    public function testAdminNewArticle()
//    {
//        $articleTitle = 'Article Title '.mt_rand();
//        $articleContains = $this->generateRandomString(255);
//        $articleType = $this->generateRandomString(1024);
//
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'jane_admin@symfony.com',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//        $crawler = $client->request('GET', '/admin/?action=new&entity=Article');
//        $form = $crawler->selectButton('Sauvegarder')->form([
//            'article[articleCategory]'  => ArticleCategory::ARTICLE_PRINCIPAL,
//            'article[title]'            => $articleTitle,
//            'article[contains]'         => $articleContains,
//        ]);
//        $client->submit($form);
//
//        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
//
//
//        /** @var Article $article */
//        $article = $client->getContainer()->get('doctrine')->getRepository(Article::class)->findOneBy([
//            'title' => $articleTitle,
//        ]);
//        $this->assertNotNull($article);
//        $this->assertSame($articleContains, $article->getTitle());
//        $this->assertSame($articleType, $article->getContains());
//        $this->assertSame($articleType, $article->getEnabled());
//        $this->assertSame($articleType, $article->getArticleCategory());
//    }
//
//    public function testAdminShowArticle()
//    {
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'jane_admin@symfony.com',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//        $client->request('GET', '/admin/?action=show&entity=Article&id=1');
//
//        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
//    }
//
//    /**
//     * This test changes the database contents by editing a article post. However,
//     * thanks to the DAMADoctrineTestBundle and its PHPUnit listener, all changes
//     * to the database are rolled back when this test completes. This means that
//     * all the application tests begin with the same database contents.
//     */
//    public function testAdminEditArticle()
//    {
//        $newArticleTitle = 'article Title '.mt_rand();
//
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'jane_admin@symfony.com',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//        $crawler = $client->request('GET', '/admin/?action=edit&entity=Article&id=1');
//        $form = $crawler->selectButton('Sauvegarder')->form([
//            'article[title]' => $newArticleTitle,
//        ]);
//        $client->submit($form);
//
//        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
//
//        /** @var Article $article */
//        $article = $client->getContainer()->get('doctrine')->getRepository(Article::class)->find(1);
//        $this->assertSame($newArticleTitle, $article->getTitle());
//    }
//
//    /**
//     * This test changes the database contents by deleting a article post. However,
//     * thanks to the DAMADoctrineTestBundle and its PHPUnit listener, all changes
//     * to the database are rolled back when this test completes. This means that
//     * all the application tests begin with the same database contents.
//     */
//    public function testAdminDeletePost()
//    {
//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'jane_admin@symfony.com',
//            'PHP_AUTH_PW' => 'kitten',
//        ]);
//        $crawler = $client->request('GET', '/admin/?action=delete&entity=Article&id=1');
//        $client->submit($crawler->filter('#delete-form')->form());
//
//        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
//
//        /** @var Article $article */
//        $article = $client->getContainer()->get('doctrine')->getRepository(Article::class)->find(1);
//        $this->assertNull($article);
//    }
//
//    private function generateRandomString(int $length): string
//    {
//        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//
//        return mb_substr(str_shuffle(str_repeat($chars, ceil($length / mb_strlen($chars)))), 1, $length);
//    }
}
