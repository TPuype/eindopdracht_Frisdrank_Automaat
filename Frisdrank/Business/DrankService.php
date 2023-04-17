<?php

declare(strict_types=1);

namespace Business;

use Data\DrankDAO;
use Entities\Drank;

class DrankService
{

    public function getDrankOverzicht(): array
    {
        $DrankDAO = new DrankDAO();
        $lijst = $DrankDAO->getAll();
        return $lijst;
    }

    public function pasAantalAan(int $id)
    {
        $DrankDAO = new DrankDAO();
        $DrankDAO->aantalVerminderen($id);
    }

    public function prijsOphalenById(int $id): float
    {
        $DrankDAO = new DrankDAO();
        $drank = $DrankDAO->getById($id);
        $prijs = $drank->getPrijs();
        return (float) $prijs;
    }

    public function checkVoorraad(Drank $drank)
    {
        if ($drank->getAantal() <= 0) {
            $inVoorraad = false;
        } else {
            $inVoorraad = true;
        }
        return $inVoorraad;
    }

    public function aanvullen(int $aantal, int $id){
        $drankDao = new DrankDAO();
        $drankDao->voorraadAnvullen($aantal, $id);
    }
}
