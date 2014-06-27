<?php





if(!isset($_POST['ID']) && !isset($_POST['sluiting']) && !isset($_POST['oplossing'])){
$query="SELECT IncidentCall_ID, IncidentOmschrijving FROM im_incidentcalls a, im_incidenten b WHERE CallSluiting IS NULL and a.Incident_ID = b.Incident_ID";
$result=$mysqli->query($query);
if($result->num_rows==0) echo "geen calls!", exit();
?>
<form method='post' action="#">
    <table>
        <tr>
            <td>CallID:</td>
            <td>
                <select name='ID'>
                <?php
                    While($row=$result->fetch_assoc()){
                        echo '<option value="'.$row['IncidentCall_ID'].'">';
                        echo $row['IncidentCall_ID'].':'.$row['IncidentOmschrijving'];
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
    
    $query="SELECT email, IncidentOmschrijving
            FROM im_incidenten
            INNER JOIN im_incidentcalls
            ON im_incidentcalls.Incident_ID=im_incidenten.Incident_ID
            WHERE IncidentCall_ID=$ID";
    $result=$mysqli->query($query);
    $row=$result->fetch_assoc();
    echo "Incident omschrijving: ".$row['IncidentOmschrijving']."<br />";
    echo "Incidentmelder: ".$row['email']."<br />";
    echo "Call gesloten! <br />";
}
?>



