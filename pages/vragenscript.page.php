<script type="text/javascript">
    function answerQuestion(question_ID)
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET","?action=vragenscript.page.php&partial=1&question="+question_ID,false);
        xmlhttp.send();
        document.getElementById('history').innerHTML = xmlhttp.responseText+document.getElementById('history').innerHTML;
    }
    function bold(id)
    {
        document.getElementById(id).style.fontWeight='900';
    }
</script>

<?php
if(isset($_GET['question']))
{
    echo '<div class="questionbox">';
    displayQuestion($_GET['question']);
    echo '</div>';
}

if(!isset($_GET['question']))
{
    echo '<div id="history">';
    echo '<div class="questionbox">';
    displayQuestion(11);
    echo '<div>';
    echo '</div>';
}


function displayQuestion($vraagid)
{
    global $mysqli;
    $sql = "SELECT * FROM `vs_vragen` WHERE `Vraag_ID` = ".$vraagid;
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    echo $row['Vraag'].'<br />';
    $sql = "SELECT * FROM `vs_antwoorden` WHERE `BijVraag_ID` = ".$row['Vraag_ID'];
    $result = $mysqli->query($sql);
    while($row = $result->fetch_assoc())
    {
        echo '<div id="'.$row['antwoord_ID'].'" onclick="answerQuestion(\''.$row['VolgendeVraag_ID'].'\');bold(\''.$row['antwoord_ID'].'\')">'.$row['Antwoord'].'</div>';
    }
}