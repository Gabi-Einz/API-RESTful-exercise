<?php

namespace App\Controller;

use App\Service\AlumnoService;
use App\Service\CursoService;
use App\Service\EnrollService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnrollController extends AbstractController
{
    /**
     * @Route("/create_enroll/curso/{idCurso}/alumno/{idAlumno}", name="createEnroll", methods={"POST"})
     */
    public function createEnroll(int $idAlumno, int $idCurso,
                                 LoggerInterface $logger, AlumnoService $alumnoService, CursoService $cursoService,EnrollService $enrollService)
    {
        $logger->info("Estoy en createEnroll $idAlumno $idCurso");

        $alumno = $alumnoService->getAlumno($idAlumno);

        $curso = $cursoService->getCurso($idCurso);

        $enrollService->createEnroll($alumno,$curso);

        
        return new Response($idAlumno);
       
    }

    /**
    * @Route("/delete_enroll/curso/{idCurso}/alumno/{idAlumno}", name="deleteEnroll", methods={"DELETE"})
    */
    public function deleteEnroll(int $idAlumno, int $idCurso,
                                 LoggerInterface $logger, AlumnoService $alumnoService, CursoService $cursoService,EnrollService $enrollService)
    {
        $logger->info("Estoy en deleteEnroll $idAlumno $idCurso");

        $alumno = $alumnoService->getAlumno($idAlumno);

        $curso = $cursoService->getCurso($idCurso);

        $enrollService->deleteEnroll($alumno,$curso);

        
        return new Response($idAlumno);
       
    }
}
