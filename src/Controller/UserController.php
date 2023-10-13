<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Form\UserForm;
use App\Entity\User;
use App\Service\ApiClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class UserController extends AbstractController
{

    #[Route('/user/', name: 'user_index')]
    public function index(ApiClient $apiClient): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $apiClient->listUsers(),
        ]);
    }

    #[Route('/user/new', name: 'user_new')]
    public function new(Request $request, ApiClient $apiClient): Response
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //Update $user with values from form
            $user = $form->getData();
            //add default values for this project
            $user->setStatut('particulier');
            $user->setCountry('FR');
            $createdUser = $apiClient->createUser($user);
            
            if (is_string($createdUser))
            {
                //Return error
                return $this->render(
                    'user/new.html.twig',
                    array('form' => $form->addError(new FormError($createdUser)))
                );
            }
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render(
            'user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/user/{id}', name: 'user_show')]
    public function show(string $id, ApiClient $apiClient): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $apiClient->getUser($id),
        ]);
    }
}