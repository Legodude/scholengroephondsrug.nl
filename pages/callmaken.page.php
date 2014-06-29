<?php
if(!isset($_GET['Incident_ID']))
{
    $sql = 'SELECT * FROM `im_incidenten` WHERE `Incident_ID` NOT IN (SELECT `Incident_ID` from `im_incidentCalls`)';
    $result = $mysqli->query($sql);
    echo '<table class="ci-table">';
    $i = 0;
    while($row = $result->fetch_assoc())
    {
        echo '<tr class="ci-table-row ';
        if($i%2) echo 'even';
        else echo 'uneven';
        echo '" onclick="location.href=\'?action=callmaken&Incident_ID='.$row['Incident_ID'].'\'">';
        echo '<td class="ci-table-cell">'.$row['Incident_ID'].'</td>';
        echo '<td class="ci-table-cell">'.$row['IncidentHardware_ID'].'</td>';
        echo '<td class="ci-table-cell">'.$row['IncidentAanvang'].'</td>';
        echo '<td class="ci-table-cell">'.$row['IncidentOmschrijving'].'</td>';
        echo '<td class="ci-table-cell">'.$row['IncidentWorkaround'].'</td>';
        echo '<td class="ci-table-cell">'.$row['gebruikercode'].'</td>';
        echo '</tr>';
        $i++;
    }
    echo '</table>';
}
else
{
    if(!isset($_POST['Opening']) AND !isset($_POST['incident'])){
    date_default_timezone_set('Europe/Amsterdam');
    $now = date("Y-m-d H:i");
    $now = str_replace(' ', 'T', $now);
    ?>


    <form method="post" action="#">
        <table>
            <tr>
                <td>Incident:</td><td>
            <?php
            echo $_GET['Incident_ID'];
            echo '<input type="hidden" name="incident" value="'.$_GET['Incident_ID'].'" />';
            ?>
                </td>
            </tr>
            <tr>
                <td>Omschrijving:</td><td>
            <?php
            $sql = 'SELECT * from `im_incidenten` where `Incident_ID` = "'.$_GET['Incident_ID'].'"';
            $result = $mysqli->query($sql);
            echo $result->fetch_assoc()['IncidentOmschrijving'];
            ?>
                </td>
            </tr>
            <tr><td>starttijd:</td><td>
        <input type="datetime-local" name="Opening" value="<?php echo $now; ?>" />
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
}