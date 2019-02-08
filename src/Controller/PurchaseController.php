<?php

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\Schedule;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Controller used to manage user contents in the public part of the site.
 *
 * @Route({
 *     "fr": "/commande",
 *     "en": "/purchase"
 * })
 *
 * @author Pierre François
 */
class PurchaseController extends AbstractController
{
    /**
     * @var int
     */
    const NB_OPENED_DAYS = 20;

    /**
     * @Route({
     *     "fr": "/etape1",
     *     "en": "/step1"
     * }, methods={"GET"}, name="purchase_step1")
     *
     * @param SessionInterface    $session
     * @param CategoryRepository  $categoryRepository
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function step1(SessionInterface $session, CategoryRepository $categoryRepository, TranslatorInterface $translator): Response
    {
        $categories = $categoryRepository->findActiveCategory();

        $repository = $this->getDoctrine()->getRepository(Schedule::class);
        /* @var Schedule $schedule */
        $schedule = $repository->find(1);

        $filters = $session->get('purchase', []);

        return $this->render('purchase/step1.html.twig', [
            'categories' => $categories,
            'filters' => $filters,
            'datesForDelivrery' => $this->getDatesForDelivery($schedule, $translator),
            'currentStep' => 1,
        ]);
    }

    /**
     * @Route({
     *     "fr": "/etape2",
     *     "en": "/step2"
     * }, methods={"GET", "POST"}, name="purchase_step2")
     *
     * @param Request          $request
     * @param SessionInterface $session
     * @param User|null        $user
     *
     * @return Response
     */
    public function step2(Request $request, SessionInterface $session, AuthenticationUtils $helper, UserInterface $user = null): Response
    {
        $session->set('purchase', $this->cleanPurchaseParams($request->request));

        // Check if user is connected
        if (null !== $user) {
            // redirect in step 3 is connected
//     		return $this->render('purchase/step3.html.twig');
            return  $this->forward('App\Controller\PurchaseController::step3');
        }

        return $this->render('purchase/step2.html.twig', [
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
     * }, methods={"GET"}, name="purchase_step3")
     *
     * @param SessionInterface    $session
     * @param TranslatorInterface $translator
     * @param User|null           $user
     *
     * @return Response
     */
    public function step3(SessionInterface $session, TranslatorInterface $translator, UserInterface $user = null): Response
    {
        // Check if user is connected
        if (null === $user) {
            // redirect in step 2 isn't connected
            return  $this->forward('App\Controller\PurchaseController::step2');
        } elseif (empty($session->get('purchase'))) {
            // redirect in step 1 isn't purchase object
            return  $this->forward('App\Controller\PurchaseController::step1');
        }
        // On créé un objet Purchase
        $purchase = $this->constructPurchase($session->get('purchase'), $translator);
        $total = 0;

        foreach ($purchase->getItems() as $item) {
            $total += $item->getPrice();
        }

        return $this->render('purchase/step3.html.twig', [
                'purchase' => $purchase,
                'total' => $total,
                'currentStep' => 3,
            ]);
    }

    /**
     * @Route({
     *     "fr": "/etape4",
     *     "en": "/step4"
     * }, methods={"GET", "POST"}, name="purchase_step4")
     *
     * @param Request             $request
     * @param SessionInterface    $session
     * @param TranslatorInterface $translator
     * @param \Swift_Mailer       $mailer
     * @param UserInterface|null  $user
     *
     * @return Response
     */
    public function step4(Request $request, SessionInterface $session, TranslatorInterface $translator, \Swift_Mailer $mailer, UserInterface $user = null)
    {
        // Check if user is connected
        if (null === $user) {
            // redirect in step 2 isn't connected
            return  $this->forward('App\Controller\PurchaseController::step2');
        } elseif (null === $session->get('purchase')) {
            // redirect in step 1 isn't purchase object
            return  $this->forward('App\Controller\PurchaseController::step1');
        }

        if ($request->isMethod('post')) {
            $total = 0;
            $purchase = $this->constructPurchase($session->get('purchase'), $translator);
            $purchase->setBuyer($user);
            $purchase->setComment($request->request->get('comment'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($purchase);
            $em->flush($purchase);

            foreach ($purchase->getItems() as $item) {
                $total += $item->getPrice();
            }

            // delete data session
            $session->clear();

            $this->sendCustomerMail($purchase, $total, $mailer);
            //$this->sendEnterpriseMail($purchase, $total, $mailer);

            return $this->render('purchase/step4.html.twig', [
                    'currentStep' => 4,
                ]);
            // 		    	return $this->render('email/enterprise_purchase.html.twig', array(
// 	    			'purchase' => $purchase,
// 	    			'total' => $total
// 	    		));
        }

        return  $this->forward('App\Controller\PurchaseController::step3');
    }

    private function cleanPurchaseParams($params)
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
     * @return Purchase
     */
    private function constructPurchase($params, TranslatorInterface $translator): Purchase
    {
        // Initialization
        $purchase = new Purchase();
        $listIdProducts = [];
        $em = $this->getDoctrine()->getManager();

        // Recuperate all products
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

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
                $product = $em->find('App\Entity\Product', $currentlyKey);
                $purchaseItem = new PurchaseItem();
                $purchaseItem->setQuantity($value);
                $purchaseItem->setProduct($product);
                $purchaseItem->setPrice($value * $product->getPrice());
                $purchaseItem->setTaxRate($product->getTaxRate()->getRate());
                $purchaseItem->setPurchase($purchase);
                // Add item to list
                $purchase->addItem($purchaseItem);
            } elseif ('delivery_date' === $key) {
                // 	    		$purchase->setDeliveryDate($value);
                // create Date object according to the value
                $purchase->setDeliveryDateFormatted($this->getDateFormatted($value, $translator));
                $purchase->setDeliveryDate(date_create($value));
            }
        }

        return $purchase;
    }

    /**
     * @param Schedule            $schedule
     * @param TranslatorInterface $translator
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
        $collectDay = date('N', strtotime($date));

        // We take 20 opened days
        while ($countDay <= self::NB_OPENED_DAYS) {
            if (\in_array($collectDay, $openDays, true)) {
//     			$collectDays[] = date('d/m/Y', strtotime($date)) ;
                $key = date('Y-m-d', strtotime($date));
                $value = $this->getDateFormatted($key, $translator);
                $collectDays[$key] = $value;
                ++$countDay;
            }

            // Next Day
            $date = date('Y-m-d', strtotime($date.' +1 days'));
            $collectDay = date('N', strtotime($date));
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
        /* @var TranslatorInterface $translator */
        $stringDay = Schedule::getDayFormatted($date, $translator);
        $day = date('d', strtotime($date));
        $stringMonth = Schedule::getMonthFormatted($date, $translator);
        $year = date('Y', strtotime($date));

        return $stringDay.' '.$day.' '.$stringMonth.' '.$year;
    }

    /**
     * @param Purchase $purchase
     * @param unknown  $total
     */
    private function sendCustomerMail($purchase, $total, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Récapitulatif de la commande à la Fromagerie du Vignoble Nantais'))
            ->setFrom('test@lafromagerieduvignoblenantais.com')
            ->setTo($purchase->getBuyer()->getUsername())
            ->setBody(
                $this->renderView('email/_customer_purchase.html.twig', [
                    'purchase' => $purchase,
                    'total' => $total,
                ]),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $mailer->send($message);
    }

    /**
     * @param Purchase $purchase
     * @param unknown  $total
     */
    private function sendEnterpriseMail($purchase, $total, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Nouvelle commande n° ' + $purchase->getId() + 'à la Fromagerie du Vignoble Nantais'))
            ->setFrom('test@lafromagerieduvignoblenantais.com')
            ->setTo($purchase->getBuyer()->getUsername())
            ->setBody(
                $this->renderView('email/_enterprise_purchase.html.twig', [
                    'purchase' => $purchase,
                    'total' => $total,
                ]),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                    $this->renderView(
                            'Emails/registration.txt.twig',
                            array('name' => $name)
                    ),
                    'text/plain'
            )
            */
        ;

        $mailer->send($message);
    }
}
