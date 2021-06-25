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
use App\Entity\Categories;
//service
use App\Service\DocService;

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
    }//fin index

    /**
     * @Route("/docs/liste", name="document_liste")
     */
    public function documents(SessionInterface $session, Request $Request, DataTableFactory $dataTableFactory, DocService $service): Response
    {
        //definition des colonnes du datatable
        $table = $dataTableFactory->create()
            ->add('fichier', TextColumn::class, ['field' => 'doc.docName','className' => 'text-left','searchable' => true,'globalSearchable' => true, 'label' => 'Nom du fichier'])
            ->add('categorie', TextColumn::class, ['field' => 'doc.docId','className' => 'text-left','searchable' => true, 'label' => 'Catégories' , 'render' => function($value, $context) use ($service) {
                return $service->renderDocCategories($value);
            }])
            ->add('motcle', TextColumn::class, ['field' => 'doc.docId','orderable' => false ,'globalSearchable' => true,'searchable' => true,'label' => 'Mots cles', 'className' => 'text-left', 'render' => function($value, $context) use ($service) {
                return $service->renderDocMotcle($value);
            }])
            ->add('dateedition', TextColumn::class, ['orderable' => false, 'field' => 'documents.doc_date_modif','searchable' => true,'className' => 'text-center', 'label' => 'Date d\'édition'])
            ->add('action', TextColumn::class, [
                'field' => 'doc.docId', 'label' => 'Action', 'orderable' => false,
                'className' => 'text-center', 'render' => function ($value, $context) use ($session) {
                    $s_modif = '<span style="font-size: 20px;" class="glyphicon glyphicon-pencil" onClick="editDoc('.$value.');"></span>  ';
                    $s_effacer = '<span style="font-size: 20px;" class="glyphicon glyphicon-trash" onClick="deleteDoc('.$value.');"></span>  ';
                    $responseTemp = "<table><tr style='background-color:transparent'><td style='width :50%; padding: 5px' >".$s_modif .
                     "</td><td style='width :50%; padding: 5px'>" . $s_effacer . "</td></tr>";
                    return $responseTemp;
                }
            ])

            ->createAdapter(OrmAdapter::class, [
                'entity' => Documents::class,
                'query' => function (\Doctrine\ORM\QueryBuilder $builder) use ($session) {
                    $builder
                        ->select('docs')
                        //selection de l'entité jointe
                        //->addSelect('centre')
                        ->from(Documents::class, 'docs')
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

        return $this->render('document/docs.html.twig', [
            'nav' => 'liste_doc',
            'datatable' => $table
        ]);
    }//fin index

    /**
     * @Route("/docs/ajout", name="ajout_doc")
     */
    public function ajoutDocs(SessionInterface $session, Request $Request)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            $o_motcle = $this->getDoctrine()->getRepository(Motcles::class)->findAll();
            $o_categorie = $this->getDoctrine()->getRepository(Categories::class)->findAll();
            return $this->render('document/ajout.html.twig', [
                'motcle' => $o_motcle,
                'categorie' => $o_categorie
            ]);
        }
    }//fin ajoutdoc

    /**
     * @Route("/docs/ajout/enreg", name="save_doc")
     */
    public function enregDocs(SessionInterface $session, Request $Request)
    {
        //on n'affiche rien si ce n'est pas un appel ajax
        if ($Request->isXmlHttpRequest()) 
        {
            
            return $this->render('document/ajout.html.twig', [
                'appel' => 'edd'
            ]);
        }
    }//fin ajoutdoc

}//fin doc controler
