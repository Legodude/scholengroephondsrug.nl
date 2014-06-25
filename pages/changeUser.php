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
            <td>Acountlevel:</td><td><select>
                    <option value="<?phpecho$acountlevel;?>">Level nu: <?php echo$acountlevel;?>"/></option>
                    <option> value""<?php echo USER_LEVEL_EVERYONE;?></option>
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
