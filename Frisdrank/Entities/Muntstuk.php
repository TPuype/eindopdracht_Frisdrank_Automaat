<?php

declare(strict_types=1);

namespace Entities;

use Business\KassaService;

class Muntstuk
{
    private int $muntId;
    private int $aantal;


    public function __construct(int $muntId, int $aantal)
    {
        $this->muntId = $muntId;
        $this->aantal = $aantal;
    }

    public function getMuntId() : int{
        return $this->muntId;
    }

    public function getValuta() : float{
        $kassaService = new KassaService();
        $munt = $kassaService->getValuta($this->getMuntId());
        return $munt;
    }

    public function getAantal(): int
    {
        return $this->aantal;
    }

    public function setAantal(int $aantal)
    {
        $this->aantal = $aantal;
    }
}
