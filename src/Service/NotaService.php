<?php
namespace App\Service;

use App\Entity\Nota;
use App\Repository\NotaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class NotaService{
	public function __construct(private EntityManagerInterface $em, private NotaRepository $notaRepository)
	{
        
	}


    public function create(Nota $nota): Nota{
        $this->em->persist($nota);
        $this->em->flush();
        return $nota;
    }



    
	public function list(): array{
      $notas = $this->notaRepository->findAll();
      return $notas;
    }

    public function find(int $id ): ?Nota{
        $nota = $this->notaRepository->find($id);
        return $nota;
    }

    public function editar(Nota $nota, $descripcion, $titulo){
     
        $nota->setDescripcion($descripcion);
        $nota->setTitulo($titulo);
        $this->em->flush();
      
    }

    public function delete(Nota $nota){

        $this->em->remove($nota);
        $this->em->flush();
    }
    
}