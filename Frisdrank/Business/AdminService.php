<?php

declare(strict_types=1);

namespace Business;

use Exceptions\LoginException;

class AdminService {

    public function controleerGebruiker(string $gebruikersnaam, string $wachtwoord): bool {
        if ($gebruikersnaam === "admin" && $wachtwoord === "geheim"){
            return true;
        }
        else {
            throw new LoginException();
            return false;
        }
    }

}
