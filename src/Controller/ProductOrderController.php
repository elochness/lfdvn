<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Entity\Schedule;
use App\Form\ProductOrderType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param CategoryRepository  $categoryRepository
     *
     * @return Response
     */
    public function step1(SessionInterface $session, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findActiveCategory();

        $repository = $this->getDoctrine()->getRepository(Schedule::class);
        /* @var Schedule $schedule */
        $schedule = $repository->find(1);

        $filters = $session->get('productOrder', []);

        return $this->render('product_order/step1.html.twig', [
            'categories' => $categories,
            'filters' => $filters,
            'datesForDelivery' => $this->getDatesForDelivery($schedule),
            'currentStep' => 1,
        ]);
    }

    /**
     * @Route({
     *     "fr": "/etape2",
     *     "en": "/step2"
     * }, methods={"GET"}, name="product_order_step2")
     *
     * @param CategoryRepository  $categoryRepository
     *
     * @return Response
     */
    public function step2(SessionInterface $session, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findActiveCategory();

        $repository = $this->getDoctrine()->getRepository(Schedule::class);
        /* @var Schedule $schedule */
        $schedule = $repository->find(1);

        $filters = $session->get('productOrder', []);

        return $this->render('product_order/step1.html.twig', [
            'categories' => $categories,
            'filters' => $filters,
            'datesForDelivery' => $this->getDatesForDelivery($schedule),
            'currentStep' => 1,
        ]);
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
    private function getDatesForDelivery(Schedule $schedule)
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
        while ($countDay <= self::NB_OPENED_DAYS) {
            if (in_array($collectDay, $openDays, true)) {
//     			$collectDays[] = date('d/m/Y', strtotime($date)) ;
                $key = date('Y-m-d', strtotime($date));
                $value = $key;
                //$value = $this->getDateFormatted($key);
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
 //   private function getDateFormatted(string $date, TranslatorInterface $translator)
 //   {
 //       /* @var TranslatorInterface $translator */
 //       $stringDay = Schedule::getDayFormatted($date, $translator);
 //       $day = date('d', strtotime($date));
 //       $stringMonth = Schedule::getMonthFormatted($date, $translator);
 //       $year = date('Y', strtotime($date));
 //
 //       return $stringDay.' '.$day.' '.$stringMonth.' '.$year;
 //   }
}
