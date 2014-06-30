<?php

if(!isset($_GET['probleemid'])) header('Location: ?action=problemen');
else
{
    $sql = 'SELECT * from `im_problemen` WHERE `Probleem_ID` = "'.$_GET['probleemid'].'"';
    $result = $mysqli->query($sql);
    if($result->num_rows!=0)
    {
        $probleem=$result->fetch_assoc();
        ?>
<table>
    <tr>
        <td>ProbleemID:</td>
        <td><?php echo $probleem['Probleem_ID']; ?></td>
    </tr>
    <tr>
        <td>Omschrijving:</td>
        <td><?php echo $probleem['Probleem_Omschrijving']; ?></td>
    </tr>
    <tr>
        <td>Workaround:</td>
        <td><?php echo $probleem['Probleem_Workaround']; ?></td>
    </tr>
    <tr>
        <td>Opgelost:</td>
        <td><?php echo ($probleem['Probleem_Opgelost']==1)?('Ja'):('Nee') ?></td>
    </tr>
    <tr style="vertical-align: top;">
        <td>Incidenten:</td>
        <td>
                <?php
                    $sql = 'SELECT * from `im_incidentprobleemlink` '
                            . 'INNER JOIN `im_incidenten` ON `im_incidentprobleemlink`.`Incident_ID` = `im_incidenten`.`Incident_ID` '
                            . ' where `Probleem_ID` = "'.$_GET['probleemid'].'"';
                    $result = $mysqli->query($sql);
                    while($row = $result->fetch_assoc())
                    {
                        echo '<table style="font-size:12px; border: thin black solid;">';
                        echo '<tr>';
                            echo '<td>IncidentID</td>';
                            echo '<td>'.$row['Incident_ID'].'</td>';
                        echo '<tr>';
                        echo '<tr>';
                            echo '<td>HardwareID</td>';
                            echo '<td>'.$row['IncidentHardware_ID'].'</td>';
                        echo '<tr>';
                        echo '<tr>';
                            echo '<td>Aanvang:</td>';
                            echo '<td>'.$row['IncidentAanvang'].'</td>';
                        echo '<tr>';
                        echo '<tr>';
                            echo '<td>Omschrijving</td>';
                            echo '<td>'.$row['IncidentOmschrijving'].'</td>';
                        echo '<tr>';
                        echo '</table>';
                    }
                ?>
            
        </td>
    </tr>
</table>
        <?php
    }
}