<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__,1));}
require ('config.php');
//+1 punkt
global $connect;
if(isset($_REQUEST['lisa1punkt'])){
    $paring=$connect->prepare("Update valimised SET punktid=punktid+1 WHERE id=?");
    $paring->bind_param('i',$_REQUEST['lisa1punkt']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab päring ja jääb faili nimi
    $connect->close();
}
//-1 punkt
if(isset($_REQUEST['minus1punkt'])){
    $paring=$connect->prepare("Update valimised SET punktid=punktid-1 WHERE id=?");
    $paring->bind_param('i',$_REQUEST['minus1punkt']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']);
    $connect->close();
}
//lisamine andmetabelisse
if(isset($_REQUEST['presidentiNimi']) && !empty($_REQUEST['presidentiNimi'])){
    $paring=$connect->prepare("INSERT INTO valimised(president, pilt, lisamisaeg)
    VALUES(?,?,NOW())");
    $paring->bind_param('ss',$_REQUEST['presidentiNimi'],$_REQUEST['pilt']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']);
    $connect->close();
}
//kommentaari lisamine - Update
if(isset($_REQUEST['uue_komment_id'])){
    $paring=$connect->prepare("
Update valimised SET kommentaarid=concat(kommentaarid, ?) WHERE id=?");
    $komment2=$_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param('si',$komment2, $_REQUEST['uue_komment_id']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab päring ja jääb faili nimi
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Valimiste leht</title>
    <link rel="stylesheet" href="valmisedStyle.css">
</head>
<body>
<h1>TARpv24 presidendi valimised</h1>
<nav>
    <ul>
        <li>
            <a href="valimised.php">Kasutaja leht</a>
        </li>
        <li>
            <a href="valimisedAdmin.php">Admin leht</a>
        </li>
        <li>
            <a href="galerii.php">Galerii</a>
        </li>
    </ul>
</nav>
<div id="menu">
    <?php
    global $connect;
    $paring=$connect->prepare("Select id, pilt from valimised where avalik=1");
    $paring->bind_result($id,$pilt);
    $paring->execute();
        while($paring->fetch()){
            echo "<li><a href='?id=$id'>"."<img src='$pilt' alt='pilt'>"."</a></li>";
        }
        echo "<br>";
    ?>
    <div id="sisu">
            <?php
            global $connect;
            if(isset($_REQUEST['id'])){
                $paring=$connect->prepare(
                    "Select id, president, lisamisaeg, kommentaarid, punktid, avalik from valimised WHERE id=?");
                $paring->bind_result($id, $presidenr, $lisamisaeg, $kommentaarid, $punktid, $avalik);
                $paring->bind_param("i", $_REQUEST['id']);
                $paring->execute();

                if($paring->fetch()){
                    echo "<strong>President: </strong>".htmlspecialchars($presidenr)."<br>";
                    echo "<strong>Lisamisaeg: </strong>".htmlspecialchars($lisamisaeg)."<br>";
                    echo "<strong>Kommentaarid: </strong>".htmlspecialchars($kommentaarid)."<br>";
                    echo "<strong>Lisa kommentaar: </strong>"."<form method='post' action=''>
                    <input type='hidden' name='uue_komment_id' value='$id'>
                    <label for='uus_kommentaar'></label>
                    <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
                    <br>
                    <input type='submit' value='ok'>
                    </form> <br>";
                    echo "<strong>Punktid:</strong> "."$punktid"."<a href='?lisa1punkt=$id'> +1 punkt </a>".
                        "<a href='?minus1punkt=$id'> -1 punkt</a>"."<br>";
                    $tekst='Peidetud';
                    if($avalik==1){
                        $tekst='Näidatud';
                        echo "<strong>Staatus: </strong>"."$tekst"."<br>";
                    }else{
                        echo "<strong>Staatus: </strong>"."$tekst"."<br>";
                    }
                }
            }?>
    </div>
</div>
</body>
</html>
