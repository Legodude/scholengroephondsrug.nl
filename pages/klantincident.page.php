<script type="text/javascript">
    function addOmschrijvingBox()
    {
        var dropdown = document.getElementById('omschrijvingdropdown');
        var textfield = document.getElementById('omschrijvingtext');
        dropdown.name="omschrijvinginvisible";
        textfield.name="omschrijving";
        textfield.style.display="block";
    }
</script>
<?php
if(isset($_POST['Hardware_ID']))
{
    $sql = 'INSERT INTO `im_incidenten` 
            (IncidentHardware_ID,IncidentAanvang,IncidentOmschrijving,IncidentImpact,IncidentUrgentie,gebruikercode,IncidentStatus)
            VALUES
            ("'.$_POST['Hardware_ID'].'",
            "'.$_POST['incidentAanvangdatum'].' '.$_POST['incidentAanvangtijd'].'",
            "'.$_POST['omschrijving'].'",
            "1",
            "1",
            "'.$_POST['gebruikercode'].'",
            "1")';
    $result =  $mysqli->query($sql);
    echo $sql;
    echo "Incident aangemaakt!<br>";
    exit();
}

if(!isset($_GET['hardwareID']))
{
    header("Location: ?action=incidenthardwarelist&nextaction=klantincident");
}
else
{
    ?>
    <form action="#" method="POST" >
        <table>
            <tr><td>HardwareID:</td><td><input type="text" readonly="readonly" name="Hardware_ID" <?php echo 'value="'.$_GET['hardwareID'].'"'; ?> /></td></tr>
            <tr><td>Aanvangdatum:</td><td><input type="date" readonly="readonly" name="incidentAanvangdatum" value="<?php echo $date= date('Y-m-d')?>" /></td></tr>
            <tr><td>Aanvangtijd:</td><td><input type="time" readonly="readonly" name="incidentAanvangtijd" value="<?php echo $time= date('H:i:s')?>" /></td></tr>
            <tr><td>Omschrijving:</td>
                <td id="omschrijvingcell">
                    <select id="omschrijvingdropdown" name="omschrijving" style="width:155px;">
                        <?php
                        $sql = 'SELECT DISTINCT `IncidentOmschrijving` from `im_incidenten`';
                        $result = $mysqli->query($sql);
                        while($row = $result->fetch_assoc())
                        {
                            echo '<option>'.$row['IncidentOmschrijving'].'</option>';
                        }
                        ?>
                    </select>
                </td></tr>
            <tr><td>Gebruiker:</td><td><input name="gebruikercode" type="text" readonly="readonly" value="<?php echo $_SESSION['gebruikercode']; ?>" /></td></tr>
        </table>
        <input type="submit" />
    </form>
    <?php
}