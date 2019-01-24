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

use App\Entity\EnterpriseDetails;
use App\Entity\Schedule;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnterpriseController extends AbstractController
{
    /**
     * @Route({
     *     "fr": "/a-propos",
     *     "en": "/about-us"
     * }, name="enterprise_show")
     * @Cache(smaxage="10")
     */
    public function show(): Response
    {
        $repository = $this->getDoctrine()->getRepository(EnterpriseDetails::class);
        $enterpriseDetails = $repository->find(1);

        return $this->render('enterprise/show.html.twig',
            [
                'enterpriseDetails' => $enterpriseDetails,
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
