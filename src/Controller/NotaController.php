<?php

namespace App\Controller;

use App\Entity\Nota;
use App\Service\NotaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotaController extends AbstractController
{




    #[Route('/nota', name: 'app_nota_list')]
    public function index(NotaService $notaService): Response
    {
        $notas = $notaService->list();
        return $this->render('nota/index.html.twig', [
            'controller_name' => 'NotaController',
            'notas' => $notas
        ]);
    }




    #[Route('/nota/new', name: 'app_nota_new')]
    public function crear(Request $request, NotaService $notaService): Response
    {
        $valid = false;

        $nota = new Nota();

        if ($request->getMethod() === 'POST') {
            $valid = true;
            // $request->request para recoger variables enviadas por método post ($_POST)
            // request->query para recoger variables enviadas por método get  ($_GET)
            //null es el valor por defecto (no haría falta añadirlo)
            $description = $request->request->get('descripcion', null);
            $titulo = $request->request->get('titulo', null);

            //A variable is considered empty if it does not exist or if its value equals false.
            //Empty string is considered false as converting to boolean: https://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting
            if ((isset($description) && (empty($description)))) {
                $this->addFlash('warning', 'El campo descripción es obligatorio');
                $valid = false;
            } else {
                $nota->setDescripcion($description);
            }
            if (isset($titulo) && (empty($titulo))) {

                $this->addFlash('warning', 'El campo título es obligatorio');
                $valid = false;
            } else {
                $nota->setTitulo($titulo);
            }
        }
        if ($valid) {

            $nota = $notaService->create($nota);

            $this->addFlash('success', 'Nota guardada correctamente');

            return $this->redirectToRoute('app_nota_list');
        } else {
            return $this->render('nota/crear.html.twig', [
                'controller_name' => 'NotaController',
                'nota' => $nota
            ]);
        }
    }



    #[Route('/nota/edit/{id<([1-9]+\d*)>}', name: 'app_nota_edit')]
    public function editar(Request $request, NotaService $notaService, int $id): Response
    {
        $valid = false;

        $nota = $notaService->find($id);

        if ($nota == null) {
            throw   $this->createNotFoundException();
        }

        if ($request->getMethod() === 'POST') {
            $valid = true;
            // $request->request para recoger variables enviadas por método post ($_POST)
            // request->query para recoger variables enviadas por método get  ($_GET)
            //null es el valor por defecto (no haría falta añadirlo)
            $description = $request->request->get('descripcion', null);
            $titulo = $request->request->get('titulo', null);

            //A variable is considered empty if it does not exist or if its value equals false.
            //Empty string is considered false as converting to boolean: https://www.php.net/manual/en/language.types.boolean.php#language.types.boolean.casting
            if ((isset($description) && (empty($description)))) {
                $this->addFlash('warning', 'El campo descripción es obligatorio');
                $valid = false;
            }
          
            if (isset($titulo) && (empty($titulo))) {

                $this->addFlash('warning', 'El campo título es obligatorio');
                $valid = false;
            } 
          

            if ($valid) {

               $notaService->editar($nota, $description, $titulo);

                $this->addFlash('success', 'Nota guardada correctamente');

                return $this->redirectToRoute('app_nota_list');
            } else {

                return $this->render('nota/editar.html.twig', [
                   
                    'nota' => $nota
                ]);
            }
        } else {


            return $this->render('nota/editar.html.twig', [
            
                'nota' => $nota

            ]);
        }
    }



    #[Route('/nota/delete/{id<([1-9]+\d*)>}', name: 'app_nota_delete')]
    public function delete(NotaService $notaService, int $id): Response
    {
        try {
            $nota = $notaService->find($id);
            if ($nota == null) {
                throw   $this->createNotFoundException();
            }

            $notaService->delete($nota);

            $this->addFlash('success', "Se ha eliminado la nota con éxito");

            $notas = $notaService->list();

            return $this->redirectToRoute("app_nota_list");
        } catch (\Exception $exception) {

            $this->addFlash('danger', "Se ha producido un problema y no se ha podido eliminar la nota" . $exception->getMessage());
            return $this->redirectToRoute("app_nota_list");
        }

    }

    
}
