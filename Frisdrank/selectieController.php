<?php

declare(strict_types=1);

spl_autoload_register();

session_start();

require_once("vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('Presentation');
$twig = new Environment($loader);

use Business\BetaalService;
use Business\DrankService;
use Exceptions\InworpTekortException;
use Exceptions\VoorraadLeegException;

$keuze = $_GET["keuze"];
$lijstVanMunten = [0,0,0,0,0];

$drankSvc = new DrankService();
$drankenLijst = $drankSvc->getDrankOverzicht();

if (isset($_GET["action"]) && $_GET["action"] === "reset") {
    session_unset();
}

if (isset($_GET["action"]) && $_GET["action"] == "betaal") {
    try {
        $drankSvc = new DrankService();
        $prijs = $drankSvc->prijsOphalenById((int) $_GET["keuze"]);
        $betaalService = new BetaalService();
        $wisselgeld = $betaalService->BerekenWisselGeld((float) $_SESSION["ingeworpenBedrag"], (float) $prijs);
        $drankSvc->pasAantalAan((int) $_GET["keuze"]);
        $message = "Betaling gelukt. Wisselgeld: €" . ($wisselgeld / 100);
        $lijstVanMunten = $betaalService->BerekenMuntStukken((int) $wisselgeld);
        $bedragInKassa = $betaalService->berekenKassa($_SESSION["inworpMuntenArray"], $lijstVanMunten);
        $betaalService->bewaarKassa($bedragInKassa);
        $_SESSION["inworpMuntenArray"] = [0, 0, 0, 0, 0];
        $_SESSION["ingeworpenBedrag"] = 0;
        $betaald = true;

        print $twig->render("selectie.twig", array(
            "drankenLijst" => $drankenLijst,
            "keuze" => $keuze,
            "betaald" => $betaald,
            "message" => $message,
            "lijstMunten" => $lijstVanMunten
        ));
        exit(0);
    } catch (InworpTekortException $ex) {
        $error = "Betaling mislukt. Onvoldoende ingeworpen.";
        print $twig->render("selectie.twig", array(
            "drankenLijst" => $drankenLijst,
            "keuze" => $keuze,
            "error" => $error
        ));
        exit(0);
    } catch (VoorraadLeegException $ex) {
        $error = "Betaling mislukt. Drank niet in voorraad.";
        print $twig->render("selectie.twig", array(
            "drankenLijst" => $drankenLijst,
            "keuze" => $keuze,
            "error" => $error
        ));
        exit(0);
    }
}

if (!isset($_POST["munt"])) {
    $munt = 0;
} else {
    $munt = $_POST["munt"];
}

if (!isset($_SESSION["inworpMuntenArray"])) {
    $_SESSION["inworpMuntenArray"] = [0, 0, 0, 0, 0];
} else {
    if ($munt == 2) {
        $_SESSION["inworpMuntenArray"][0]++;
    } elseif ($munt == 1) {
        $_SESSION["inworpMuntenArray"][1]++;
    } elseif ($munt == 0.5) {
        $_SESSION["inworpMuntenArray"][2]++;
    } elseif ($munt == 0.2) {
        $_SESSION["inworpMuntenArray"][3]++;
    } elseif ($munt == 0.1) {
        $_SESSION["inworpMuntenArray"][4]++;
    }
}

if (!isset($_SESSION["ingeworpenBedrag"])) {
    $_SESSION["ingeworpenBedrag"] = 0;
} else {
    $_SESSION["ingeworpenBedrag"] += $munt;
}

$twig->addGlobal('session', $_SESSION);

print $twig->render("selectie.twig", array(
    "drankenLijst" => $drankenLijst,
    "keuze" => $keuze,
    "lijstMunten" => $lijstVanMunten
));
