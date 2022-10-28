<?php

namespace Models;

class Owner
{
    private $dni;

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this->dni;
    }
}
