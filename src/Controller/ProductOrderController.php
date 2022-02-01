<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductOrder;
use App\Entity\ProductOrderItem;
use App\Entity\Schedule;
use App\Form\ProductOrderType;
use App\Repository\CategoryRepository;
use App\Repository\ProductOrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ScheduleRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

/** @Route({
 *     "fr": "/commander",
 *     "en": "/product-order"
 * })
 *
 * Class ProductOrderController
 * @package App\Controller
 */
class ProductOrderController extends AbstractController
{
    /**
     * @var int
     */
    const NB_OPENED_DAYS = 20;

    /**
     * @Route("/", methods="GET", name="product_order_index")
     */
    public function index(): Response
    {
        $productOrders = $this->getDoctrine()
            ->getRepository(ProductOrder::class)
            ->findAll();

        return $this->render('product_order/index.html.twig', [
            'product_orders' => $productOrders,
        ]);
    }


    /**
     * @Route({
     *     "fr": "/etape1",
     *     "en": "/step1"
     * }, methods={"GET"}, name="product_order_step1")
     *
     * @param SessionInterface $session
     * @param CategoryRepository $categoryRepository
     * @param ScheduleRepository $scheduleRepository
     * @return Response
     */
    public function step1(SessionInterface $session, CategoryRepository $categoryRepository, ScheduleRepository $scheduleRepository, TranslatorInterface $translator): Response
    {
        $categories = $categoryRepository->findActiveCategory();

        /* @var Schedule $schedule */
        $schedule = $scheduleRepository->find(1);

        $session->set('productOrder', []);
        //$filters = $session->get('productOrder', []);

        return $this->render('product_order/step1.html.twig', [
            'categories' => $categories,
            //'filters' => $filters,
            'datesForDelivery' => $this->getDatesForDelivery($schedule, $translator),
            'currentStep' => 1,
        ]);
    }

    /**
     * @Route({
     *     "fr": "/etape2",
     *     "en": "/step2"
     * }, methods={"GET", "POST"}, name="product_order_step2")
     *
     * @param AuthenticationUtils $helper
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function step2(AuthenticationUtils $helper, Request $request, SessionInterface $session): Response
    {
        $session->set('productOrder', $this->cleanProductOrderParams($request->request));

        /** @var UserInterface  $user */
        $user = $this->getUser();

        // Check if user is connected
        if (null !== $user) {
            // redirect in step 3 is connected
//     		return $this->render('productOrder/step3.html.twig');
            return  $this->forward('App\Controller\ProductOrderController::step3');
        }

