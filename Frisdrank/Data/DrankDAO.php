<?php
declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Drank;
use Exceptions\VoorraadLeegException;
use Exceptions\VoorraadVolException;

class DrankDAO
{
    public function getAll(): array
    {
        $dbh = new PDO(
            DBConfig::$DB_CONNSTRING,
            DBConfig::$DB_USERNAME,
            DBConfig::$DB_PASSWORD
        );

        $resultSet = $dbh->query("select * from dranken");

        $lijst = array();
        foreach ($resultSet as $rij) {
            $drank = new Drank((int) $rij["id"], $rij["naam"], (float) $rij["prijs"], (int)$rij["aantal"], $rij["img"]);
            array_push($lijst, $drank);
        }
        $dbh = null;
        return $lijst;
    }

    public function aantalVerminderen(int $id)
    {
        $drank = $this->getById($id);
        $huidigAantal = $drank->getAantal();
        if ($huidigAantal > 0){
            $sql = "update dranken set aantal = aantal - 1 where id = :id";
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':id' => (int)$id));
            $dbh = null;
        } else{
            throw new VoorraadLeegException();
        }
    }

    public function getById(int $id): Drank
    {
        $sql = "select * from dranken where id = :id";
        $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':id' => $id));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $drank = new Drank((int)$rij["id"], $rij["naam"], (float) $rij["prijs"], (int) $rij["aantal"], $rij["img"]);
        $dbh = null;
        return $drank;
    }

    public function voorraadAnvullen(int $aantal, int $id){
        $drank = $this->getById($id);
        $huidigAantal = $drank->getAantal();
        if ($huidigAantal + $aantal <= 20){
            $sql = "update dranken set aantal = aantal + :aantal where id = :id";
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(':id' => (int)$id, ':aantal' => $aantal));
            $dbh = null;
        } else{
            throw new VoorraadVolException();
        }
    }

  
}
