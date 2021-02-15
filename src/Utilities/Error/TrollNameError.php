<?php

namespace App\Utilities\Error;

use Error;

class TrollNameError extends Error{
    /**
     * @var int
     */
    private int $id;

    public function __construct()
    {
        parent::__construct("Error, no trollees crack!!!!",100);
        $this->id = 1;
    }

    public function getId():int{
        return $this->id;
    }
    
    public function __toString(){
        return json_encode(["mensaje" => $this->getMessage(),"id" => $this->getId()]);
    }
}