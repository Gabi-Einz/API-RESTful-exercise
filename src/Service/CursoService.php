<?php

namespace App\Service;

use App\Repository\CursoRepository;
use App\Repository\MateriaRepository;
use App\Repository\ProfesorRepository;

class CursoService{

    var CursoRepository $cursoRepository;
    var ProfesorRepository $profesorRepository;
    var MateriaRepository $materiaRepository;

    public function __construct(CursoRepository $cursoRepository,ProfesorRepository $profesorRepository, MateriaRepository $materiaRepository)
    {
        $this->cursoRepository = $cursoRepository;
        $this->profesorRepository = $profesorRepository;
        $this->materiaRepository = $materiaRepository;
    }
    

    public function createCurso($curso)
    {
        $this->cursoRepository->createCurso($curso);
        $this->profesorRepository->createProfesor($curso);
        $this->materiaRepository->createMateria($curso);

        return $curso->getId();
    }
    
    public function getCursos()
    {
        $cursos = $this->cursoRepository->getCursos();

        return $cursos;
    }

    public function getCurso($id)
    {
        $curso = $this->cursoRepository->getCursobyId($id);

        return $curso;
    }
    
    public function deleteCurso($curso)
    {
        $this->cursoRepository->deleteCurso($curso);
    }
    public function editCurso($curso,$cursoBd)
    {
        $cursoBd->setName($curso->getName());
        $cursoBd->setProfesor($curso->getProfesor());
        $cursoBd->setMateria($curso->getMateria());


        $this->cursoRepository->editCurso($cursoBd);
    }
}