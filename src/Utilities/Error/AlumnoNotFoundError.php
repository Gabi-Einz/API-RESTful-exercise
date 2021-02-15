<?php

namespace App\Utilities\Error;

use Error;

class AlumnoNotFoundError extends Error{
    /**
     * @var int
     */
    private int $id;

    public function __construct()
    {
        parent::__construct("Error, Alumno no encontrado en bd!",102);
        $this->id = 3;
    }

    public function getId():int{
        return $this->id;
    }
    
    public function __toString(){
        return json_encode(["mensaje" => $this->getMessage(),"id" => $this->getId()]);
    }
}