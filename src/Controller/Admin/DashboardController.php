<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\Schedule;
use App\Entity\Subcategory;
use App\Entity\User;
use App\Entity\VatRate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Lfdvn')
            // the argument is the name of any valid Symfony translation domain
            ->setTranslationDomain('admin');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section("menu_header.products");
        yield MenuItem::linkToCrud('label.product', 'fas fa-barcode', Product::class);
        yield MenuItem::linkToCrud('label.category', 'fas fa-tag', Category::class);
        yield MenuItem::linkToCrud('label.sub_category', 'fas fa-tags', Subcategory::class);
        yield MenuItem::linkToCrud('label.vat_rate', 'fas fa-percent', VatRate::class);
        yield MenuItem::section("menu_header.product_orders");
        yield MenuItem::linkToCrud('label.product_order', 'fas fa-shopping-cart', ProductOrder::class);
        yield MenuItem::section("menu_header.company");
        yield MenuItem::linkToCrud('label.article', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('label.company', 'fas fa-sitemap', Company::class);
        yield MenuItem::linkToCrud('label.schedule', 'fas fa-calendar', Schedule::class);
        yield MenuItem::section("menu_header.users");
        yield MenuItem::linkToCrud('label.user', 'fas fa-users', User::class);
    }
}
