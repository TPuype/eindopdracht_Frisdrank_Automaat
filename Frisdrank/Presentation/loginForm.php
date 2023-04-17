<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h2>Aanmelden</h2>

    <form action="adminLogin.php?action=admin" method="post">
        <table>
            <tbody>
                <tr>
                    <td>Gebruikersnaam:</td>
                    <td><input type="text" name="txtGebruikersnaam"></td>
                </tr>
                <tr>
                    <td>Wachtwoord:</td>
                    <td><input type="password" name="txtWachtwoord"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Aanmelden" /></td>
                </tr>
            </tbody>
        </table>
    </form>
    <?php
    if (isset($error)) {
    ?> <p class="error"><?php echo $error; ?></p>
    <?php
    }
    unset($error);
    ?>

</body>

</html>