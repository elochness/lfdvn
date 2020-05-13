<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Schedule;
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
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Company::class);
        $company = $repository->find(1);
        return $this->render('company/index.html.twig', [
            'company' => $company,
        ]);
    }

    public function schedule(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Schedule::class);
        $schedule = $repository->find(1);

        return $this->render('company/_schedule.html.twig', [
            'schedule' => $schedule,
        ]);
    }
}
