<?php

declare(strict_types=1);

spl_autoload_register();

session_start();

require_once("vendor/autoload.php");

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('Presentation');
$twig = new Environment($loader);

use Business\DrankService;

$drankSvc = new DrankService();
$drankenLijst = $drankSvc->getDrankOverzicht();

if(isset($_GET["action"]) && $_GET["action"] === "logout"){
    $_SESSION["aangemeld"] = false;
}

if(isset($_GET["action"]) && $_GET["action"] === "reset"){
    session_unset();
}

if (!isset($_POST["munt"])) {
    $munt = 0;
} else {
    $munt = $_POST["munt"];
}

if (!isset($_SESSION["ingeworpenBedrag"])) {
    $_SESSION["ingeworpenBedrag"] = 0;
} else {
    $_SESSION["ingeworpenBedrag"] += $munt;
}

$twig->addGlobal('session', $_SESSION);

if(isset($_GET["keuze"])){
    header("location: selectieController.php");
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

print $twig->render("home.twig", array("drankenLijst"=>$drankenLijst));