<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CursoService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Entity\Curso;
use Symfony\Component\HttpFoundation\Response;

class CursoController extends AbstractController
{
  /**
     * @Route("/createCurso", name="curso",methods={"POST"})
     */
    public function createCurso(Request $request, 
    SerializerInterface $serializer, 
    ValidatorInterface $validator,
    CursoService $cursoService,
    LoggerInterface $logger)
    {
        $data = $request->getContent();

        $logger->info('Capa de controlador: '.$data);

        try {//valido formato
            (object) $curso = $serializer->deserialize($data, Curso::class,"json",[]);
        } catch (\Throwable $th) {
            throw new Exception("Ha ocurrido un error, formato de datos JSON invalido: " . $th->getMessage());
        }

        $errors = $validator->validate($curso);//valido logica (anotations en entidades)
        if (count($errors) > 0) {
           throw new Exception("Ha ocurrido un error, logica de datos JSON invalido: " . (string) $errors);
        }

        (int) $id = $cursoService->createCurso($curso);//llamo al servicio 
        
        return new JsonResponse($id);//envio respuesta
    }
    
    /**
     *      
     * @Route("/cursos", methods={"GET"})
     */
    public function getCursos(CursoService $cursoService, LoggerInterface $logger,SerializerInterface $serializer)
    {

        $logger->info("Estoy en getCursos()");

        (object) $cursos = $cursoService->getCursos();

        // $response =  $this->json($cursos, 200, [], [
        //     AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__'],
        // ]);

        // return $response;

        // Serialize tu object en Json
        $jsonObject = $serializer->serialize($cursos, 'json', [
             'circular_reference_handler' => function ($object) {
             return $object->getId();
            }
            ]);

        
        return new Response($jsonObject, 200, ['Content-Type' => 'application/json']);

    }

    /**
     * @Route("/curso/{id}", methods={"GET"})
     */
    public function getCurso(CursoService $cursoService, int $id, LoggerInterface $logger)
    {
           $logger->info("Estoy en getCurso!!!");

           $curso = $cursoService->getCurso($id);

           $response =  $this->json($curso, 200, [], [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['__initializer__', '__cloner__', '__isInitialized__'],
        ]);

        return $response;  
    }

    /**
     * @Route("/curso/{id}", methods={"DELETE"})
     */
    public function deleteCurso(CursoService $cursoService, int $id, LoggerInterface $logger )
    {
        $logger->info("Estoy en deleteCurso!!!");

        $curso = $cursoService->getCurso($id);

        $cursoService->deleteCurso($curso);
        
        return new JsonResponse($id);

    }

     /**
     * @Route("/curso/{id}", methods={"PUT"})
     */
    public function editCurso(CursoService $cursoService,
                               int $id, 
                               LoggerInterface $logger, 
                               Request $request, 
                               ValidatorInterface $validator, 
                               SerializerInterface $serializer)
    {
        $logger->info("Estoy en editCurso!!!");

        $data = $request->getContent();

        try {//valido formato
            (object) $curso = $serializer->deserialize($data, Curso::class,"json",[]);
        } catch (\Throwable $th) {
            throw new Exception("Ha ocurrido un error, formato de datos JSON invalido: " . $th->getMessage());
        }

        $errors = $validator->validate($curso);//valido logica (anotations en entidades)
        if (count($errors) > 0) {
           throw new Exception("Ha ocurrido un error, logica de datos JSON invalido: " . (string) $errors);
        }

        $cursoBd = $cursoService->getCurso($id);

        $cursoService->editCurso($curso,$cursoBd);
        
        return new JsonResponse($id);

    }
}
