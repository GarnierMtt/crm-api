<?php

namespace App\Controller;

use App\Entity\Incidents;
use App\Form\IncidentsForm;
use App\Utils\ApiQueryBuilder;
use App\Repository\IncidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/incidents')]
final class IncidentsController extends AbstractController
{
    //// api documentation
    #[Route('_docs',name: 'api_incidents_documentation', methods: ['GET'])]
    public function documentation(EntityManagerInterface $em, Request $request): Response
    {
        $mappings = array();

        $atributes = $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Incidents')->getFieldNames();
        foreach($atributes as $atribute){
            $mappings[] = [$atribute, $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Incidents')->getTypeOfField($atribute)];
        }

        $atributes = $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Incidents')->getAssociationNames();
        foreach($atributes as $atribute){
            $mappings[] = [$atribute, $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Incidents')->getAssociationTargetClass($atribute)];
        }


        $incidents = new Incidents();
        $form = $this->createForm(IncidentsForm::class, $incidents);
        $form->handleRequest($request);



        return $this->render('api/obj_index.html.twig', [
            'class' => "incidents",
            'atributes' => $mappings,
            'form' => $form,
        ]);
    }


    //// routes pour l'api
            // -index
    #[Route('',name: 'api_incidents_index', methods: ['GET'])]
    public function apiIndex(IncidentsRepository $incidentsRepository, Request $request, ApiQueryBuilder $apiQueryBuilder): Response
    {



        return $apiQueryBuilder->returnIndex($incidentsRepository, $request, "incidents");
    }


            // -show
    #[Route('/{id}',name: 'api_incidents_show', methods: ['GET'])]
    public function apiShow(Incidents $incidents, Request $request, ApiQueryBuilder $apiQueryBuilder): Response
    {


        return $apiQueryBuilder->returnShow($incidents, $request);
    }


            // -new
    #[Route('/new', name: 'api_incidents_new', methods: ['POST'])]
    public function apiNew(Request $request, ApiQueryBuilder $apiQueryBuilder): Response
    {
        $incidents = new Incidents();
        $form = $this->createForm(IncidentsForm::class, $incidents);
        $form->handleRequest($request);


        return $apiQueryBuilder->returnNew($incidents, $form);
    }


            // -edit
    #[Route('/{id}', name: 'api_incidents_edit', methods: ['POST'])]
    public function apiEdit(Request $request, Incidents $incidents, ApiQueryBuilder $apiQueryBuilder): Response
    {
        $form = $this->createForm(IncidentsForm::class, $incidents);
        $form->handleRequest($request);


        return $apiQueryBuilder->returnEdit($form);
    }


            // -delete
    #[Route('/{id}', name: 'api_incidents_delete', methods: ['DELETE'])]
    public function apiDelete(Incidents $incidents, ApiQueryBuilder $apiQueryBuilder): Response
    {
       

        return $apiQueryBuilder->returnDelete($incidents);
    }
}
