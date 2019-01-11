<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use App\Entity\Schedule;
use App\Entity\ArticleCategory;
use App\Entity\EnterpriseDetails;
use App\Entity\TaxRate;
use App\Entity\Category;
use App\Entity\Subcategory;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadSchedules($manager);
        $this->loadArticleCategory($manager);
        $this->loadArticle($manager);
        $this->loadEnterpriseDetails($manager);
        $this->loadTaxRate($manager);
        $this->loadCategory($manager);
        $this->loadSubCategory($manager);
        $this->loadProducts($manager);
        $this->loadOrders($manager);
        //$this->loadTags($manager);
        //$this->loadPosts($manager);
    }

    /**
     * Load information of users
     *
     * @param ObjectManager $manager
     */
    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$firstname, $lastname, $cellphone, $username, $password, $roles]) {
            $user = new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUsername($username);
            $user->setCellphone($cellphone);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    /**
     * Load information of schedules
     *
     * @param ObjectManager $manager
     */
    private function loadSchedules(ObjectManager $manager)
    {
        $schedule = new Schedule();
        $schedule->setId(1);
        $schedule->setMonday('Fermé');
        $schedule->setTuesday('De 9h-12h à 15h-19h');
        $schedule->setWednesday('De 9h-12h à 15h-19h');
        $schedule->setThursday('De 9h-12h à 15h-19h');
        $schedule->setFriday('De 9h-12h à 15h-19h');
        $schedule->setSaturday('De 9h-12h');
        $schedule->setSunday('Fermé');
        $schedule->setAlertDay('Fermeture exceptionnelle le XX.');

        $manager->persist($schedule);
        $manager->flush();
    }

    /**
     * Load information of article
     *
     * @param ObjectManager $manager
     */
    private function loadArticleCategory(ObjectManager $manager)
    {
        foreach ($this->getArticleCategoryData() as [$id, $name]) {
            $articleCategory = new ArticleCategory();
            $articleCategory->setId($id);
            $articleCategory->setName($name);
            $manager->persist($articleCategory);
            $this->addReference('article_category-' . $id, $articleCategory);
        }

        $manager->flush();
    }

    /**
     * Load information of article category
     *
     * @param ObjectManager $manager
     */
    private function loadArticle(ObjectManager $manager)
    {
        foreach ($this->getArticleData() as [$enabled, $title, $articleCategory, $contains]) {
            $article = new Article();
            $article->setEnabled($enabled);
            $article->setTitle($title);
            $article->setArticleCategory($articleCategory);
            $article->setContains($contains);
            $manager->persist($article);
        }

        $manager->flush();
    }

    /**
     * Load information of enterprise
     *
     * @param ObjectManager $manager
     */
    private function loadEnterpriseDetails(ObjectManager $manager)
    {
        $enterpriseDetails = new EnterpriseDetails();
        $enterpriseDetails->setId(1);
        $enterpriseDetails->setName('Mon entreprise');
        $enterpriseDetails->setAddress('9, rue des Moulins');
        $enterpriseDetails->setCodePostal('99510');
        $enterpriseDetails->setCity('Le village');
        $enterpriseDetails->setTelephone('01 11 11 11 87');
        $enterpriseDetails->setEmail('monentreprise@gmail.com');

        $manager->persist($enterpriseDetails);
        $manager->flush();
    }

    /**
     * Load information of tax rate
     *
     * @param ObjectManager $manager
     */
    private function loadTaxRate(ObjectManager $manager)
    {
        foreach ($this->getTaxRateData() as $index => $rate) {
            $taxRate = new TaxRate();
            $taxRate->setRate($rate);

            $manager->persist($taxRate);
            $this->addReference('tax-' . $rate, $taxRate);
        }

        $manager->flush();
    }

    /**
     * Load information of category
     *
     * @param ObjectManager $manager
     */
    private function loadCategory(ObjectManager $manager)
    {
        foreach ($this->getCategoryData() as [$name, $image, $enabled, $updates_at]) {
            $category = new Category();
            $category->setName($name);
            $category->setImage($image);
            $category->setEnabled($enabled);
            $category->setUpdatedAt($updates_at);

            $manager->persist($category);
            $this->addReference('category-' . $name, $category);
        }

        $manager->flush();
    }

    /**
     * Load information of subcategory
     *
     * @param ObjectManager $manager
     */
    private function loadSubCategory(ObjectManager $manager)
    {
        foreach ($this->getSubCategoryData() as [$name, $enabled, $category]) {
            $subcategory = new Subcategory();
            $subcategory->setName($name);
            $subcategory->setEnabled($enabled);
            $subcategory->setCategory($category);

            $manager->persist($subcategory);
            $this->addReference('subcategory-' . $name, $subcategory);
        }

        $manager->flush();
    }

    /**
     * Load information of two products
     *
     * @param ObjectManager $manager
     */
    private function loadProducts(ObjectManager $manager)
    {
        $i = 0;

        foreach ($this->getProductData() as [$name, $quantity, $description, $image, $isPurchase, $enabled, $createdAt, $updatedAt, $category, $subcategory, $packaging, $price, $refundable, $taxRate]) {

            $product = new Product();
            $product->setName($name);
            $product->setQuantity($quantity);
            $product->setDescription($description);
            $product->setImage($image);
            $product->setIsPurchase($isPurchase);
            $product->setEnabled($enabled);
            $product->setCreatedAt($createdAt);
            $product->setUpdatedAt($updatedAt);
            $product->setCategory($category);
            $product->setSubcategory($subcategory);
            $product->setPackaging($packaging);
            $product->setPrice($price);
            $product->setRefundable($refundable);
            $product->setTaxRate($taxRate);
            $this->addReference('product-' . $i, $product);

            $manager->persist($product);
            $i++;
        }

        $manager->flush();
    }

    private function loadOrders(ObjectManager $manager)
    {
        // $orderData = [$deliveryDate, $comment, $createdAt, $buyer]
        $orderItem = null;
        foreach ($this->getOrderData() as [$deliveryDate, $comment, $createdAt, $buyer]) {
            $order = new Purchase();
            $order->setDeliveryDate($deliveryDate);
            $order->setComment($comment);
            $order->setCreatedAt($createdAt);
            $order->setBuyer($buyer);

            foreach ($this->getItemData() as [$quantity, $price, $taxRate, $product]) {
                $orderItem = new PurchaseItem();
                $orderItem->setQuantity($quantity);
                $orderItem->setPrice($price);
                /* @var TaxRate $taxRate */
                $orderItem->setTaxRate($taxRate->getRate());
                $orderItem->setProduct($product);
                $orderItem->setPurchase($order);
                $order->addItem($orderItem);
            }

            $manager->persist($order);
        }
        $manager->flush();
    }

    private function loadTags(ObjectManager $manager)
    {
        foreach ($this->getTagData() as $index => $name) {
            $tag = new Tag();
            $tag->setName($name);

            $manager->persist($tag);
            $this->addReference('tag-' . $name, $tag);
        }

        $manager->flush();
    }

    private function loadPosts(ObjectManager $manager)
    {
        foreach ($this->getPostData() as [$title, $slug, $summary, $content, $publishedAt, $author, $tags]) {
            $post = new Post();
            $post->setTitle($title);
            $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            $post->addTag(...$tags);

            foreach (range(1, 5) as $i) {
                $comment = new Comment();
                $comment->setAuthor($this->getReference('john_user'));
                $comment->setContent($this->getRandomText(random_int(255, 512)));
                $comment->setPublishedAt(new \DateTime('now + ' . $i . 'seconds'));

                $post->addComment($comment);
            }

            $manager->persist($post);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        return [
            // $userData = [$firstname, $lastname, $cellphone, $username, $password, $roles];
            ['Anna', 'Admin', '0123456789','jane_admin@symfony.com', 'kitten', ['ROLE_ADMIN']],
            ['Tom', 'Admin', '0101020203','tom_admin@symfony.com', 'kitten', ['ROLE_ADMIN']],
            ['John', 'Doe', '0216497382','john_user@symfony.com', 'kitten', ['ROLE_USER']],
        ];
    }

    private function getArticleCategoryData(): array
    {
        return [
            // $userData = [$id, $name];
            [ArticleCategory::ARTICLE_PRINCIPAL, 'Article de présentation'],
            [ArticleCategory::ARTICLE_ENTERPRISE, 'Article sur l\'entreprise'],
            [ArticleCategory::ARTICLE_BANDEAU, 'Article sur le bandeau droit'],
            [ArticleCategory::ARTICLE_RECIPE, 'Article de recette'],
        ];
    }

    private function getArticleData(): array
    {
        return [
            // $userData = [$enabled, $title, $articleCategory, $contains];
            [true, 'Bienvenue au nouveau site de La Fromagerie du vignoble nantais', $this->getReference('article_category-' . ArticleCategory::ARTICLE_PRINCIPAL), 'Mon contenu est très limité'],
            [true, 'Présentation de l\'entreprise', $this->getReference('article_category-' . ArticleCategory::ARTICLE_ENTERPRISE), 'La passion fait naître un métier : celui de producteur-fromager. C’est alors qu’ils initient la fromagerie autour des 3 piliers fondateurs.'],
            [true, 'Notre phylosophie', $this->getReference('article_category-' . ArticleCategory::ARTICLE_BANDEAU), 'Notre production s\'organise dans le respect d\'une agriculture durable et la conservation des méthodes traditionnlles de fabrication. La totalité des fromages sont élaborés dans notre local'],
            [true, 'Ma recette', $this->getReference('article_category-' . ArticleCategory::ARTICLE_RECIPE), 'Notre recette est ...'],
        ];
    }

    private function getTaxRateData(): array
    {
        return [
            5.5,
            10,
            20,
        ];
    }

    private function getCategoryData(): array
    {
        return [
            // $categoryData = [$name, $image, $enabled, $updates_at];
            ['Fruit', '019-strawberry.svg', true, new \DateTime('2017-12-03 14:52:03')],
            ['Légume', '012-carrot.svg', true, new \DateTime('2017-12-03 14:52:21')],
            ['Pain', '009-food.svg', true, new \DateTime('2017-12-03 14:52:40')],
            ['Produit laitier', '006-drink.svg', true, new \DateTime('2017-12-03 14:54:24')],
            ['Viande', '013-steak.svg', true, new \DateTime('2017-12-03 14:54:24')],
            ['Vin', '014-glass.svg', true, new \DateTime('2017-12-03 14:54:24')],
            ['Bière', '011-pint.svg', true, new \DateTime('2017-12-03 14:54:24')],
        ];
    }

    private function getSubCategoryData(): array
    {
        return [
            // $subcategoryData = [$name, $enabled, $category];
            ['lait de vache', true, $this->getReference('category-Produit laitier')],
            ['lait de chèvre', true, $this->getReference('category-Produit laitier')],
            ['Ovin', true, $this->getReference('category-Viande')],
            ['Bovin', true, $this->getReference('category-Viande')],
            ['Volaille', true, $this->getReference('category-Viande')],
            ['Charcuterie', true, $this->getReference('category-Viande')],
        ];
    }

    /**
     * @return array
     */
    private function getProductData(): array
    {
        return [
            // $subcategoryData = [$name, $quantity, $description, $image, $isPurchase, $enabled, $createdAt, $updatedAt, $category, $subcategory, $packaging, $price, $refundable, $taxRate];
            ['Yaourt Nature', 10, '<p>Lait entier pasteurisé, puis réincorporation de ferments lactiques.</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'yaourt-nature.jpg', true, true, new \DateTime('2017-05-28 21:32:23'), new \DateTime('2017-05-28 21:32:24'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25 cl', 0.74, 0.16, $this->getReference('tax-5.5')],
            ['Yaourt Fraise', 10, '<p>Pr&eacute;paration de fruits sur sucre &agrave; la fraise</p><p>DLC/DLUO : 20 jours</p>', 'yaourt-fraise.jpg', true, true, new \DateTime('2017-05-28 21:46:05'), new \DateTime('2017-05-28 21:46:05'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25 cl', 0.95, 0.16, $this->getReference('tax-5.5')],
            ['Fromage Frais ail et fines herbes', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-ail-fines-herbes.jpg', true, true, new \DateTime('2017-06-01 20:56:19'), new \DateTime('2017-06-01 20:56:19'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, NULL, $this->getReference('tax-5.5')],
            ['Fromage Frais Estragon', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-estragon.jpg', true, true, new \DateTime('2017-06-01 21:14:59'), new \DateTime('2017-06-01 21:15:00'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, NULL, $this->getReference('tax-5.5')],
            ['Fromage Frais Cumin', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-cumin.jpg', true, true, new \DateTime('2017-06-01 21:15:46'), new \DateTime('2017-06-01 21:15:47'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, NULL, $this->getReference('tax-5.5')],
            ['Fromage Frais au cèpes', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-cepes.jpg', true, true, new \DateTime('2017-06-01 21:16:56'), new \DateTime('2017-06-01 21:16:56'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 3.15, NULL, $this->getReference('tax-5.5')],
            ['Fromage Frais au Poivre', 10, '<p>Enrobage d&rsquo;&eacute;pices d&eacute;shydrat&eacute;es</p><p>DLC/DLUO : 20 jours</p>', 'fromage-frais-poivre.jpg', true, true, new \DateTime('2017-06-01 21:17:37'), new \DateTime('2017-06-01 21:17:37'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, NULL, $this->getReference('tax-5.5')],
            ['Tomme des Allerons', 10, '<p>Lait entier cru maturé et caillé en cuve ; moulé puis affiné durant 2 mois minimum (période durant laquelle chaque Tome est frotté avec de l’eau, du sel et des ferments d’affinage). Poids final entre 1,6 kg et 2,5 kg.</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 2 mois</p>', 'la-tomme-des-allerons.jpg', true, true, new \DateTime('2017-06-01 21:29:21'), new \DateTime('2017-06-01 21:29:23'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), 'Au kg', 20.60, NULL, $this->getReference('tax-5.5')],
            ['Petit Rebignon', 10, '<p>Lait entier cru maturé et caillé en cuve ; moulé puis affiné durant 2 mois minimum (période durant laquelle chaque fromage est frotté avec de l’eau, du sel et des ferments d’affinage). Poids final entre 800 gr et 1,2 kg.</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 2 mois</p>', 'le-ptit-rebignon.jpg', false, true, new \DateTime('2017-06-01 21:30:15'), new \DateTime('2017-06-01 21:30:15'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), 'Au kg', 17.60, NULL, $this->getReference('tax-5.5')],
            ['Fromage Blanc 20% MG', 10, '<p>Lait demi-&eacute;cr&eacute;m&eacute; cru.</p><p>DLC/DLUO : 15 jours</p>', 'fromage-blanc-20.jpg', true, true, new \DateTime('2017-06-01 21:32:01'), new \DateTime('2017-06-01 21:32:02'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '400g', 3.34, 0.34, $this->getReference('tax-5.5')],
            ['Fromage Blanc 0% MG', 10, '<p>Lait totalement &eacute;cr&eacute;m&eacute; cru.</p><p>DLC/DLUO : 15 jours</p>', 'fromage-blanc-0.jpg', true, true, new \DateTime('2017-06-01 21:33:17'), new \DateTime('2017-06-01 21:33:18'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '400g', 3.24, 0.34, $this->getReference('tax-5.5')],
            ['Yaourt Abricot', 10, '<p>Préparation de fruits sur sucre à l\'abricot</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'yaourt-abricot.jpg', true, true, new \DateTime('2017-06-01 21:34:38'), new \DateTime('2017-06-01 21:34:38'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25cl', 0.95, 0.16, $this->getReference('tax-5.5')],
            ['Yaourt Pomme, cerise et cannelle', 10, '<p>Préparation de fruits sur sucre à la pomme, cerise et canelle</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'yaourt-pomme-cerise-cannelle.jpg', true, true, new \DateTime('2017-06-01 21:36:51'), new \DateTime('2017-06-01 21:36:51'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25cl', 0.95, 0.16, $this->getReference('tax-5.5')],
            ['Lait Cru (50 cl)', 10, '<p>Lait sans aucun traitement thermique, flore microbienne intacte&nbsp;; pas de standardisation (mati&egrave;re grasse, prot&eacute;ine et lactose)</p><p>DLC/DLUO : 5 jours</p>', 'lait-cru-50cl.jpg', true, true, new \DateTime('2017-06-01 21:37:45'), new \DateTime('2017-06-01 21:37:46'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '50 cl', 0.86, 0.36, $this->getReference('tax-5.5')],
            ['Lait Cru (1L)', 10, '<p>Lait sans aucun traitement thermique, flore microbienne intacte&nbsp;; pas de standardisation (mati&egrave;re grasse, prot&eacute;ine et lactose)</p><p>DLC/DLUO : 5 jours</p>', 'lait-cru-1l.jpg', true, true, new \DateTime('2017-06-01 21:38:46'), new \DateTime('2017-06-01 21:38:47'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '1L', 1.30, 0.45, $this->getReference('tax-5.5')],
            ['Crème crue', 0, '<p>Cr&egrave;me sans traitement thermique&hellip;</p><p>DLC/DLUO : 8 jours</p>', 'creme-crue.jpg', true, true, new \DateTime('2017-06-02 16:45:04'), new \DateTime('2017-06-02 16:45:05'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '200g', 2.22, 0.32, $this->getReference('tax-5.5')],
            ['Fromage blanc 40% MG', 10, '<p>Lait entier cru, matur&eacute; et caill&eacute; (pr&eacute;sure), puis &eacute;goutt&eacute; en toile (reste un peu plus de 40% du poids de d&eacute;part : &eacute;limination de l&rsquo;eau)</p><p>DLC/DLUO : 15 jours</p>', 'fromage-blanc-40.jpg', true, true, new \DateTime('2017-07-28 01:01:00'), new \DateTime('2017-07-28 01:01:00'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '400g', 3.29, 0.34, $this->getReference('tax-5.5')],
            ['Bière de Noël', 10, 'Ma description', NULL, true, false, new \DateTime('2017-07-28 01:01:00'), new \DateTime('2017-07-28 01:01:00'), $this->getReference('category-Bière'), NULL, '75cl', 5.00, NULL, $this->getReference('tax-20')]
        ];
    }

    private function getOrderData(): array
    {
        return
            // $orderData = [$deliveryDate, $comment, $createdAt, $buyer]
            [
                [new \DateTime('2017-06-01 20:56:19'), 'Commande à recevoir en fin de journée', new \DateTime('2017-12-06 14:50:36'), $this->getReference('jane_admin@symfony.com')],
                [new \DateTime('2017-06-02 21:56:19'), null, new \DateTime('2017-12-06 14:50:36'), $this->getReference('jane_admin@symfony.com')]
            ];
    }

    private function getItemData(): array
    {
        $items = [];
        $countProduct = count($this->getProductData()) - 1;
        $nbItems = mt_rand (1, $countProduct);

        for ($x = 0; $x <= $nbItems; $x++) {
            // $itemData = [$quantity, $price, $taxRate, $product];
            $items[] = [
                mt_rand (0, 10),
                $this->frand(1, 10, 2),
                $this->getReference('tax-5.5'),
                $this->getReference('product-'. mt_rand (0, $countProduct))
            ];
        }

        return $items;
    }


    private function getTagData(): array
    {
        return [
            'lorem',
            'ipsum',
            'consectetur',
            'adipiscing',
            'incididunt',
            'labore',
            'voluptate',
            'dolore',
            'pariatur',
        ];
    }

    private function getPostData()
    {
        $posts = [];
        foreach ($this->getPhrases() as $i => $title) {
            // $postData = [$title, $slug, $summary, $content, $publishedAt, $author, $tags, $comments];
            $posts[] = [
                $title,
                Slugger::slugify($title),
                $this->getRandomText(),
                $this->getPostContent(),
                new \DateTime('now - ' . $i . 'days'),
                // Ensure that the first post is written by Jane Doe to simplify tests
                $this->getReference(['jane_admin', 'tom_admin'][0 === $i ? 0 : random_int(0, 1)]),
                $this->getRandomTags(),
            ];
        }

        return $posts;
    }

    private function getPhrases(): array
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
            'Ubi est barbatus nix',
            'Abnobas sunt hilotaes de placidus vita',
            'Ubi est audax amicitia',
            'Eposs sunt solems de superbus fortis',
            'Vae humani generis',
            'Diatrias tolerare tanquam noster caesium',
            'Teres talis saepe tractare de camerarius flavum sensorem',
            'Silva de secundus galatae demitto quadra',
            'Sunt accentores vitare salvus flavum parses',
            'Potus sensim ad ferox abnoba',
            'Sunt seculaes transferre talis camerarius fluctuies',
            'Era brevis ratione est',
            'Sunt torquises imitari velox mirabilis medicinaes',
            'Mineralis persuadere omnes finises desiderium',
            'Bassus fatalis classiss virtualiter transferre de flavum',
        ];
    }

    private function getRandomText(int $maxLength = 255): string
    {
        $phrases = $this->getPhrases();
        shuffle($phrases);

        while (mb_strlen($text = implode('. ', $phrases) . '.') > $maxLength) {
            array_pop($phrases);
        }

        return $text;
    }

    private function getPostContent(): string
    {
        return <<<'MARKDOWN'
Lorem ipsum dolor sit amet consectetur adipisicing elit, sed do eiusmod tempor
incididunt ut labore et **dolore magna aliqua**: Duis aute irure dolor in
reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
deserunt mollit anim id est laborum.

  * Ut enim ad minim veniam
  * Quis nostrud exercitation *ullamco laboris*
  * Nisi ut aliquip ex ea commodo consequat

Praesent id fermentum lorem. Ut est lorem, fringilla at accumsan nec, euismod at
nunc. Aenean mattis sollicitudin mattis. Nullam pulvinar vestibulum bibendum.
Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos
himenaeos. Fusce nulla purus, gravida ac interdum ut, blandit eget ex. Duis a
luctus dolor.

Integer auctor massa maximus nulla scelerisque accumsan. *Aliquam ac malesuada*
ex. Pellentesque tortor magna, vulputate eu vulputate ut, venenatis ac lectus.
Praesent ut lacinia sem. Mauris a lectus eget felis mollis feugiat. Quisque
efficitur, mi ut semper pulvinar, urna urna blandit massa, eget tincidunt augue
nulla vitae est.

Ut posuere aliquet tincidunt. Aliquam erat volutpat. **Class aptent taciti**
sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi
arcu orci, gravida eget aliquam eu, suscipit et ante. Morbi vulputate metus vel
ipsum finibus, ut dapibus massa feugiat. Vestibulum vel lobortis libero. Sed
tincidunt tellus et viverra scelerisque. Pellentesque tincidunt cursus felis.
Sed in egestas erat.

Aliquam pulvinar interdum massa, vel ullamcorper ante consectetur eu. Vestibulum
lacinia ac enim vel placerat. Integer pulvinar magna nec dui malesuada, nec
congue nisl dictum. Donec mollis nisl tortor, at congue erat consequat a. Nam
tempus elit porta, blandit elit vel, viverra lorem. Sed sit amet tellus
tincidunt, faucibus nisl in, aliquet libero.
MARKDOWN;
    }

    private function getRandomTags(): array
    {
        $tagNames = $this->getTagData();
        shuffle($tagNames);
        $selectedTags = array_slice($tagNames, 0, random_int(2, 4));

        return array_map(function ($tagName) {
            return $this->getReference('tag-' . $tagName);
        }, $selectedTags);
    }


    private function frand($min, $max, $decimals = 0) {
        $scale = pow(10, $decimals);
        return mt_rand($min * $scale, $max * $scale) / $scale;
    }
}
