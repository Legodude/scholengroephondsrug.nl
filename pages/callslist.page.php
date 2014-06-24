<?php

$sql = '
    
SELECT IncidentAanvang, IncidentHardware_ID, TypeOmschrijving, LocatieOmschrijving, IncidentOmschrijving

FROM im_incidentcalls cal, im_incidenten inc, cmdb_hardware har, cmdb_type typ, cmdb_locatie loc

WHERE cal.incident_id = inc.incident_id
AND inc.IncidentHardware_ID = har.hardware_ID
AND har.HardwareType_ID = typ.Type_ID
AND har.HardwareLocatie_ID = loc.Locatie_ID;
    
';

$result = $mysqli->query($sql);
if($result->num_rows==1)
{
echo'<table>  ';

While($row = mysqli_fetch_array($result))
{
echo'

    <tr>
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
 }
?>


