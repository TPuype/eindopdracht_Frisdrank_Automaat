<?php

declare(strict_types=1);

spl_autoload_register();

use Business\AdminService;
use Exceptions\LoginException;

session_start();
try{
    if (isset($_GET["action"]) && $_GET["action"] === "admin") {
        $svc = new AdminService();
        $toegelaten = $svc->controleerGebruiker(
            $_POST["txtGebruikersnaam"],
            $_POST["txtWachtwoord"]
        );
    
        if ($toegelaten) {
            $_SESSION["aangemeld"] = true;
            header("location: adminPanel.php");
            exit(0);
        } else {
            header("location: adminLogin.php");
            exit(0);
        }
    } else {
        include("presentation/loginForm.php");
    }
} catch (LoginException $ex){
    $error = "Login Mislukt. Probeer opnieuw";
    include("presentation/loginForm.php");
    exit(0);
}
