<?php

namespace App\Repository;

use App\Entity\Alumno;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Error;

/**
 * @method Alumno|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alumno|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alumno[]    findAll()
 * @method Alumno[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlumnoRepository extends ServiceEntityRepository
{
    
    var EntityManagerInterface $entityManagerInterface; 


    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($registry, Alumno::class);
        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function createAlumno($alumno)
    {      
        try{
            $this->entityManagerInterface->persist($alumno);
            $this->entityManagerInterface->flush($alumno);
            }catch(\Throwable $th){
              throw new Error("Error al persistir en la base de datos" . $th->getMessage());
               }

    }

    public function getAlumnos()
    {    
        return $this->findAll();
    }
    
    /*
    public function getAlumnobyLegajo($legajo)
    {
        $field = 'legajo';
        $alumno = $this->findOneBySomeField($legajo,$field);
        return $alumno;
    }*/

    public function getAlumnoById($id)
    {
        return $this->find($id);
    }

    // /**
    //  * @return Alumno[] Returns an array of Alumno objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value, $field):Alumno
    {
        return $this->createQueryBuilder('a')
            ->andWhere("a.$field = :val")
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/

    public function deleteAlumno($alumno)
    {   try{
        $this->entityManagerInterface->remove($alumno);
        $this->entityManagerInterface->flush();
        }catch(\Throwable $th){
              throw new Error("Error al intentar borrar el registro de la base de datos," . $th->getMessage());
             }
    }

    public function editAlumno($alumnoBd)
    {
        try{

            $this->entityManagerInterface->flush($alumnoBd);
        }catch(\Throwable $th){
            throw new Error("Error al intentar actualizar el registro de la base de detos." . $th->getMessage());
        }
    }
    
}
