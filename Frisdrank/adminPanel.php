<?php

declare(strict_types=1);

spl_autoload_register();

use Business\DrankService;
use Business\KassaService;
use Exceptions\VoorraadVolException;

session_start();

require_once("vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('Presentation');
$twig = new Environment($loader);

if ($_SESSION["aangemeld"]) {
    $drankService = new DrankService();
    $drankLijst = $drankService->getDrankOverzicht();

    $kassa = new KassaService();
    $muntenLijst = $kassa->getKassaInhoud();


    if (isset($_GET["action"]) && $_GET["action"] === "vullen" && isset($_GET["keuze"])) {
        try {
            $aantal = $_POST["txtVullen"];
            $drankService->Aanvullen((int) $aantal, (int) $_GET["keuze"]);
            $drankService = new DrankService();
            $drankLijst = $drankService->getDrankOverzicht();
            $kassa = new KassaService();
            $muntenLijst = $kassa->getKassaInhoud();
            print $twig->render("admin.twig", array(
                "drankenLijst" => $drankLijst,
                "lijstMunten" => $muntenLijst,
            ));
            exit(0);
        } catch (VoorraadVolException $ex) {
            $error = "Error: Voorraad vol. Niet meer dan 20 stuks per artikel toegelaten";
            print $twig->render("admin.twig", array(
                "drankenLijst" => $drankLijst,
                "lijstMunten" => $muntenLijst,
                "error" => $error
            ));
            exit(0);
        }
    }

    if (isset($_POST["legen"])) {
        $kassa->kassaInhoudLegen();
        $muntenLijst = $kassa->getKassaInhoud();
    }

    print $twig->render("admin.twig", array(
        "drankenLijst" => $drankLijst,
        "lijstMunten" => $muntenLijst
    ));

} else{
    header("location: adminLogin.php");
}
