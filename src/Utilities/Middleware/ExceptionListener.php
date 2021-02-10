<?php
namespace App\Utilities\Middleware;

use App\Utilities\Error\ServiceError;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonDecode;

class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        
        if( json_decode($exception->__toString()) == NULL ){
            $arrayErrorResponse = [ 
                "message" => $exception->getMessage(),
                "trace" => explode ( "\n" , $exception->getTraceAsString() )
            ];
        }else{
            $arrayErrorResponse = json_decode($exception->__toString());
        }

        if( $exception->getCode() == 0 ){
            $httpCode = 500;
        }else{
            $httpCode = $exception->getCode();
        }

        $this->logger->error(json_encode($arrayErrorResponse));

        $jsonResponse = new JsonResponse($arrayErrorResponse,$httpCode);
        // sends the modified response object to the event
        $event->setResponse($jsonResponse);
    }
}