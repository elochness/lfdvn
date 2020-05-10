<?php

namespace App\Controller;

use App\Entity\Schedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company_index")
     */
    public function index()
    {
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }

    public function schedule(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Schedule::class);
        $schedule = $repository->find(1);

        return $this->render('enterprise/_schedule.html.twig', [
            'schedule' => $schedule,
        ]);
    }
}
