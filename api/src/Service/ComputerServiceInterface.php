<?php

namespace App\Service;

use App\Entity\Computer;

interface ComputerServiceInterface
{
    /**
     * @param Computer $computer
     * @return mixed
     */
    public function playOnComputer(Computer $computer);
}