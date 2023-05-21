<?php

namespace App\Service;

use App\Entity\Nota;
use App\Repository\NotaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class NotaService
{
    public function __construct(private EntityManagerInterface $em, private NotaRepository $notaRepository)
    {
    }


    public function create(Nota $nota): Nota
    {
        $this->notaRepository->save($nota, true);
        return $nota;
    }




    public function list(): array
    {
        $notas = $this->notaRepository->findAll();
        return $notas;
    }

    public function find(int $id): ?Nota
    {
        $nota = $this->notaRepository->find($id);
        return $nota;
    }

    public function editar(Nota $nota, string $description, string $titulo)
    {

        $nota->setTitulo($titulo);

        $nota->setDescripcion($description);

        $this->em->flush();
    }

    public function delete(Nota $nota)
    {

        $this->notaRepository->remove($nota, true);
    }
}
