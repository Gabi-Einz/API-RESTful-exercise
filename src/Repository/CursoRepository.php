<?php

namespace App\Repository;

use App\Entity\Curso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Curso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Curso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Curso[]    findAll()
 * @method Curso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CursoRepository extends ServiceEntityRepository
{
    var EntityManagerInterface $entityManagerInterface; 

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($registry, Curso::class);
        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function createCurso($curso)
    {      
        $this->entityManagerInterface->persist($curso);
        $this->entityManagerInterface->flush($curso);

    }

    public function getCursos()
    {
        
        return $this->findAll();
    }

    public function getCursoById($id)
    {
        return $this->find($id);
    }

    public function deleteCurso($curso)
    {
        $this->entityManagerInterface->remove($curso);
        $this->entityManagerInterface->flush();
    }

    public function editCurso($cursoBd)
    {
        $this->entityManagerInterface->flush($cursoBd);
    }
}
