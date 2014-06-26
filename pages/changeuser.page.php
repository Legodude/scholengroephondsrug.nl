<?php

$gebruikercode = $_GET["gebruikercode"];
echo $gebruikercode."<br>";

$sql = 'SELECT * 
FROM `cms_gebruikers`
WHERE `gebruikercode` = "'.$gebruikercode.'"';

$user = $mysqli->query($sql);
$userinfo = array();

if($result->num_rows==1)
{
    $userinfo = $result->fetch_assoc(); 


switch ($acountlevel)
{
    case 0:
        $acountlevelnaam = "EVERYONE";
        break;
    case 1:
        $acountlevelnaam = "INCIDENTBEHEER";
        break;
    case 2:
        $acountlevelnaam = "PROBLEEMBEHEER";
        break;
    case 3:
        $acountlevelnaam = "WIJZIGINGSBEHEER";
        break;
    case 4:
        $acountlevelnaam = "CONFIGURATIBEHEER";
        break;
    case 5:
        $acountlevelnaam = "ADMIN";
        break;
    default :
        $acountlevelnaam = "EVERYONE";            
}

?>
<form action="#" METHOD="POST">
    <table>
        <tr>
            <td>Voornaam:</td><td><input autocomplete="off" type="text" name="voornaam" value="<?php echo $voornaam['voornaam']; ?>" /></td>
        </tr>
        <tr>
            <td>Achternaam:</td><td><input autocomplete="off" type="text" name="achternaam" value="<?php echo $achternaam['achternaam']; ?>" /></td>
        </tr>
        <tr>
            <td>E-mail:</td><td><input autocomplete="off" type="text" name="email" value="<?php echo $email['email']; ?>" /></td>
        </tr>
        <tr>
            <td>Wachtwoord:</td><td><input autocomplete="off" type="text" name="wachtwoord" value="<?php echo $wachtwoord['wachtwoord']; ?>"/></td>
        </tr>
        <tr>
            <td>Acountlevel:</td><td><select name="acountlevel">
                    <option value="<?php echo $acountlevel['gebruikerslevel'];?>">Rechten nu: <?php echo$acountlevelnaam;?></option>
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
    <input type="hidden" name="gebruikerscode" value="<?php echo $gebruikerscode;?>">
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
            SET `voornaam` = "'.$voornaam.', `achternaam` = "'.$achternaam.'", `email`="'.$email.'" `wachtwoord` = "'.$wachtwoord.'", `gebruikreslevel` = "'.$acountlevel.'"
            WHERE gebruikerscode = "'.$gebruikerscode.'"';
    
    $result =  $mysqli->query($sql);
    
    foreach ($_POST as $key => $value) {

        echo $value."<br>";
        
    }
}
?>
