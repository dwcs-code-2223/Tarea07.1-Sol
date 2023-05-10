<?php

namespace App\Controller;

use App\Entity\Nota;
use App\Service\NotaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotaController extends AbstractController
{
  

//Apartado A) 
    // #[Route('/nota/new', name: 'app_nota_new')]
    // public function create(EntityManagerInterface $entityManager): Response
    // {

    //     $nota = new Nota();
    //     $nota->setTitulo('Mi primera nota');
    //     $nota->setDescripcion('Esta es la descripción');

    //     $entityManager->persist($nota);
    //     $entityManager->flush();

     
    //     return $this->render('nota/crear.html.twig', [
    //         'controller_name' => 'NotaController',
    //         'nota' => $nota
    //     ]);
    // }


//Apartado B)
    #[Route('/nota/new', name: 'app_nota_new')]
    public function create(NotaService $notaService): Response
    {

        $nota = new Nota();
        $nota->setTitulo('Mi primera nota');
        $nota->setDescripcion('Esta es la descripción');

      
        $nota = $notaService->create($nota);
     
        return $this->render('nota/crear.html.twig', [
            'controller_name' => 'NotaController',
            'nota' => $nota
        ]);
    }

    //Apartado C)
    #[Route('/nota', name: 'app_nota_list')]
    public function index(NotaService $notaService): Response
    {
        $notas = $notaService->list();
        return $this->render('nota/index.html.twig', [
            'controller_name' => 'NotaController',
            'notas' => $notas
        ]);
    }

}
