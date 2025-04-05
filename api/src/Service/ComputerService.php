<?php

namespace App\Service;

use App\Entity\Computer;

class ComputerService implements ComputerServiceInterface
{
    /**
     * @param Computer $computer
     * @return string
     */
    public function playOnComputer(Computer $computer): string
    {
        return 'I am playing on computer with id ' . $computer->getId() . ' and name ' . $computer->getName();
    }
}