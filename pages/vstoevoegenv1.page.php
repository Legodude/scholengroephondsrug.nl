voeg een vraag toe:
<form action="#" method="POST">
    <textarea name="vraag" ></textarea>
    <input type="submit" />
</form>

<?php
if(isset($_POST['vraag']))
{
    if(!empty($_POST['vraag']))
    {
        echo "vraag toegevoegd<br />";
        $sql = 'INSERT INTO `vs_vragen` (`Vraag`) VALUES ("'.$_POST["vraag"].'")';
        $mysqli->query($sql);
    }
    else
    {
        echo "er is iets mis gegaan, druk op terug om je vraag te redden.";
        print_r($_POST);
    }
}
?>

of voeg een antwoord toe:

<form action="#" method="POST">
    antwoord:<textarea name="antwoord" ></textarea>
    <br />
    Bij vraag:<SELECT name="bijvraag" >
        <?php
            $sql = "SELECT * FROM `vs_vragen`";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc())
            {
                echo '<option value = "'.$row["Vraag_ID"].'">'.$row['Vraag'].'</option>';
            }
        ?>
    </select><br />
        verwijst naar vraag:
    <SELECT name="volgendevraag" >
        <option value="">Geen</option>
        <?php
            $sql = "SELECT * FROM `vs_vragen`";
            $result = $mysqli->query($sql);
            while($row = $result->fetch_assoc())
            {
                echo '<option value = "'.$row["Vraag_ID"].'">'.$row['Vraag'].'</option>';
            }
        ?>
    </select>
        <input type="submit" />
    
</form>

<?php
if(isset($_POST['antwoord']))
{
    if(!empty($_POST['antwoord']))
    {
        echo "vraag toegevoegd<br />";
        $sql = 'INSERT INTO `vs_antwoorden` (`BijVraag_ID`, `Antwoord`,`VolgendeVraag_ID`) VALUES ("'.$_POST["bijvraag"].'","'.$_POST["antwoord"].'","'.$_POST["volgendevraag"].'")';
        $mysqli->query($sql);
    }
    else
    {
        echo "er is iets mis gegaan, druk op terug om je antwoord te redden.";
        print_r($_POST);
    }
}
?>