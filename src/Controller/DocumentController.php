<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class DocumentController extends AbstractController
{
    /**
     * @Route("/docs", name="document")
     */
    public function index(): Response
    {
        $o_allUsers = $this->getDoctrine()->getRepository(Users::class)->findAll();    
        return $this->render('document/index.html.twig', [
            'alluser'  => $o_allUsers,
            'nav' => 'dashboard'
        ]);
    }
}
