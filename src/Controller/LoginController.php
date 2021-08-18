<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Users;

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
    public function connexion(Request $Request, SessionInterface $session)
    {
        // les parametres envoyés par le datatable
        if ($Request->getMethod() == 'POST') {
            $s_email = $Request->request->get('login');
            $s_mdp = $Request->request->get('mdp');
        } else // si la requete POST n'est pas lancé, on n'a pas besoin de ce script
            die;

        //$entityManager = $this->getDoctrine()->getManager();
        $o_users = $this->getDoctrine()->getRepository(Users::class)->findOneBy(array('email' => $s_email,'password' => md5($s_mdp)));
        if(!$o_users)
        {
            $response = $this->forward('App\Controller\LoginController::index', [
                'login'  => $s_email,
                'mdp' => $s_mdp,
            ]);
        } else {
            //sessions
            $session->set('user_connecte', $o_users);
            $response = $this->forward('App\Controller\DocumentController::index', [
                'login'  => $s_email
            ]);
        }    
        return $response;
        
    }//end connexion

    /**
     * @Route("/deconnect", name="users_deconnect")
     */
    public function deconnexion(Request $request,SessionInterface $session): Response
    {
        $session->set('user_connecte', NULL);
        unset($session);
        return $this->redirectToRoute('login');
    }//end deconnect

}//end loginController
