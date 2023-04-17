<?php

declare(strict_types=1);

namespace Data;

use \PDO;
use Data\DBConfig;
use Entities\Muntstuk;

class KassaDAO
{
    public function getKassa(): array
    {
        $dbh = new PDO(
            DBConfig::$DB_CONNSTRING,
            DBConfig::$DB_USERNAME,
            DBConfig::$DB_PASSWORD
        );

        $resultSet = $dbh->query("select * from kassa");

        $lijst = array();
        foreach ($resultSet as $rij) {
            $muntstuk = new Muntstuk((int) $rij["muntId"], (int) $rij["aantal"]);
            array_push($lijst, $muntstuk);
        }
        $dbh = null;
        return $lijst;
    }

    public function kassaLegen()
    {
        $dbh = new PDO(
            DBConfig::$DB_CONNSTRING,
            DBConfig::$DB_USERNAME,
            DBConfig::$DB_PASSWORD
        );

        $sql = "update kassa set aantal = 0";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $dbh = null;
    }

    public function getValuta(int $id): float
    {
        $dbh = new PDO(
            DBConfig::$DB_CONNSTRING,
            DBConfig::$DB_USERNAME,
            DBConfig::$DB_PASSWORD
        );

        $sql = "select valuta.munt from valuta inner join kassa on valuta.id = kassa.muntId where kassa.muntId = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(
            ':id' => $id
        ));
        $rij = $stmt->fetch(PDO::FETCH_ASSOC);
        $munt = $rij["munt"];
        $dbh = null;
        return $munt;
    }

    public function schrijfNaarKassa(Muntstuk $munt)
    {
        $dbh = new PDO(
            DBConfig::$DB_CONNSTRING,
            DBConfig::$DB_USERNAME,
            DBConfig::$DB_PASSWORD
        );
        if ($munt->getAantal() > 0) {
            $sql = "update kassa set aantal = (aantal + :aantal) where muntId = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array(
                ':id' => (int) $munt->getMuntId(), ':aantal' => (int) $munt->getAantal()
            ));
            $dbh = null;
        }
    }
}
