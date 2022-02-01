<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\ProductOrderItem;
use App\Entity\Schedule;
use App\Entity\Subcategory;
use App\Entity\User;
use App\Entity\VatRate;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function count;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $output;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->output =  new ConsoleOutput();
    }

    /**
     * Load all data fixture
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadSchedules($manager);
        $this->loadArticleCategory($manager);
        $this->loadArticle($manager);
        $this->loadCompany($manager);
        $this->loadVatRate($manager);
        $this->loadCategory($manager);
        $this->loadSubCategory($manager);
        $this->loadProducts($manager);
        $this->loadProductOrders($manager);
    }

    /**
     * Load information of users.
     *
     * @param ObjectManager $manager
     */
    private function loadUsers(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        foreach ($this->getUserData() as [$firstName, $lastName, $phone, $email, $password, $roles]) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUsername($email);
            $user->setPhone($phone);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($email, $user);
        }

        $manager->flush();
    }

    /**
     * Load information of schedules.
     *
     * @param ObjectManager $manager
     */
    private function loadSchedules(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        $schedule = new Schedule();
        $schedule->setId(1);
        $schedule->setMonday(Schedule::CLOSED_DAY);
        $schedule->setTuesday('De 9h-12h à 15h-19h');
        $schedule->setWednesday('De 9h-12h à 15h-19h');
        $schedule->setThursday('De 9h-12h à 15h-19h');
        $schedule->setFriday('De 9h-12h à 15h-19h');
        $schedule->setSaturday('De 9h-12h');
        $schedule->setSunday(Schedule::CLOSED_DAY);
        $schedule->setAlertDay('Fermeture exceptionnelle le XX.');

        $manager->persist($schedule);
        $manager->flush();
    }

    /**
     * Load information of article.
     *
     * @param ObjectManager $manager
     */
    private function loadArticleCategory(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        foreach ($this->getArticleCategoryData() as [$id, $name]) {
            $articleCategory = new ArticleCategory();
            $articleCategory->setId($id);
            $articleCategory->setName($name);
            $manager->persist($articleCategory);
            $this->addReference('article_category-'.$id, $articleCategory);
        }

        $manager->flush();
    }

    /**
     * Load information of article category.
     *
     * @param ObjectManager $manager
     */
    private function loadArticle(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
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
     * Loading information of company
     * @param ObjectManager $manager
     */
    private function loadCompany(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        $company = new Company();
        $company->setId(1);
        $company->setName('Mon entreprise');
        $company->setAddress('9, rue des Moulins');
        $company->setPostcode('99510');
        $company->setCity('Le village');
        $company->setPhone('01 11 11 11 87');
        $company->setEmail('monentreprise@gmail.com');

        $manager->persist($company);
        $manager->flush();
    }

    /**
     * Load information of VAT rate.
     *
     * @param ObjectManager $manager
     */
    private function loadVatRate(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        foreach ($this->getVatRateData() as $index => $rate) {
            $taxRate = new VatRate();
            $taxRate->setRate($rate);

            $manager->persist($taxRate);
            $this->addReference('tax-'.$rate, $taxRate);
        }

        $manager->flush();
    }

    /**
     * Load information of category.
     *
     * @param ObjectManager $manager
     */
    private function loadCategory(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        foreach ($this->getCategoryData() as [$name, $image, $enabled, $updates_at]) {
            $category = new Category();
            $category->setName($name);
            $category->setImage($image);
            $category->setEnabled($enabled);
            $category->setUpdatedAt($updates_at);

            $manager->persist($category);
            $this->addReference('category-'.$name, $category);
        }

        $manager->flush();
    }

    /**
     * Load information of subcategory.
     *
     * @param ObjectManager $manager
     */
    private function loadSubCategory(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        foreach ($this->getSubCategoryData() as [$name, $enabled, $category]) {
            $subcategory = new Subcategory();
            $subcategory->setName($name);
            $subcategory->setEnabled($enabled);
            $subcategory->setCategory($category);

            $manager->persist($subcategory);
            $this->addReference('subcategory-'.$name, $subcategory);
        }

        $manager->flush();
    }

    /**
     * Load information of products.
     *
     * @param ObjectManager $manager
     */
    private function loadProducts(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        $i = 0;
        foreach ($this->getProductData() as [$name, $quantity, $description, $image, $isCanBeOrdered, $enabled, $createdAt, $updatedAt, $category, $subcategory, $packaging, $price, $refundable, $vatRate]) {
            $product = new Product();
            $product->setName($name);
            $product->setQuantity($quantity);
            $product->setDescription($description);
            $product->setImage($image);
            $product->setIsCanBeOrdered($isCanBeOrdered);
            $product->setEnabled($enabled);
            $product->setCreatedAt($createdAt);
            $product->setUpdatedAt($updatedAt);
            $product->setCategory($category);
            $product->setSubcategory($subcategory);
            $product->setPackaging($packaging);
            $product->setPrice($price);
            $product->setRefundable($refundable);
            $product->setVatRate($vatRate);
            $this->addReference('product-'.$i, $product);

            $manager->persist($product);
            ++$i;
        }

        $manager->flush();
    }

    /**
     * Load information of product orders
     * @param ObjectManager $manager
     */
    private function loadProductOrders(ObjectManager $manager): void
    {
        $this->notification(__FUNCTION__);
        // $orderData = [$deliveryDate, $comment, $createdAt, $user]
        $orderItem = null;
        foreach ($this->getProductOrderData() as [$deliveryDate, $comment, $createdAt, $user]) {
            $productOrder = new ProductOrder();
            /* @var DateTime $deliveryDate */
            $productOrder->setDeliveryDate($deliveryDate);
            $productOrder->setComment($comment);
            $productOrder->setCreatedAt($createdAt);
            $productOrder->setUser($user);

            foreach ($this->getProductOrderItemData() as [$quantity, $taxRate, $product]) {
                $orderItem = new ProductOrderItem();
                $orderItem->setQuantity($quantity);
                /* @var Product $product */
                $orderItem->setPrice($product->getPrice() * $quantity);
                /* @var VatRate $taxRate */
                $orderItem->setVatRate($taxRate->getRate());
                $orderItem->setProduct($product);
                $orderItem->setProductOrder($productOrder);
                $productOrder->addItem($orderItem);
            }

            $manager->persist($productOrder);
        }
        $manager->flush();
    }

    /**
     * Get user data
     * @return array|array[]
     */
    private function getUserData(): array
    {
        return [
            // $userData = [$firstName, $lastName, $phone, $email, $password, $roles];
            ['Anna', 'Admin', '0123456789', 'jane_admin@symfony.com', 'kitten', ['ROLE_ADMIN']],
            ['Tom', 'Admin', '0101020203', 'tom_admin@symfony.com', 'kitten', ['ROLE_ADMIN']],
            ['John', 'Doe', '0216497382', 'john_user@symfony.com', 'kitten', ['ROLE_USER']],
        ];
    }

    /**
     * Get article category data
     * @return array|array[]
     */
    private function getArticleCategoryData(): array
    {
        return [
            // $userData = [$id, $name];
            [ArticleCategory::MAIN_ARTICLE, 'Article de présentation'],
            [ArticleCategory::COMPANY_ARTICLE, 'Article sur l\'entreprise'],
            [ArticleCategory::BANNER_ARTICLE, 'Article sur le bandeau droit'],
            [ArticleCategory::RECIPE_ARTICLE, 'Article de recette'],
        ];
    }

    /**
     * Get article data
     * @return array|array[]
     */
    private function getArticleData(): array
    {
        return [
            // $userData = [$enabled, $title, $articleCategory, $contains];
            [true, 'Bienvenue au nouveau site de La Fromagerie du vignoble nantais', $this->getReference('article_category-'.ArticleCategory::MAIN_ARTICLE), 'Mon contenu est très limité'],
            [true, 'Présentation de l\'entreprise', $this->getReference('article_category-'.ArticleCategory::COMPANY_ARTICLE), 'La passion fait naître un métier : celui de producteur-fromager. C’est alors qu’ils initient la fromagerie autour des 3 piliers fondateurs.'],
            [true, 'Notre phylosophie', $this->getReference('article_category-'.ArticleCategory::BANNER_ARTICLE), 'Notre production s\'organise dans le respect d\'une agriculture durable et la conservation des méthodes traditionnlles de fabrication. La totalité des fromages sont élaborés dans notre local'],
            [true, 'Ma recette', $this->getReference('article_category-'.ArticleCategory::RECIPE_ARTICLE), 'Notre recette est ...'],
        ];
    }

    /**
     * Get VAT rate data
     * @return array
     */
    private function getVatRateData(): array
    {
        return [
            5.5,
            10,
            20,
        ];
    }

    /**
     * Get category data
     * @return array|array[]
     */
    private function getCategoryData(): array
    {
        return [
            // $categoryData = [$name, $image, $enabled, $updates_at];
            ['Fruit', '019-strawberry.svg', true, new DateTime('2017-12-03 14:52:03')],
            ['Légume', '012-carrot.svg', true, new DateTime('2017-12-03 14:52:21')],
            ['Pain', '009-food.svg', true, new DateTime('2017-12-03 14:52:40')],
            ['Produit laitier', '006-drink.svg', true, new DateTime('2017-12-03 14:54:24')],
            ['Viande', '013-steak.svg', true, new DateTime('2017-12-03 14:54:24')],
            ['Vin', '014-glass.svg', true, new DateTime('2017-12-03 14:54:24')],
            ['Bière', '011-pint.svg', true, new DateTime('2017-12-03 14:54:24')],
        ];
    }

    /**
     * Get subcategory data
     * @return array|array[]
     */
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
     * Get product data
     * @return array
     */
    private function getProductData(): array
    {
        return [
            // $subcategoryData = [$name, $quantity, $description, $image, $isCanBeOrdered, $enabled, $createdAt, $updatedAt, $category, $subcategory, $packaging, $price, $refundable, $vatRate];
            ['Yaourt Nature', 10, '<p>Lait entier pasteurisé, puis réincorporation de ferments lactiques.</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'yaourt-nature.jpg', true, true, new DateTime('2017-05-28 21:32:23'), new DateTime('2017-05-28 21:32:24'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25 cl', 0.74, 0.16, $this->getReference('tax-5.5')],
            ['Yaourt Fraise', 10, '<p>Pr&eacute;paration de fruits sur sucre &agrave; la fraise</p><p>DLC/DLUO : 20 jours</p>', 'yaourt-fraise.jpg', true, true, new DateTime('2017-05-28 21:46:05'), new DateTime('2017-05-28 21:46:05'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25 cl', 0.95, 0.16, $this->getReference('tax-5.5')],
            ['Fromage Frais ail et fines herbes', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-ail-fines-herbes.jpg', true, true, new DateTime('2017-06-01 20:56:19'), new DateTime('2017-06-01 20:56:19'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, null, $this->getReference('tax-5.5')],
            ['Fromage Frais Estragon', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-estragon.jpg', true, true, new DateTime('2017-06-01 21:14:59'), new DateTime('2017-06-01 21:15:00'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, null, $this->getReference('tax-5.5')],
            ['Fromage Frais Cumin', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-cumin.jpg', true, true, new DateTime('2017-06-01 21:15:46'), new DateTime('2017-06-01 21:15:47'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, null, $this->getReference('tax-5.5')],
            ['Fromage Frais au cèpes', 10, '<p>Enrobage d’épices déshydratées</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'fromage-frais-cepes.jpg', true, true, new DateTime('2017-06-01 21:16:56'), new DateTime('2017-06-01 21:16:56'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 3.15, null, $this->getReference('tax-5.5')],
            ['Fromage Frais au Poivre', 10, '<p>Enrobage d&rsquo;&eacute;pices d&eacute;shydrat&eacute;es</p><p>DLC/DLUO : 20 jours</p>', 'fromage-frais-poivre.jpg', true, true, new DateTime('2017-06-01 21:17:37'), new DateTime('2017-06-01 21:17:37'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '160g à 180g', 2.95, null, $this->getReference('tax-5.5')],
            ['Tomme des Allerons', 10, '<p>Lait entier cru maturé et caillé en cuve ; moulé puis affiné durant 2 mois minimum (période durant laquelle chaque Tome est frotté avec de l’eau, du sel et des ferments d’affinage). Poids final entre 1,6 kg et 2,5 kg.</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 2 mois</p>', 'la-tomme-des-allerons.jpg', true, true, new DateTime('2017-06-01 21:29:21'), new DateTime('2017-06-01 21:29:23'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), 'Au kg', 20.60, null, $this->getReference('tax-5.5')],
            ['Petit Rebignon', 10, '<p>Lait entier cru maturé et caillé en cuve ; moulé puis affiné durant 2 mois minimum (période durant laquelle chaque fromage est frotté avec de l’eau, du sel et des ferments d’affinage). Poids final entre 800 gr et 1,2 kg.</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 2 mois</p>', 'le-ptit-rebignon.jpg', false, true, new DateTime('2017-06-01 21:30:15'), new DateTime('2017-06-01 21:30:15'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), 'Au kg', 17.60, null, $this->getReference('tax-5.5')],
            ['Fromage Blanc 20% MG', 10, '<p>Lait demi-&eacute;cr&eacute;m&eacute; cru.</p><p>DLC/DLUO : 15 jours</p>', 'fromage-blanc-20.jpg', true, true, new DateTime('2017-06-01 21:32:01'), new DateTime('2017-06-01 21:32:02'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '400g', 3.34, 0.34, $this->getReference('tax-5.5')],
            ['Fromage Blanc 0% MG', 10, '<p>Lait totalement &eacute;cr&eacute;m&eacute; cru.</p><p>DLC/DLUO : 15 jours</p>', 'fromage-blanc-0.jpg', true, true, new DateTime('2017-06-01 21:33:17'), new DateTime('2017-06-01 21:33:18'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '400g', 3.24, 0.34, $this->getReference('tax-5.5')],
            ['Yaourt Abricot', 10, '<p>Préparation de fruits sur sucre à l\'abricot</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'yaourt-abricot.jpg', true, true, new DateTime('2017-06-01 21:34:38'), new DateTime('2017-06-01 21:34:38'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25cl', 0.95, 0.16, $this->getReference('tax-5.5')],
            ['Yaourt Pomme, cerise et cannelle', 10, '<p>Préparation de fruits sur sucre à la pomme, cerise et canelle</p><p><abbr TITLE="Date limite de consommation/Date limite d\'utilisation optimale">DLC/DLUO</abbr> : 20 jours</p>', 'yaourt-pomme-cerise-cannelle.jpg', true, true, new DateTime('2017-06-01 21:36:51'), new DateTime('2017-06-01 21:36:51'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '25cl', 0.95, 0.16, $this->getReference('tax-5.5')],
            ['Lait Cru (50 cl)', 10, '<p>Lait sans aucun traitement thermique, flore microbienne intacte&nbsp;; pas de standardisation (mati&egrave;re grasse, prot&eacute;ine et lactose)</p><p>DLC/DLUO : 5 jours</p>', 'lait-cru-50cl.jpg', true, true, new DateTime('2017-06-01 21:37:45'), new DateTime('2017-06-01 21:37:46'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '50 cl', 0.86, 0.36, $this->getReference('tax-5.5')],
            ['Lait Cru (1L)', 10, '<p>Lait sans aucun traitement thermique, flore microbienne intacte&nbsp;; pas de standardisation (mati&egrave;re grasse, prot&eacute;ine et lactose)</p><p>DLC/DLUO : 5 jours</p>', 'lait-cru-1l.jpg', true, true, new DateTime('2017-06-01 21:38:46'), new DateTime('2017-06-01 21:38:47'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '1L', 1.30, 0.45, $this->getReference('tax-5.5')],
            ['Crème crue', 0, '<p>Cr&egrave;me sans traitement thermique&hellip;</p><p>DLC/DLUO : 8 jours</p>', 'creme-crue.jpg', true, true, new DateTime('2017-06-02 16:45:04'), new DateTime('2017-06-02 16:45:05'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '200g', 2.22, 0.32, $this->getReference('tax-5.5')],
            ['Fromage blanc 40% MG', 10, '<p>Lait entier cru, matur&eacute; et caill&eacute; (pr&eacute;sure), puis &eacute;goutt&eacute; en toile (reste un peu plus de 40% du poids de d&eacute;part : &eacute;limination de l&rsquo;eau)</p><p>DLC/DLUO : 15 jours</p>', 'fromage-blanc-40.jpg', true, true, new DateTime('2017-07-28 01:01:00'), new DateTime('2017-07-28 01:01:00'), $this->getReference('category-Produit laitier'), $this->getReference('subcategory-lait de vache'), '400g', 3.29, 0.34, $this->getReference('tax-5.5')],
            ['Bière de Noël', 10, 'Ma description', null, true, false, new DateTime('2017-07-28 01:01:00'), new DateTime('2017-07-28 01:01:00'), $this->getReference('category-Bière'), null, '75cl', 5.00, null, $this->getReference('tax-20')],
        ];
    }

    /**
     * Get product order data
     * @return array|array[]
     */
    private function getProductOrderData(): array
    {
        return
            // $orderData = [$deliveryDate, $comment, $createdAt, $user]
            [
                [new DateTime('2017-06-01 20:56:19'), 'Commande à recevoir en fin de journée', new DateTime('2017-12-06 14:50:36'), $this->getReference('jane_admin@symfony.com')],
                [new DateTime('2017-06-02 21:56:19'), null, new DateTime('2017-12-06 14:50:36'), $this->getReference('jane_admin@symfony.com')],
            ];
    }

    /**
     * Get product order item data
     * @return array
     */
    private function getProductOrderItemData(): array
    {
        $items = [];
        $countProduct = count($this->getProductData()) - 1;
        $nbItems = mt_rand(1, $countProduct);

        for ($x = 0; $x <= $nbItems; ++$x) {
            // $itemData = [$quantity, $taxRate, $product];
            $items[] = [
                mt_rand(0, 10),
                $this->getReference('tax-5.5'),
                $this->getReference('product-'.mt_rand(0, $countProduct)),
            ];
        }

        return $items;
    }

    private function notification(string $functionName): void
    {
        $text = str_replace('load', 'loading ', $functionName);
        $this->output->writeln('   <comment>></comment> <info>' . $text . '</info>');
    }
}
