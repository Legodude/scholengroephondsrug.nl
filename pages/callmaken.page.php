<?php

if(!isset($_POST['Opening']) AND !isset($_POST['incident'])){
date_default_timezone_set('Europe/Amsterdam');
$now = date("Y-m-d H:i");
$now = str_replace(' ', 'T', $now);
?>


<form method="post" action="#">
    <table>
        
        <tr><td>starttijd:</td><td>
    <input type="datetime-local" name="Opening" value=<?php echo $now;?>>
            </td>
        </tr>
        <tr>
            <td>Incident:</td><td>
    <select name="incident" style="width: 235px;">
        <?php
        $query="SELECT Incident_ID, Incidentomschrijving FROM im_incidenten WHERE im_incidenten.incidentOplossing IS NULL";
        $result=$mysqli->query($query);
        While($row=$result->fetch_assoc()){
            echo '<option value="'.$row['Incident_ID'].'">';
            echo $row['Incident_ID'].': '.$row['Incidentomschrijving'];
            echo '</option>';
        }
            
        ?>
    </select>
            </td>
        </tr>
    </table>
    <input type='submit' value='Call maken'>
    
</form>
<?php
    }
else{
 
    $opening = $_POST['Opening'];
    $ID = $_POST['incident'];
    $opening = str_replace("T", " ", $opening);
    $query="INSERT INTO im_incidentcalls (Callopening, Incident_ID, CallStatus)
        VALUES ('$opening', $ID, 0)";
    $mysqli->query($query);
    echo "Call is aangemaakt.";
} 