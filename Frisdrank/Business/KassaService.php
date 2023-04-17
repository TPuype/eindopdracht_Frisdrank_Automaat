<?php

declare(strict_types=1);

namespace Business;

use Data\KassaDAO;

class KassaService
{
    public function getKassaInhoud() : array{
        $kassaDAO = new KassaDAO();
        $muntenLijst = $kassaDAO->getKassa();
        return $muntenLijst;
    }

    public function kassaInhoudLegen(){
        $kassaDAO = new KassaDAO();
        $kassaDAO->kassaLegen();
    }

    public function getValuta(int $id) : float{
        $kassaDAO = new KassaDAO();
        $munt = $kassaDAO->getValuta($id);
        return $munt;
    }
}
