<form action="#" METHOD="POST">
    <table>
        <tr>
            <td><label for="voornaam">Voornaam:</label></td><td><input autocomplete="off" type="text" name="voornaam" /></td>
        </tr>
        <tr>
            <td><label for="achternaam">Achternaam:</label></td><td><input autocomplete="off" type="text" name="achternaam" /></td>
        </tr>
        <tr>
            <td><label for="email">E-mail:</label></td><td><input autocomplete="off" type="text" name="email" /></td>
        </tr>
        <tr>
            <td><label for="wachtwoord">Wachtwoord:</label></td><td><input autocomplete="off" type="password" name="wachtwoord" /></td>
        </tr>
    </table>
    <input type="submit" value="Aanmaken" />
</form>
    <?php
    if(isset($_POST['wachtwoord'])&&isset($_POST['voornaam'])&&isset($_POST['achternaam'])&&isset($_POST['email']))
    {        
        $wachtwoord = $mysqli->real_escape_string(strip_tags($_POST['wachtwoord']));
        $voornaam = $mysqli->real_escape_string(strip_tags($_POST['voornaam']));
        $achternaam = $mysqli->real_escape_string(strip_tags($_POST['achternaam']));
        $email = $mysqli->real_escape_string(strip_tags($_POST['email']));
        
        $gebruikercode = strtoupper(substr($achternaam ,0,3).substr($voornaam,0,2));
        $sql = "INSERT INTO `cms_gebruikers`(gebruikercode,wachtwoord,voornaam,achternaam,email)
                        VALUES('$gebruikercode', '$wachtwoord', '$voornaam', '$achternaam', '$email')";
        $result =  $mysqli->query($sql);
    }
?>