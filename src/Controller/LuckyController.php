<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    #[Route(
        '/lucky/number/{max<\d+>}',
        name: 'app_lucky'
    )]
    public function index(int $max): Response
    {

        if (($max % 2) === 1) {
            $url = $this->generateUrl('app_table', ['filas'=> $max, 'cols'=>$max]);
            return $this->redirect($url);
            // return $this->redirectToRoute('app_table',  ['filas'=> $max, 'cols'=>$max] );
        }
        $number = random_int(0, $max);


        return $this->render('lucky/index.html.twig', [
            'controller_name' => 'LuckyController',
            'maximo' => $max,
            'numero' => $number
        ]);
    }
    #[Route('/lucky/producto/{a<\d+>}/{b<\d+>}', name: 'app_lucky_producto')]
    public function producto(int $a, int $b): Response
    {
        $producto = $a * $b;

        return $this->render('lucky/index.html.twig', [
            'controller_name' => 'LuckyController',
            'maximo' => '',
            'numero' => '',
            'a' => $a,
            'b' => $b,
            'resultado' => $producto

        ]);
    }
}
