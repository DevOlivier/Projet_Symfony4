<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(ObjectManager $manager , StatsService $statsService)
    {
        $stats = $statsService->getStats();

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}
