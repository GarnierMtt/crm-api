<?php

namespace App\Controller;

use App\Entity\Criticites;
use App\Form\CriticitesForm;
use App\Utils\ApiQueryBuilder;
use App\Repository\CriticitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/criticites')]
final class CriticitesController extends AbstractController
{
    //// api documentation
    #[Route('_docs',name: 'api_criticites_documentation', methods: ['GET'])]
    public function documentation(EntityManagerInterface $em, Request $request): Response
    {
        $mappings = array();

        $atributes = $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Criticites')->getFieldNames();
        foreach($atributes as $atribute){
            $mappings[] = [$atribute, $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Criticites')->getTypeOfField($atribute)];
        }

        $atributes = $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Criticites')->getAssociationNames();
        foreach($atributes as $atribute){
            $mappings[] = [$atribute, $em->getMetadataFactory()->getMetadataFor('App\\Entity\\Criticites')->getAssociationTargetClass($atribute)];
        }


        $criticites = new Criticites();
        $form = $this->createForm(CriticitesForm::class, $criticites);
        $form->handleRequest($request);



        return $this->render('api/obj_index.html.twig', [
            'class' => "criticites",
            'atributes' => $mappings,
            'form' => $form,
        ]);
    }


    //// routes pour l'api
            // -index
    #[Route('',name: 'api_criticites_index', methods: ['GET'])]
    public function apiIndex(CriticitesRepository $criticitesRepository, Request $request, ApiQueryBuilder $apiQueryBuilder): Response
    {



        return $apiQueryBuilder->returnIndex($criticitesRepository, $request, "criticites");
    }


            // -show
    #[Route('/{id}',name: 'api_criticites_show', methods: ['GET'])]
    public function apiShow(Criticites $criticites, Request $request, ApiQueryBuilder $apiQueryBuilder): Response
    {


        return $apiQueryBuilder->returnShow($criticites, $request);
    }


            // -new
    #[Route('/new', name: 'api_criticites_new', methods: ['POST'])]
    public function apiNew(Request $request, ApiQueryBuilder $apiQueryBuilder): Response
    {
        $criticites = new Criticites();
        $form = $this->createForm(CriticitesForm::class, $criticites);
        $form->handleRequest($request);


        return $apiQueryBuilder->returnNew($criticites, $form);
    }


            // -edit
    #[Route('/{id}', name: 'api_criticites_edit', methods: ['POST'])]
    public function apiEdit(Request $request, Criticites $criticites, ApiQueryBuilder $apiQueryBuilder): Response
    {
        $form = $this->createForm(CriticitesForm::class, $criticites);
        $form->handleRequest($request);


        return $apiQueryBuilder->returnEdit($form);
    }


            // -delete
    #[Route('/{id}', name: 'api_criticites_delete', methods: ['DELETE'])]
    public function apiDelete(Criticites $criticites, ApiQueryBuilder $apiQueryBuilder): Response
    {
       

        return $apiQueryBuilder->returnDelete($criticites);
    }
}
