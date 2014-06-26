<?php

if(!isset($_POST['Opening']) AND !isset($_POST['incident'])){
?>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table>
        
        <tr><td>Openingstijd:</td><td>
    <input type="datetime-local" name="Opening">
            </td>
        </tr>
        <tr>
            <td>Incident:</td><td>
    <select name="incident">
        <?php
        $query="SELECT Incident_ID FROM im_incidenten WHERE im_incidenten.incidentOplossing IS NULL";
        $result=$mysqli->query($query);
        While($row=$result->fetch_assoc()){
            echo '<option name="incident">';
            echo $row['Incident_ID'];
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
} 