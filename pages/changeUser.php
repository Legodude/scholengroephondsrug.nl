<!-- echo USER_LEVEL_EVERYONE;-->
<?php $sql = 'SELECT * FROM `cms_gebruikers`';
$result = $mysqli->query($sql);
$userlist = array();
if($rusult =="1")
{
    
}
?>
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
        <tr>
            <td>Acountlevel:</td><td><select><?php ?>
    </table>
    <input type="submit" value="Aanmaken" />
</form>
<?php


?>
