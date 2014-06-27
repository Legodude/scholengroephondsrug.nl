<?php

$gebruikercode = $_GET["gebruikercode"];

$sql = 'SELECT * 
FROM `cms_gebruikers`
WHERE `gebruikercode` = "'.$gebruikercode.'"';

$result = $mysqli->query($sql);
$userinfo = array();

if($result->num_rows==1)
{
    $userinfo = $result->fetch_assoc(); 
    $gebruikerslevel = $userinfo['gebruikerslevel'];
    
switch ($gebruikerslevel)
{
    case 0:
        $gebruikerslevelnaam = "EVERYONE";
        break;
    case 1:
        $gebruikerslevelnaam = "INCIDENTBEHEER";
        break;
    case 2:
        $gebruikerslevelnaam = "PROBLEEMBEHEER";
        break;
    case 3:
        $gebruikerslevelnaam = "WIJZIGINGSBEHEER";
        break;
    case 4:
        $gebruikerslevelnaam = "CONFIGURATIBEHEER";
        break;
    case 5:
        $gebruikerslevelnaam = "ADMIN";
        break;
    default :
        $gebruikerslevelnaam = "EVERYONE";            
}
?>
<form action="#" METHOD="POST">
    <table>
        <tr>
            <td>Gebruikersnaam:</td><td><?php echo $userinfo['gebruikercode']?></td>
        </tr>
        <tr>
            <td>Voornaam:</td><td><input autocomplete="off" type="text" name="voornaam" value="<?php echo $userinfo['voornaam']; ?>" /></td>
        </tr>
        <tr>
            <td>Achternaam:</td><td><input autocomplete="off" type="text" name="achternaam" value="<?php echo $userinfo['achternaam']; ?>" /></td>
        </tr>
        <tr>
            <td>E-mail:</td><td><input autocomplete="off" type="text" name="email" value="<?php echo $userinfo['email']; ?>" /></td>
        </tr>
        <tr>
            <td>Wachtwoord:</td><td><input autocomplete="off" type="text" name="wachtwoord" value="<?php echo $userinfo['wachtwoord']; ?>"/></td>
        </tr>
        <tr>
            <td>Acountlevel:</td><td><select name="acountlevel">
                    <option value="<?php echo $userinfo['gebruikerslevel'];?>">Rechten nu: <?php echo$gebruikerslevelnaam;?></option>
                    <option value="0">EVERYONE</option>
                    <option value="1">INCIDENTBEHEER</option>
                    <option value="2">PROBLEEMBEHEER</option>
                    <option value="3">WIJZIGINGSBEHEER</option>
                    <option value="4">CONFIGURATIBEHEER</option>
                    <option value="5">ADMIN</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" value="Aanpassen" />
    <input type="hidden" name="gebruikerscode" value="<?php echo $gebruikercode;?>">
</form>
<?php
}
else
{
    echo "Geen gebruikers informatie gevonden";
}

if(isset($_POST['wachtwoord'])&&isset($_POST['voornaam'])&&isset($_POST['achternaam'])&&isset($_POST['email']))
{
 
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $acountlevel = $_POST['acountlevel'];
    $gebruikercode = $_POST['gebruikerscode'];
    
    $sql = 'UPDATE `cms_gebruikers`
            SET `voornaam` = "'.$voornaam.'", `achternaam` = "'.$achternaam.'", `email`="'.$email.'", `wachtwoord` = "'.$wachtwoord.'", `gebruikerslevel` = '.$acountlevel.'
            WHERE gebruikercode = "'.$gebruikercode.'"';
    
    $result =  $mysqli->query($sql);
    header("Location: ?action=userlist");
}
?>
