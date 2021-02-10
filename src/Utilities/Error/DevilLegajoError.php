<?php

namespace App\Utilities\Error;

use Error;

class DevilLegajoError extends Error{
    /**
     * @var int
     */
    private int $id;

    public function __construct()
    {
        parent::__construct("Error, tu legajo le pertenece al diablo!",230);
        $this->id = 2;
    }

    public function getId():int{
        return $this->id;
    }
    
    public function __toString(){
        return json_encode(["mensaje" => $this->getMessage(),"id" => $this->getId()]);
    }
}