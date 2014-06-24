<?php
if(!isset($_POST['submit']))
{    
    echo '<form "action="index.php?action=# METHOD="POST">
    <table>
        <tr>
            <td><label for="voornaam">Voornaam</label></td><td><input type="text" name="voornaam" /></td>
        </tr>
        <tr>
            <td><label for="achternaam">Achternaam</label></td><td><input type="text" name="achternaam" /></td>
        </tr>
        <tr>
            <td><label for="email">E-mail</label></td><td><input type="text" name="email" /></td>
        </tr>
        <tr>
            <td><label for="wachtwoord">Wachtwoord</label></td><td><input type="password" name="wachtwoord" /></td>
        </td>
    </table>
        <input type="submit" value="Aanmaken" />
    </form> ';
}
else
{
    if(!isset($_POST['gebruikerscode'])&&($_POST['wachtwoord'])&&($_POST['voornaam'])&&($_POST['achternaam'])&&($_POST['email']))
    {
        echo "De velden zijn niet volledig ingevuld";
        echo "<input type='button' value='Terug naar vorige pagina' onClick='javascript:history.go(-1)' />";
    }
    else 
    {
        $sql =  mysqli_query ("INSERT INTO `cms_gebruikers`(gebruikercode,wachtwoord,voornaam,achternaam,gebruikerslevel,email)
                        VALUES('$gebruikercode', '$wachtwoord', '$voornaam', '$achternaam', $gebruikerslevel, '$email');");
        $gebruikerslevel = 0;

        foreach ($_POST as $key => $value)
        {
            echo $key."<br>";
        }
    }
}

?>