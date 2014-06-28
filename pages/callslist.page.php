<?php
/*
if(isset($_POST['IncidentCall_ID']))
{
    $sql = 'UPDATE `im_incidentcalls` SET CallStatus = "'.$_POST['status'].'" WHERE `IncidentCall_ID` = "'.$_POST['IncidentCall_ID'].'"';
    echo $sql
    $mysqli->query($sql);    
}*/

$sql = '
    
SELECT CallOpening, IncidentHardware_ID, inc.Incident_ID, TypeOmschrijving, LocatieOmschrijving, IncidentOmschrijving, IncidentCall_ID, CallStatus

FROM im_incidentcalls cal, im_incidenten inc, cmdb_hardware har, cmdb_type typ, cmdb_locatie loc

WHERE cal.incident_id = inc.incident_id
AND inc.IncidentHardware_ID = har.hardware_ID
AND har.HardwareType_ID = typ.Type_ID
AND har.HardwareLocatie_ID = loc.Locatie_ID
AND cal.CallStatus = 0 
';

$result = $mysqli->query($sql);

if($result->num_rows>0)
{
    echo '<table class="ci-table">';
    echo '<th>IncidentAanvang</th><th>Hardware ID</th><th>Type</th><th>Locatie</th><th>IncidentID</th><th>Omschrijving</th>';
    $i=0;
    while($row = $result->fetch_assoc())
    {
        echo '<tr class="ci-table-row ';
        if($i%2) echo 'even';
        else echo 'uneven';
        echo '" onclick="location.href=\'?action=calloplossen&callid='.$row['IncidentCall_ID'].'\'">';
        echo '<td class="ci-table-cell">'.$row['CallOpening'].'</td>';
        echo '<td class="ci-table-cell">'.$row['IncidentHardware_ID'].'</td>';
        echo '<td class="ci-table-cell">'.$row['TypeOmschrijving'].'</td>';
        echo '<td class="ci-table-cell">'.$row['LocatieOmschrijving'].'</td>';
        echo '<td class="ci-table-cell">'.$row['Incident_ID'].'</td>';
        echo '<td class="ci-table-cell">'.$row['IncidentOmschrijving'].'</td>';
        /*echo '<td class="ci-table-cell">';
        echo '<form id="form-'.$row['IncidentCall_ID'].'" action="#" method="POST">';
        echo '<input name="IncidentCall_ID" type="hidden" value="'.$row['IncidentCall_ID'].'"/>';
        echo '<select name="status" onchange="document.getElementById(\'form-'.$row['IncidentCall_ID'].'\').submit();">';
        echo '<option value="0"';
        if($row['CallStatus']=='0') echo ' selected="selected"';
        echo '>niet in behandeling</option>';
        echo '<option value="1"';
        if($row['CallStatus']=='1') echo ' selected="selected"';
        echo '>opgelost</option>';
        echo '</form>';
        echo '</td>';*/
        echo '</tr>';
        $i++;
    }
}

/*($result->num_rows==1)
{
echo'<table class="ci-table">  ';

while($row = mysqli_fetch_array($result))
{
echo'

    <tr class="ci-table-row">
        <td>
            '.$row['IncidentAanvang'].'     
        </td>
        <td>
            '.$row['IncidentHardware_ID'].' 
        </td>               
        <td>
            '.$row['TypeOmschrijving'].' 
        </td>
        <td>
             '.$row['LocatieOmschrijving'].'   
        </td>
        <td>
            '.$row['IncidentOmschrijving'].' 
        </td>            
    </tr>
    
';
            
}
echo'</table>';
}
 else {
 echo'Momenteel zijn er geen calls om af te werken.'  ; 
 }*/
?>


