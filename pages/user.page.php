<?php
    if(isset($_POST['wachtwoord'])&&isset($_POST['voornaam'])&&isset($_POST['achternaam'])&&isset($_POST['email']))
    {        
        $wachtwoord = $mysqli->real_escape_string(strip_tags($_POST['wachtwoord']));
        $voornaam = $mysqli->real_escape_string(strip_tags($_POST['voornaam']));
        $achternaam = $mysqli->real_escape_string(strip_tags($_POST['achternaam']));
        $email = $mysqli->real_escape_string(strip_tags($_POST['email']));
        $level = $mysqli->real_escape_string(strip_tags($_POST['accountlevel']));
        $gebruikercode = strtoupper(substr($achternaam ,0,3).substr($voornaam,0,2));
        $sql = "INSERT INTO `cms_gebruikers`(gebruikercode,wachtwoord,voornaam,achternaam,gebruikerslevel,email)
                        VALUES('$gebruikercode', '$wachtwoord', '$voornaam', '$achternaam', '.$gebruikercode.', '$email')";
        $result =  $mysqli->query($sql);
        echo "Gebruiker toegevoegd!";
        exit();
?>

<form action="#" METHOD="POST">
    <table>
        <tr>
            <td><label for="voornaam">Voornaam:</label></td><td><input autocomplete="off" type="text" name="voornaam" value="" /></td>
        </tr>
        <tr>
            <td><label for="achternaam">Achternaam:</label></td><td><input autocomplete="off" type="text" name="achternaam" value="" /></td>
        </tr>
        <tr>
            <td><label for="email">E-mail:</label></td><td><input autocomplete="off" type="text" name="email" value="" /></td>
        </tr>
        <tr>
            <td><label for="wachtwoord">Wachtwoord:</label></td><td><input autocomplete="off" type="password" name="wachtwoord" value="" /></td>
        </tr>
        <tr>
            <td>Acountlevel:</td><td><select name="accountlevel">
                    <option value="0" >geen rechten</option>
                    <option value="1" >incidentbeheer</option>
                    <option value="2" >probleembeheer</option>
                    <option value="3" >wijzigingsbeheer</option>
                    <option value="4" >configuratiebeheer</option>
                    <option value="5" >beheerder</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" value="Aanmaken" />
</form>
    