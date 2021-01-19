<?php

namespace App\Service;

use App\Repository\AlumnoRepository;

class AlumnoService{

    var AlumnoRepository $alumnoRepository;

    public function __construct(AlumnoRepository $alumnoRepository)
    {
        $this->alumnoRepository = $alumnoRepository;
    }
    

    public function createAlumno($alumno)
    {
        $this->alumnoRepository->createAlumno($alumno);

        return $alumno->getLegajo();
    }
    
    public function getAlumnos()
    {
        $alumnos = $this->alumnoRepository->getAlumnos();

        return $alumnos;
    }

    public function getAlumno($id)
    {
        $alumno = $this->alumnoRepository->getAlumnobyId($id);

        return $alumno;
    }
    
    public function deleteAlumno($alumno)
    {
        $this->alumnoRepository->deleteAlumno($alumno);
    }
    public function editAlumno($alumno,$alumnoBd)
    {
        $alumnoBd->setName($alumno->getName());
        $alumnoBd->setLegajo($alumno->getLegajo());

        $this->alumnoRepository->editAlumno($alumnoBd);
    }
}