<?php





if(!isset($_POST['ID']) AND !isset($_POST['sluiting']) AND !isset($_POST['oplossing'])){
$query="SELECT IncidentCall_ID FROM im_incidentcalls WHERE CallSluiting IS NULL";
$result=$mysqli->query($query);
?>
<form method='post' action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table>
        <tr>
            <td>CallID:</td>
            <td>
                <select name='ID'>
                <?php
                    While($row=$result->fetch_assoc()){
                        echo '<option>';
                        echo $row['IncidentCall_ID'];
                        echo '</option>';
                    }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                CallSluiting:
            </td>
            <td>
                <input type="datetime-local" name='sluiting'>
            </td>
        </tr>
        <tr>
            <td>
                Oplossing:
            </td>
            <td>
                <input type="text" name='oplossing'>
            </td>
        </tr>
    </table>
    <input type='submit' value="Call Sluiten">
</form>
<?php
}
else{
    $sluiting = $_POST['sluiting'];
    $ID = $_POST['ID'];
    $oplossing = $_POST['oplossing'];
    $sluiting = str_replace("T", " ", $sluiting);
    
    $query="UPDATE im_incidentcalls
            INNER JOIN im_incidenten
            ON im_incidentcalls.Incident_ID=im_incidenten.Incident_ID
            SET CallSluiting='$sluiting', CallStatus=1, IncidentOplossing='$oplossing'
            WHERE IncidentCall_ID=$ID
            ";
    $mysqli->query($query);
    
}
?>



