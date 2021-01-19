<?php

namespace App\Controller;


use App\Service\AlumnoService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Alumno; //SOLUCION SEEEEEEEEEE
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer; //Lo uso para preparar la respuesta del GET al cliente

class AlumnoController extends AbstractController
{
    /**
     * @Route("/createAlumno", name="alumno",methods={"POST"})
     */
    public function createAlumno(Request $request, 
    SerializerInterface $serializer, 
    ValidatorInterface $validator,
    AlumnoService $alumnoService,
    LoggerInterface $logger)
    {
        $data = $request->getContent();

        $logger->info('Capa de controlador: '.$data);

        try {//valido formato
            (object) $alumno = $serializer->deserialize($data, Alumno::class,"json",[]);
        } catch (\Throwable $th) {
            throw new Exception("Ha ocurrido un error, formato de datos JSON invalido: " . $th->getMessage());
        }

        $errors = $validator->validate($alumno);//valido logica (anotations en entidades)
        if (count($errors) > 0) {
           throw new Exception("Ha ocurrido un error, logica de datos JSON invalido: " . (string) $errors);
        }

        (int) $legajo = $alumnoService->createAlumno($alumno);//llamo al servicio 
        
        return new JsonResponse($legajo);//envio respuesta
    }
    
    /**
     *      
     * @Route("/alumnos", methods={"GET"})
     */
    public function getAlumnos(AlumnoService $alumnoService, LoggerInterface $logger)
    {

        $logger->info("Estoy en getAlumnos()");

        (object) $alumnos = $alumnoService->getAlumnos();

        $response =  $this->json($alumnos, 200, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__'],
        ]);

        return $response;

    }

    /**
     * @Route("/alumno/{id}", methods={"GET"})
     */
    public function getAlumno(AlumnoService $alumnoService, int $id, LoggerInterface $logger)
    {
           $logger->info("Estoy en getAlumno!!!");

           $alumno = $alumnoService->getAlumno($id);

           $response =  $this->json($alumno, 200, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__'],
        ]);

        return $response;  
    }

    /**
     * @Route("/alumno/{id}", methods={"DELETE"})
     */
    public function deleteAlumno(AlumnoService $alumnoService, int $id, LoggerInterface $logger )
    {
        $logger->info("Estoy en deleteAlumno!!!");

        $alumno = $alumnoService->getAlumno($id);

        $alumnoService->deleteAlumno($alumno);
        
        return new JsonResponse($id);

    }

     /**
     * @Route("/alumno/{id}", methods={"PUT"})
     */
    public function editAlumno(AlumnoService $alumnoService,
                               int $id, 
                               LoggerInterface $logger, 
                               Request $request, 
                               ValidatorInterface $validator, 
                               SerializerInterface $serializer)
    {
        $logger->info("Estoy en editAlumno!!!");

        $data = $request->getContent();

        try {//valido formato
            (object) $alumno = $serializer->deserialize($data, Alumno::class,"json",[]);
        } catch (\Throwable $th) {
            throw new Exception("Ha ocurrido un error, formato de datos JSON invalido: " . $th->getMessage());
        }

        $errors = $validator->validate($alumno);//valido logica (anotations en entidades)
        if (count($errors) > 0) {
           throw new Exception("Ha ocurrido un error, logica de datos JSON invalido: " . (string) $errors);
        }

        $alumnoBd = $alumnoService->getAlumno($id);

        $alumnoService->editAlumno($alumno,$alumnoBd);
        
        return new JsonResponse($id);

    }
}
