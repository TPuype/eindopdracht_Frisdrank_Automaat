<?php

declare(strict_types=1);

namespace Entities;

use Business\DrankService;

class Drank
{
    private int $id;
    private string $naam;
    private float $prijs;
    private int $aantal;
    private string $imgUrl;


    public function __construct(int $id, string $naam, float $prijs, int $aantal, string $imgUrl)
    {
        $this->id = $id;
        $this->naam = $naam;
        $this->prijs = $prijs;
        $this->aantal = $aantal;
        $this->imgUrl = $imgUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNaam(): string
    {
        return $this->naam;
    }

    public function getAantal(): int
    {
        return $this->aantal;
    }

    public function getPrijs(): float
    {
        return $this->prijs;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function getInVoorraad(){
        $drankSvc = new DrankService();
        $inVoorraad = $drankSvc->checkVoorraad($this);
        return $inVoorraad;
    }

}
