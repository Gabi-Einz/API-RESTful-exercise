<?php
namespace App\Service;
use App\Repository\CursoRepository;
use App\Repository\AlumnoRepository;

use App\Utilities\Error\ServiceError;

class EnrollService{
  
    var CursoRepository $cursoRepository;
    var AlumnoRepository $alumnoRepository;

    public function __construct(CursoRepository $cursoRepository, AlumnoRepository $alumnoRepository)
    {
        $this->cursoRepository = $cursoRepository;
        $this->alumnoRepository = $alumnoRepository;
    }

    public function createEnroll($alumno, $curso)
    {        
      if($curso->getCantAlumnos() >= 5)
      throw new ServiceError("El curso esta lleno, se permiten 5 alumnos inscriptos como maximo!",1,400);
     
     
      $alumno->addCurso($curso);
      $curso->addAlumno($alumno);

      $this->cursoRepository->editCurso($curso);
      $this->alumnoRepository->editAlumno($alumno);
     
          
    }

    public function deleteEnroll($alumno, $curso)
    {        
     
      $alumno->removeCurso($curso);
      $curso->removeAlumno($alumno);

      $this->cursoRepository->editCurso($curso);
      $this->alumnoRepository->editAlumno($alumno);
     
          
    }
 

}