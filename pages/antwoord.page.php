<table style="font-size: 12px;">
<?php

if(isset($_POST['antwoord'])&&isset($_POST['bijvraag']))
{
    if(!empty($_POST['antwoord'])&&!empty($_POST['bijvraag']))
    {
        $volgendevraagid = $_POST['volgendevraag'];
        if(empty($_POST['volgendevraag'])) $volgendevraagid = "NULL";
        $sql = 'INSERT INTO `vs_antwoord` (`BijVraag_ID`,`Antwoord`,`VolgendeVraag_ID`) VALUES ('.$_POST['bijvraag'].',"'.$_POST['antwoord'].'",'.$volgendevraagid.')';
        $mysqli->query($sql);
    }
}

$sql = "SELECT * FROM `vs_antwoorden`";
$result = $mysqli->query($sql);
$i=0;
while($row = $result->fetch_assoc())
{
    $i=$row['antwoord_ID'];
    echo '<tr>';
    echo '<td>'.$row['antwoord_ID'].'</td>';
    echo '<td>';
    $sql = "SELECT * FROM `vs_vragen` where `Vraag_ID` = ".$row['BijVraag_ID'];
    $vraagres = $mysqli->query($sql);
    $vraag = $vraagres->fetch_assoc();
    echo $vraag['Vraag'];
    echo '</td>';
    echo '<td>'.$row['Antwoord'].'</td>';
    echo '<td>';
    $sql = "SELECT * FROM `vs_vragen` where `Vraag_ID` = ".$row['VolgendeVraag_ID'];
    $vraagres = $mysqli->query($sql);
    $vraag = $vraagres->fetch_assoc();
    echo $vraag['Vraag'];
    echo '</td>';
    echo '</tr>';
}
?>
    

<tr>
    <form action="#" method="POST">
    <td><?php echo ($i+1) ?></td>
    <td>
        <select name="bijvraag" style="width: 200px;">
            <?php
                $sql = "SELECT * FROM `vs_vragen`";
                $result = $mysqli->query($sql);
                while($row = $result->fetch_assoc())
                {
                    echo '<option value="'.$row['Vraag_ID'].'">';
                        echo $row['Vraag_ID'].':'.$row['Vraag'];
                    echo '</option>';
                }
            ?>
        </select>    
    </td>
    <td>
        <input type="text" name="antwoord" />
    </td>
    <td>
        <select name="volgendevraag" style="width: 100px;">
            <option value="">geen</option>
            <?php
                $sql = "SELECT * FROM `vs_vragen`";
                $result = $mysqli->query($sql);
                while($row = $result->fetch_assoc())
                {
                    echo '<option value="'.$row['Vraag_ID'].'">';
                        echo $row['Vraag_ID'].':'.$row['Vraag'];
                    echo '</option>';
                }
            ?>
        </select> 
    </td>
    </form>
</tr>

</table>
