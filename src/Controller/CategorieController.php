<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
use App\Entity\Categories;
use App\Entity\DocCategorie;
use App\Entity\DocMotcle;
use App\Entity\Notifications;
//service
use App\Service\DocService;
//kernel
use Symfony\Component\HttpKernel\KernelInterface;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/liste", name="categorie_liste")
     */
    public function categorie(SessionInterface $session, Request $Request, DataTableFactory $dataTableFactory, DocService $service): Response
    {
        //definition des colonnes du datatable
        $table = $dataTableFactory->create()
            ->add('categorie', TextColumn::class, ['field' => 'cat.catLibelle','className' => 'text-left','searchable' => true,'globalSearchable' => true, 
            'label' => 'Catégories'])
            ->add('action', TextColumn::class, [
                'field' => 'cat.catId', 'label' => 'Action', 'orderable' => false,
                'className' => 'text-center', 'render' => function ($value, $context) use ($session) {
                    $s_modif = '<span style="font-size: 20px;" class="glyphicon glyphicon-pencil" onClick="editCat('.$value.');"></span>  ';
                    $s_effacer = '<span style="font-size: 20px;" class="glyphicon glyphicon-trash" onClick="deleteCat('.$value.',\''.$context->getCatLibelle().'\');"></span>  ';
                    $responseTemp = "<table><tr style='background-color:transparent'><td style='width :50%; padding: 5px' >".$s_modif .
                     "</td><td style='width :50%; padding: 5px'>" . $s_effacer . "</td></tr>";
                    return $responseTemp;
                }
            ])

            ->createAdapter(OrmAdapter::class, [
                'entity' => Categories::class,
                'query' => function (\Doctrine\ORM\QueryBuilder $builder) use ($session) {
                    $builder
                        ->select('cat')
                        //selection de l'entité jointe
                        //->addSelect('centre')
                        ->from(Categories::class, 'cat')
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

        return $this->render('categorie/cats.html.twig', [
            'nav' => 'liste_cat',
            'datatable' => $table
        ]);
    }//fin index

    /**
     * @Route("/categorie/ajout", name="ajout_categorie")
     */
    public function ajoutCats(SessionInterface $session, Request $Request)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            return $this->render('categorie/ajout.html.twig', [
                'categories' => 'add'
            ]);
        }
    }//fin ajoutdoc

    /**
     * @Route("/cats/ajout/enreg", name="save_cat")
     */
    public function enregCats(SessionInterface $session, Request $Request, KernelInterface $kernel)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $s_categorie = $Request->request->get('cat');

            //test si categorie existe deja
            $o_catExist = $this->getDoctrine()->getRepository(Categories::class)->findOneBy(array('catLibelle' => $s_categorie));
            $entityManager = $this->getDoctrine()->getManager();
            if ($o_catExist) {
                $result = array('msg' => 'Catégorie déjà existante', 'type'=>'red');
            } else {
                //creation des objets à mettre en base
                $o_categorie = new Categories();
                $o_categorie->setCatLibelle($s_categorie);
                $entityManager->persist($o_categorie);
                $entityManager->flush();
                $result = array('msg' => 'Catégorie enregistrée', 'type'=>'green');
            }
            $response = json_encode($result);
            $returnResponse = new JsonResponse();
            $returnResponse->setJson($response);

            return $returnResponse;
        
        }//fin xmlhttprequest
    }//fin enregCats

    /**
     * @Route("/cats/edit", name="edit_cat")
     */
    public function modifierCats(SessionInterface $session, Request $Request)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $n_idcat = $Request->request->get('id');
            $o_categorie = $this->getDoctrine()->getRepository(Categories::class)->find($n_idcat);
        
            return $this->render('categorie/edit.html.twig', [
                'cat' => $o_categorie
            ]);
        }//fin if
    }//fin modifierDocs

    /**
     * @Route("/categorie/edit/enreg", name="save_edit_cat")
     */
    public function editenregCats(SessionInterface $session, Request $Request, KernelInterface $kernel)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $n_idCat = $Request->request->get('id');
            $s_categorie = $Request->request->get('new');
            $entityManager = $this->getDoctrine()->getManager();
            $o_cat = $this->getDoctrine()->getRepository(Categories::class)->find($n_idCat);
            //document
            $o_cat->setCatLibelle($s_categorie);
            $entityManager->persist($o_cat);
            $entityManager->flush();
            
            //formattage msg retour
            $result = array('msg' => 'Catégorie mise à jour', 'type'=>'green');
		    
            $response = json_encode($result);
            $returnResponse = new JsonResponse();
            $returnResponse->setJson($response);

            return $returnResponse;
        
        }//fin xmlhttprequest
    }//fin editenregcat


    /**
     * @Route("/cats/delete/enreg", name="save_delete_cat")
     */
    public function deleteenregCats(SessionInterface $session, Request $Request, KernelInterface $kernel)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $n_idCat = $Request->request->get('ident');
            $entityManager = $this->getDoctrine()->getManager();
            $o_cat = $this->getDoctrine()->getRepository(Categories::class)->find($n_idCat);
            
            $s_titre = $o_cat->getCatLibelle();
            $entityManager->remove($o_cat);
            $entityManager->flush();
            
            //ajout notification
            $o_notif = new Notifications();
            $o_notif->setDateNotif(date('d/m/Y H:i:s'));
            $o_notif->setContenu('Suppression de la catégorie : '.$s_titre);
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

}//fin categorie controller
