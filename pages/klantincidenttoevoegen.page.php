<?php
if(isset($_GET['hardwareID']))
{
    ?>

    <form action="#" method="POST" >
        <table>

        </table>
    <?php
}
else
{
    $sql = 'SELECT `Hardware_ID` FROM `cmdb_hardware`';
    $result = $mysql->query($sql);
?>
    <form action="#" method="POST" >
        <table>
            <!--<tr><td>Computer code:</td><td><select name="hardwareid" id="Hardware_ID"></td>-->
            <tr><td>Computer code:</td><td><?php echo "<select name='hardwareid'>";
                while ($temp = $result->fetch_assoc())
                {
                    echo "<option value='".$temp['Hardware_ID']."</option>";
                }
                echo "</select></td>";
                ?>
        </table>
        <?php
}

?>