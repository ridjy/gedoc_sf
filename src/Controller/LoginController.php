<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexion()
    {
        // les parametres envoyés par le datatable
        if ($Request->getMethod() == 'POST') {
            $login = $Request->request->get('login');
            $mdp = $Request->request->get('mdp');
        } else // si la requete POST n'est pas lancé, on n'a pas besoin de ce script
            die;

        $entityManager = $this->getDoctrine()->getManager();
        
        $response = $this->forward('App\Controller\LoginController::index', [
            'login'  => $name,
            'mdp' => 'green',
        ]);
        
        return $response;
        
    }//end connexion

}//end loginController
