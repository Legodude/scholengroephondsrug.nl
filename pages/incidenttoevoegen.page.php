<?php

if(!isset($_GET['hardwareID']))
{
    header("Location: /scholengroephondsrug.nl/?action=hardware&nextaction=incidentaanmaken");
}
else
{
    ?>
    <form action="#" method="POST" >
        <table>
            <tr><td>HardwareID:</td><td><input type="text" disabled="disabled" name="Hardware_ID" <?php echo 'value="'.$_GET['hardwareID'].'"'; ?> /></td></tr>
            <tr><td>Aanvang:</td><td><input type="datetime" name="incidentAanvang" /></td></tr>
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
            <tr><td>Gebruiker:</td><td><input type="text" disabled="disabled" value="<?php echo $_SESSION['gebruikercode']; ?>" /></td></tr>
            <tr><td>Status:</td><td><select name="incidentUrgentie" />
                <option value="1">Open</option>
                <option value="2">In behandeling</option>
                <option value="3">Gesloten</option>
        </select></td></tr>
        </table>
        <input type="submit" />
    </form>
    <?php
}