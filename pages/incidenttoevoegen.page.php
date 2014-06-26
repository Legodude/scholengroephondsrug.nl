<?php
if(isset($_POST['Hardware_ID']))
{
    $sql = 'INSERT INTO `im_incidenten` 
            (IncidentHardware_ID,IncidentAanvang,IncidentOmschrijving,IncidentWorkaround,IncidentImpact,IncidentUrgentie,gebruikercode,IncidentStatus)
            VALUES
            ("'.$_POST['Hardware_ID'].'",
            "'.$_POST['incidentAanvangdatum'].' '.$_POST['incidentAanvangtijd'].'",
            "'.$_POST['incidentOmschrijving'].'",
            "'.$_POST['incidentWorkaround'].'",
            "'.$_POST['incidentImpact'].'",
            "'.$_POST['incidentUrgentie'].'",
            "'.$_POST['gebruikercode'].'",
            "'.$_POST['incidentStatus'].'")';
    echo "Incident aangemaakt!";
    
    exit();
}

if(!isset($_GET['hardwareID']))
{
    header("Location: /scholengroephondsrug.nl/?action=incidenthardwarelist&nextaction=incidentaanmaken");
}
else
{
    ?>
    <form action="#" method="POST" >
        <table>
            <tr><td>HardwareID:</td><td><input type="text" readonly="readonly" name="Hardware_ID" <?php echo 'value="'.$_GET['hardwareID'].'"'; ?> /></td></tr>
            <tr><td>Aanvangdatum:</td><td><input type="date" name="incidentAanvangdatum" /></td></tr>
            <tr><td>Aanvangtijd:</td><td><input type="text" name="incidentAanvangtijd" /></td></tr>
            <tr><td>Omschrijving:</td><td><input type="text" name="incidentOmschrijving" /><br />
            <tr><td>Workaround:<br />(mits van toepassing)</td><td><input type="text" name="incidentWorkaround" /><br />
            <tr><td>Impact:</td><td><select name="incidentImpact" />
                <option value="3">Hoog</option>
                <option value="2">Gemiddeld</option>
                <option value="1">Laag</option>
            </select></td></tr>
            <tr><td>Urgentie:</td><td><select name="incidentUrgentie" />
                <option value="3">Hoog</option>
                <option value="2">Gemiddeld</option>
                <option value="1">Laag</option>
            </select></td></tr>
            <tr><td>Gebruiker:</td><td><input name="gebruikercode" type="text" readonly="readonly" value="<?php echo $_SESSION['gebruikercode']; ?>" /></td></tr>
            <tr><td>Status:</td><td><select name="incidentStatus" />
                <option value="1">Open</option>
                <option value="2">In behandeling</option>
                <option value="3">Gesloten</option>
        </select></td></tr>
        </table>
        <input type="submit" />
    </form>
    <?php
}