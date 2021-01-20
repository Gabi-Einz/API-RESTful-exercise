<?php

namespace App\Utilities\Error;

use Error;

class ServiceError extends Error{
    /**
     * @var int
     */
    private int $id;

    public function __construct(string $message, int $id, int $codeHttp)
    {
        parent::__construct($message,$codeHttp);
        $this->id = $id;
    }

    public function getId():int{
        return $this->id;
    }
    
    public function __toString(){
        return json_encode(["mensaje" => $this->getMessage(),"id" => $this->getId()]);
    }
}