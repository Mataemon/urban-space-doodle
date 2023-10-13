<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
   /**
    */
    #[Route('/', name: 'index')]
    public function app(): Response
    {
      return $this->render('index.html.twig');
    }
}