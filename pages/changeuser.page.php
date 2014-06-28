<?php

$gebruikercode = $_GET["gebruikercode"];

if(isset($_POST['wachtwoord'])&&isset($_POST['voornaam'])&&isset($_POST['achternaam'])&&isset($_POST['email']))
{
 
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $acountlevel = $_POST['acountlevel'];
    $gebruikercode = $_POST['gebruikerscode'];
    
    $sql = 'UPDATE `cms_gebruikers`
            SET `voornaam` = "'.$voornaam.'", `achternaam` = "'.$achternaam.'", `email`="'.$email.'"';
    if(!empty($_POST['wachtwoord'])) $sql.=', `wachtwoord` = "'.$wachtwoord.'"';
    $sql.= ', `gebruikerslevel` = '.$acountlevel.'
            WHERE gebruikercode = "'.$gebruikercode.'"';
    
    $result =  $mysqli->query($sql);
    header("Location: ?action=userlist");
}

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
    case 1:
        $gebruikerslevelnaam = "incidentbeheer";
        break;
    case 2:
        $gebruikerslevelnaam = "probleembeheer";
        break;
    case 3:
        $gebruikerslevelnaam = "wijzigingsbeheer";
        break;
    case 4:
        $gebruikerslevelnaam = "configuratiebeheer";
        break;
    case 5:
        $gebruikerslevelnaam = "beheerder";
        break;
    case 0:
    default :
        $gebruikerslevelnaam = "niet ingelogd";            
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
            <td>Wachtwoord wijzigen:</td><td><input autocomplete="off" type="password" name="wachtwoord" /></td>
        </tr>
        <tr>
            <td>Acountlevel:</td><td><select name="acountlevel">
                    <option value="0" <?php if($userinfo['gebruikerslevel']==0) echo 'selected="selected"' ?>>geen rechten</option>
                    <option value="1" <?php if($userinfo['gebruikerslevel']==1) echo 'selected="selected"' ?>>incidentbeheer</option>
                    <option value="2" <?php if($userinfo['gebruikerslevel']==2) echo 'selected="selected"' ?>>probleembeheer</option>
                    <option value="3" <?php if($userinfo['gebruikerslevel']==3) echo 'selected="selected"' ?>>wijzigingsbeheer</option>
                    <option value="4" <?php if($userinfo['gebruikerslevel']==4) echo 'selected="selected"' ?>>configuratiebeheer</option>
                    <option value="5" <?php if($userinfo['gebruikerslevel']==5) echo 'selected="selected"' ?>>beheerder</option>
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
?>
