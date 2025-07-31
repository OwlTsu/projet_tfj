<?php

namespace App\Controller\Visitor\Location;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_visitor_location_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/visitor/location/index.html.twig');
    }
}
