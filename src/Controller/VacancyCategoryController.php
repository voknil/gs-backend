<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VacancyCategoryController extends AbstractController
{
    #[Route('/vacancy/category/', name: 'app_vacancy_category')]
    public function index(): Response
    {
        return new Response();    }
}
