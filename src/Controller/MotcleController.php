<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
//datatables
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORM\SearchCriteriaProvider;
use App\Entity\Users;
use App\Entity\Documents;
use App\Entity\Motcles;
use App\Entity\DocMotcle;
use App\Entity\Notifications;
//service
use App\Service\DocService;
//kernel
use Symfony\Component\HttpKernel\KernelInterface;

class MotcleController extends AbstractController
{
    /**
     * @Route("/motcle/liste", name="motcle_liste")
     */
    public function motcle(SessionInterface $session, Request $Request, DataTableFactory $dataTableFactory, DocService $service): Response
    {
        //definition des colonnes du datatable
        $table = $dataTableFactory->create()
            ->add('motcle', TextColumn::class, ['field' => 'motcle.mcLib','className' => 'text-left','searchable' => true,'globalSearchable' => true, 
            'label' => 'Mot clé'])
            ->add('action', TextColumn::class, [
                'field' => 'motcle.mcId', 'label' => 'Action', 'orderable' => false,
                'className' => 'text-center', 'render' => function ($value, $context) use ($session) {
                    $s_modif = '<span style="font-size: 20px;" class="glyphicon glyphicon-pencil" onClick="editMc('.$value.');"></span>  ';
                    $s_effacer = '<span style="font-size: 20px;" class="glyphicon glyphicon-trash" onClick="deleteMc('.$value.',\''.$context->getMcLib().'\');"></span>  ';
                    $responseTemp = "<table><tr style='background-color:transparent'><td style='width :50%; padding: 5px' >".$s_modif .
                     "</td><td style='width :50%; padding: 5px'>" . $s_effacer . "</td></tr>";
                    return $responseTemp;
                }
            ])

            ->createAdapter(OrmAdapter::class, [
                'entity' => Motcles::class,
                'query' => function (\Doctrine\ORM\QueryBuilder $builder) use ($session) {
                    $builder
                        ->select('motcle')
                        //selection de l'entité jointe
                        //->addSelect('centre')
                        ->from(Motcles::class, 'motcle')
                        //1er arg : attribut de jointure, 2e arg : alias de l'entité jointe
                        //->leftJoin('dic.idConcerne', 'patient')
                        //pour filtre ville centre    
                    ;
                },
                'criteria' => [
                    function (\Doctrine\ORM\QueryBuilder $builder) use ($session) {
                       /*if( $n_filtreCtr == 0 )
                        {
                            $qb1 = $builder->getEntityManager()->createQueryBuilder();
                            $qb1
                                ->select('zonecollab.idZone')
                                ->from(ZoneCollaborateur::class, 'zonecollab')
                                ->where("zonecollab.role = 'arc' AND zonecollab.idCollaborateur = ".$session->get('login'));
                            // fin sous-requete 
                            $builder->andWhere('( ctr.idZone IN (' . $qb1->getDQL() . ') OR ctr.idCollaborateur = '.$session->get('login').')');
                            //"ARC nommé responsable du centre"
                        }*/
                    },
                    new SearchCriteriaProvider(),
                ],//fin criteria
            ])
            ->handleRequest($Request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('motcle/motcles.html.twig', [
            'nav' => 'motcle',
            'datatable' => $table
        ]);
    }//fin index

    /**
     * @Route("/motcle/ajout", name="ajout_motcle")
     */
    public function ajoutmotcles(SessionInterface $session, Request $Request)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            return $this->render('motcle/ajout.html.twig', [
                'motcles' => 'add'
            ]);
        }
    }//fin ajoutdoc

    /**
     * @Route("/motcles/ajout/enreg", name="save_motcle")
     */
    public function enregmotcles(SessionInterface $session, Request $Request, KernelInterface $kernel)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $s_motcle = $Request->request->get('Mc');

            //test si motcle existe deja
            $o_motcleExist = $this->getDoctrine()->getRepository(Motcles::class)->findOneBy(array('mcLib' => $s_motcle));
            $entityManager = $this->getDoctrine()->getManager();
            if ($o_motcleExist) {
                $result = array('msg' => 'Mot clé déjà existant', 'type'=>'red');
            } else {
                //creation des objets à mettre en base
                $o_motcle = new motcles();
                $o_motcle->setMcLib($s_motcle);
                $entityManager->persist($o_motcle);
                $entityManager->flush();
                $result = array('msg' => 'Mot clé enregistré', 'type'=>'green');
            }
            $response = json_encode($result);
            $returnResponse = new JsonResponse();
            $returnResponse->setJson($response);

            return $returnResponse;
        
        }//fin xmlhttprequest
    }//fin enregmotcles

    /**
     * @Route("/motcles/edit", name="edit_motcle")
     */
    public function modifiermotcles(SessionInterface $session, Request $Request)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $n_idmotcle = $Request->request->get('id');
            $o_motcle = $this->getDoctrine()->getRepository(Motcles::class)->find($n_idmotcle);
        
            return $this->render('motcle/edit.html.twig', [
                'motcle' => $o_motcle
            ]);
        }//fin if
    }//fin modifierDocs

    /**
     * @Route("/motcle/edit/enreg", name="save_edit_motcle")
     */
    public function editenregmotcles(SessionInterface $session, Request $Request, KernelInterface $kernel)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $n_idmotcle = $Request->request->get('id');
            $s_motcle = $Request->request->get('new');
            $entityManager = $this->getDoctrine()->getManager();
            $o_motcle = $this->getDoctrine()->getRepository(Motcles::class)->find($n_idmotcle);
            //document
            $o_motcle->setMcLib($s_motcle);
            $entityManager->persist($o_motcle);
            $entityManager->flush();
            
            //formattage msg retour
            $result = array('msg' => 'Mot clé mise à jour', 'type'=>'green');
		    
            $response = json_encode($result);
            $returnResponse = new JsonResponse();
            $returnResponse->setJson($response);

            return $returnResponse;
        
        }//fin xmlhttprequest
    }//fin editenregmotcle


    /**
     * @Route("/motcles/delete/enreg", name="save_delete_motcle")
     */
    public function deleteenregmotcles(SessionInterface $session, Request $Request, KernelInterface $kernel)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $n_idmotcle = $Request->request->get('ident');
            $entityManager = $this->getDoctrine()->getManager();
            $o_motcle = $this->getDoctrine()->getRepository(Motcles::class)->find($n_idmotcle);
            
            $s_titre = $o_motcle->getMcLib();
            $entityManager->remove($o_motcle);
            $entityManager->flush();
            
            //ajout notifimotcleion
            $o_notif = new Notifications();
            $o_notif->setDateNotif(date('d/m/Y H:i:s'));
            $o_notif->setContenu('Suppression du mot cle : '.$s_titre);
            $o_notif->setLu(0);
            $entityManager->persist($o_notif);
            $entityManager->flush();
            
            //formattage msg retour
            $result = array('msg' => 'suppression effectuée', 'type'=>'red');
		    
            $response = json_encode($result);
            $returnResponse = new JsonResponse();
            $returnResponse->setJson($response);

            return $returnResponse;
        
        }//fin xmlhttprequest
    }//fin editenregdoc

}//fin motcle controller
