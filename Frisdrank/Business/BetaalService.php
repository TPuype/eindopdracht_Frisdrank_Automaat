<?php

declare(strict_types=1);

namespace Business;

use Data\KassaDAO;
use Entities\Muntstuk;
use Exceptions\InworpTekortException;

class BetaalService
{

    public function BerekenWisselGeld(float $inworp, float $prijs): int
    {
        if ($inworp > 0 && $inworp >= $prijs) {
            $wisselgeld = $inworp - $prijs;
            $wisselgeld = (int) round(($wisselgeld * 100), 0);
            return $wisselgeld;
        } else throw new InworpTekortException();
    }

    public function BerekenMuntStukken(int $wisselgeld): array
    {
        $wisselGeldPerMunt = [0, 0, 0, 0, 0];
        if ($wisselgeld > 0) {
            $twees = (int) ($wisselgeld / 200);
            $wisselgeld = $wisselgeld - (200 * $twees);
            $wisselGeldPerMunt[0] += $twees;

            $eenen = (int) ($wisselgeld / 100);
            $wisselgeld = $wisselgeld - (100 * $eenen);
            $wisselGeldPerMunt[1] += $eenen;

            $vijftigs = (int) ($wisselgeld / 50);
            $wisselgeld = $wisselgeld - (50 * $vijftigs);
            $wisselGeldPerMunt[2] += $vijftigs;

            $twintigs = (int) ($wisselgeld / 20);
            $wisselgeld = $wisselgeld - (20 * $twintigs);
            $wisselGeldPerMunt[3] += $twintigs;

            $tienen = (int) ($wisselgeld / 10);
            $wisselgeld = $wisselgeld - (10 * $tienen);
            $wisselGeldPerMunt[4] += $tienen;
        }
        return $wisselGeldPerMunt;
    }

    public function berekenKassa(array $munten, array $wisselgeld): array
    {
        $res = array();
        for ($i = 0; $i < count($munten); $i++) {
            $res[$i] = $munten[$i] - $wisselgeld[$i];
        }
       return $res;
    }

    public function bewaarKassa(array $munten)
    {
        for ($i = 0; $i <= count($munten) - 1; $i++) {
            $munt = new Muntstuk((int) ($i + 1), (int) $munten[$i]);
            $kassaDoa = new KassaDAO();
            $kassaDoa->schrijfNaarKassa($munt);
        }
    }
}
