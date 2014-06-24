<?php
    echo '
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
        </td>
    </table>
        <input type="submit" value="Aanmaken" />
    </form> ';
    /*if(!isset($_POST['gebruikerscode'])&&($_POST['wachtwoord'])&&($_POST['voornaam'])&&($_POST['achternaam'])&&($_POST['email']))
    {
        echo "De velden zijn niet volledig ingevuld";
        echo "De velden zijn met de volgende informatie gevuld.'<br>'";
        echo "<input type='button' value='Terug naar vorige pagina' onClick='javascript:history.go(-1)' />";
    }
    else 
    {
        $sql =  mysqli_query ("INSERT INTO `cms_gebruikers`(gebruikercode,wachtwoord,voornaam,achternaam,gebruikerslevel,email)
                        VALUES('$gebruikercode', '$wachtwoord', '$voornaam', '$achternaam', $gebruikerslevel, '$email');");
        
        $gebruikerslevel = 0;
        $wachtwoord = $_POST['wachtwoord'];
        $voornaam = strip_tags($_POST['voornaam']);
        $achternaam = strip_tags($_POST['achternaam']);
        $email = $_POST['email'];
        
        $gebruikercode = strtoupper(substr($achternaam ,0,3).substr($voornaam,0,2));
    }*/
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