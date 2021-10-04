<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use App\Repository\ScheduleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * @Route({
     *     "fr": "/a-propos",
     *     "en": "/about-us"
     * }, name="company_index")
     * @Cache(smaxage="10")
     * @param CompanyRepository $companyRepository
     * @return Response
     */
    public function index(CompanyRepository $companyRepository)
    {
        $company = $companyRepository->find(1);
        return $this->render('company/index.html.twig', [
            'company' => $company,
        ]);
    }

    public function schedule(ScheduleRepository $scheduleRepository): Response
    {
        $schedule = $scheduleRepository->find(1);

        return $this->render('company/_schedule.html.twig', [
            'schedule' => $schedule,
        ]);
    }
}
