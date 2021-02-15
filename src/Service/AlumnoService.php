<?php

namespace App\Service;

use App\Repository\AlumnoRepository;
use App\Utilities\Error\AlumnoNotFoundError;
use App\Utilities\Error\DevilLegajoError;
use App\Utilities\Error\TrollNameError;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AlumnoService{

     /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    var AlumnoRepository $alumnoRepository;

    public function __construct(AlumnoRepository $alumnoRepository, LoggerInterface $logger, SerializerInterface $serializer)
    {
        $this->alumnoRepository = $alumnoRepository;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }
    

    public function createAlumno($alumno)
    {    /**el Serializer no se puede inyectar como dependencia */
        // $normalizer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);//convierto datos enviados en arrray
        // (array)$request = $normalizer->normalize($alumno, "json");

        (string)$request = $this->serializer->serialize($alumno,"json",[]);
        
        $this->logger->info( 'Capa de servicio: ' .  $request  );//logeo los datos enviados

        if($alumno->getName() == "soy un troll")
           throw new TrollNameError();

        if($alumno->getLegajo() == 666)
         throw new DevilLegajoError();

        $this->alumnoRepository->createAlumno($alumno);

        return $alumno->getId();
    }
    
    public function getAlumnos()
    {
        $alumnos = $this->alumnoRepository->getAlumnos();
        
        if(!$alumnos)
        throw new AlumnoNotFoundError();
        
        return $alumnos;
    }

    public function getAlumno($id)
    {
        $alumno = $this->alumnoRepository->getAlumnoById($id);

        if(!$alumno)
           throw new AlumnoNotFoundError();

        return $alumno;
    }
    
    public function deleteAlumno($id_alumno)
    {
        $alumno = $this->getAlumno($id_alumno);
        $this->alumnoRepository->deleteAlumno($alumno);
    }
    
    public function editAlumno($alumno,$alumnoBd)
    {
        $alumnoBd->setName($alumno->getName());
        $alumnoBd->setLegajo($alumno->getLegajo());

        $this->alumnoRepository->editAlumno($alumnoBd);
    }
}