        return $this->render('product_order/step2.html.twig', [
            // last username entered by the user (if any)
            'last_username' => $helper->getLastUsername(),
            // last authentication error (if any)
            'error' => $helper->getLastAuthenticationError(),
            'currentStep' => 2,
        ]);
    }

    /**
     * @Route({
     *     "fr": "/etape3",
     *     "en": "/step3"
     * }, methods={"GET"}, name="product_order_step3")
     *
     * @param SessionInterface    $session
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function step3(SessionInterface $session, TranslatorInterface $translator, ProductRepository $productRepository): Response
    {
        // Check if user is connected
        if (null === $this->getUser()) {
            // redirect in step 2 isn't connected
            return  $this->forward('App\Controller\ProductOrderController::step2');
        } elseif (empty($session->get('productOrder'))) {
            // redirect in step 1 isn't productOrder object
            return  $this->forward('App\Controller\ProductOrderController::step1');
        }

        $sessionProductOrder = $session->get('productOrder');

        if($sessionProductOrder == null) {
            return  $this->forward('App\Controller\ProductOrderController::step1');
        }
        // On créé un objet productOrder
        $productOrder = $this->constructProductOrder($sessionProductOrder, $translator, $productRepository);
        $total = 0;

        foreach ($productOrder->getItems() as $item) {
            $total += $item->getPrice();
        }

        return $this->render('product_order/step3.html.twig', [
            'productOrder' => $productOrder,
            'total' => $total,
            'currentStep' => 3,
        ]);
    }

    /**
     * @Route({
     *     "fr": "/etape4",
     *     "en": "/step4"
     * }, methods={"GET", "POST"}, name="product_order_step4")
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     * @param ManagerRegistry $doctrine
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function step4(Request $request, SessionInterface $session, TranslatorInterface $translator, ManagerRegistry $doctrine, ProductRepository $productRepository, UserRepository $userRepository)
    {
        // Check if user is connected
        if (null === $this->getUser()) {
            // redirect in step 2 isn't connected
            return  $this->forward('App\Controller\ProductOrderController::step2');
        } elseif (null === $session->get('productOrder')) {
            // redirect in step 1 isn't productOrder object
            return  $this->forward('App\Controller\ProductOrderController::step1');
        }

        if ($request->isMethod('post')) {
            $total = 0;
            $productOrder = $this->constructProductOrder($session->get('productOrder'), $translator, $productRepository);
            $productOrder->setUser($userRepository->findUser($this->getUser()));
            $productOrder->setComment($request->request->get('comment'));

            $doctrine->getManager()->persist($productOrder);
            $doctrine->getManager()->flush();

            foreach ($productOrder->getItems() as $item) {
                $total += $item->getPrice();
            }

            // delete data session
            $session->clear();

            //$this->sendCustomerMail($productOrder, $total, $mailer);
            //$this->sendEnterpriseMail($productOrder, $total, $mailer);

            return $this->render('product_order/step4.html.twig', [
                'currentStep' => 4,
            ]);
            // 		    	return $this->render('email/enterprise_product_order.html.twig', array(
// 	    			'productOrder' => $productOrder,
// 	    			'total' => $total
// 	    		));
        }

        return  $this->forward('App\Controller\ProductOrderController::step3');
    }

    private function cleanProductOrderParams($params)
    {
        $cleanedParams = [];

        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $cleanedParams[$key] = $value;
            }
        }
        return $cleanedParams;
    }

    /**
     * @param $params
     * @param TranslatorInterface $translator
     *
     * @return ProductOrder
     */
    private function constructProductOrder($params, TranslatorInterface $translator, ProductRepository $productRepository): ProductOrder
    {
        // Initi<alization
        $productOrder = new ProductOrder();
        $listIdProducts = [];

        // Recuperate all products
        $products = $productRepository->findAll();

        // Recuperate all id products
        /** @var Product $product */
        foreach ($products as $product) {
            $listIdProducts[$product->getId()] = $product;
        }
        foreach ($params as $key => $value) {
            $currentlyKey = str_replace('qte_', '', $key);
//     		echo $currentlyKey . PHP_EOL;
//     		echo $value . PHP_EOL;
//     		echo $listIdProducts[$currentlyKey] . PHP_EOL;
            if (!empty($value) && is_numeric($currentlyKey) && isset($listIdProducts[$currentlyKey])) {
                /* @var $product Product */
                $product = $productRepository->find($currentlyKey);
                $productOrderItem = new ProductOrderItem();
                $productOrderItem->setQuantity($value);
                $productOrderItem->setProduct($product);
                $productOrderItem->setPrice($value * $product->getPrice());
                $productOrderItem->setVatRate($product->getVatRate()->getRate());
                $productOrderItem->setProductOrder($productOrder);
                // Add item to list
                $productOrder->addItem($productOrderItem);
            } elseif ('delivery_date' === $key) {
                // 	    		$productOrder->setDeliveryDate($value);
                // create Date object according to the value
                $productOrder->setDeliveryDateFormatted($this->getDateFormatted($value, $translator));
                $productOrder->setDeliveryDate(date_create($value));
            }
        }

        return $productOrder;
    }

    /**
     * @Route("/new", name="product_order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productOrder = new ProductOrder();
        $form = $this->createForm(ProductOrderType::class, $productOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productOrder);
            $entityManager->flush();

            return $this->redirectToRoute('product_order_index');
        }

        return $this->render('product_order/new.html.twig', [
            'product_order' => $productOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_order_show", methods={"GET"})
     */
    public function show(ProductOrder $productOrder): Response
    {
        return $this->render('product_order/show.html.twig', [
            'product_order' => $productOrder,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductOrder $productOrder): Response
    {
        $form = $this->createForm(ProductOrderType::class, $productOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_order_index');
        }

        return $this->render('product_order/edit.html.twig', [
            'product_order' => $productOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductOrder $productOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productOrder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_order_index');
    }

    /**
     * @param Schedule            $schedule
     *
     * @return array
     */
    private function getDatesForDelivery(Schedule $schedule, TranslatorInterface $translator)
    {
        $countDay = 0;
        $collectDays = [];
        $openDays = [];

        if (Schedule::CLOSED_DAY !== $schedule->getMonday()) {
            $openDays[] = 1;
        }
        if (Schedule::CLOSED_DAY !== $schedule->getTuesday()) {
            $openDays[] = 2;
        }
        if (Schedule::CLOSED_DAY !== $schedule->getWednesday()) {
            $openDays[] = 3;
        }
        if (Schedule::CLOSED_DAY !== $schedule->getThursday()) {
            $openDays[] = 4;
        }
        if (Schedule::CLOSED_DAY !== $schedule->getFriday()) {
            $openDays[] = 5;
        }
        if (Schedule::CLOSED_DAY !== $schedule->getSaturday()) {
            $openDays[] = 6;
        }
        if (Schedule::CLOSED_DAY !== $schedule->getSunday()) {
            $openDays[] = 7;
        }

        $date = date('Y-m-d'); // Format AAAA-MM-DD
        // On récupère le numero du jour pour savoir si on est un samedi ou un dimanche
        $collectDay = (int) date('N', strtotime($date));
        $collectDays = [];

        // We take 20 opened days
        while ($countDay < self::NB_OPENED_DAYS) {
            if (in_array($collectDay, $openDays, true)) {
//     			$collectDays[] = date('d/m/Y', strtotime($date)) ;
                $key = date('Y-m-d', strtotime($date));
                //$value = $key;
                $value = $this->getDateFormatted($key, $translator);
                $collectDays[$key] = $value;
                ++$countDay;
            }

            // Next Day
            $date = date('Y-m-d', strtotime($date.' +1 days'));
            $collectDay = (int) date('N', strtotime($date));
        }

        return $collectDays;
    }

    /**
     * @param string              $date
     * @param TranslatorInterface $translator
     *
     * @return string
     */
    private function getDateFormatted(string $date, TranslatorInterface $translator)
    {
        $stringDay = Schedule::getDayFormatted($date, $translator);
        $day = date('d', strtotime($date));
        $stringMonth = Schedule::getMonthFormatted($date, $translator);
        $year = date('Y', strtotime($date));

        return $stringDay.' '.$day.' '.$stringMonth.' '.$year;
    }

}
