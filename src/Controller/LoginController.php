<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;

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
        $session->clear();
        return $this->redirectToRoute('login');
    }//end deconnect

    /**
     * @Route("/signup", name="signup")
     */
    public function signupform(Request $request): Response
    {
        if ($request->getMethod() == 'POST') 
        {
            $s_email = $request->request->get('mail');
            $s_mdp = $request->request->get('mdp');
            $s_mdp2 = $request->request->get('mdp2');
            $s_nom = $request->request->get('nom');
            $s_prenom = $request->request->get('prenom');
            //test si js desactivé
            if($s_email!='' && $s_mdp2==$s_mdp) 
            {
                //if user existant
                $o_usersExist = $this->getDoctrine()->getRepository(Users::class)->findOneBy(array('email' => $s_email));
                if($o_usersExist) {
                    return $this->redirectToRoute('signup');    
                } else {
                    $o_user=new Users();
                    $o_user->setName($s_nom);$o_user->setFirstname($s_prenom);$o_user->setPassword(md5($s_mdp));$o_user->setEmail($s_email);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($o_user);
                    $entityManager->flush();
                    return $this->redirectToRoute('login');
                }//fin else    
            } else {
                return $this->redirectToRoute('signup');
                /*return $this->render('login/signup.html.twig', [
                    'nav' => 'error'
                ]);*/
            }//fin else    
        } else {
            return $this->render('login/signup.html.twig', [
                'nav' => 'users'
            ]);   
        }
    }//end signup

}//end loginController
