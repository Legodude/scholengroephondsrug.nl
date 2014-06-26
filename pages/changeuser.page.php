<?php
/*
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$acountlevel = $_POST['acountlevel'];
*/
$voornaam = "robert";
$achternaam = "stocker";
$email = "test@test.local";
$wachtwoord = "1biertje";
$acountlevel = 1;

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
            <td>Voornaam:</td><td><input autocomplete="off" type="text" name="voornaam" value="<?php echo $voornaam; ?>" /></td>
        </tr>
        <tr>
            <td>Achternaam:</td><td><input autocomplete="off" type="text" name="achternaam" value="<?php echo $achternaam; ?>" /></td>
        </tr>
        <tr>
            <td>E-mail:</td><td><input autocomplete="off" type="text" name="email" value="<?php echo $email; ?>" /></td>
        </tr>
        <tr>
            <td>Wachtwoord:</td><td><input autocomplete="off" type="text" name="wachtwoord" value="<?php echo $wachtwoord; ?>"/></td>
        </tr>
        <tr>
            <td>Acountlevel:</td><td><select name="acountlevel">
                    <option value="<?php echo $acountlevel;?>">Rechten nu: <?php echo$acountlevelnaam;?></option>
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
</form>
<?php
if(isset($_POST['wachtwoord'])&&isset($_POST['voornaam'])&&isset($_POST['achternaam'])&&isset($_POST['email']))
{
 
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $acountlevel = $_POST['acountlevel'];
    
    $sql = 'UPDATE ``';
    
    foreach ($_POST as $key => $value) {

        echo $value."<br>";
        
    }
}

?>
