<?php

declare(strict_types=1);

namespace App\Controller\Report;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as Route;

/**
 * @Route("/reports")
 */
final class ReportController extends AbstractController
{
    /**
     * @Route(methods={"GET"})
     */
    public function report(): Response
    {
        return include 'report/index.html';
    }
}