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
<table>
    <tr>
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaarid</th>
    </tr>
    <?php
    global $connect;
    $paring=$connect->prepare("Select id, president, pilt, punktid, lisamisaeg, kommentaarid  from valimised where avalik=1");
    $paring->bind_result($id,$president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$president."</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td><a href='?lisa1punkt=$id'> +1 punkt</a></td>";
        echo "<td><a href='?minus1punkt=$id'> -1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
<form method='post' action=''>
<input type='hidden' name='uue_komment_id' value='$id'>
<label for='uus_kommentaar'></label>
<input type='text' name='uus_kommentaar' id='uus_kommentaar'>
<br><br>
<input type='submit' value='ok'>
</form></td>";
        echo "</tr>";
    }
    ?>
</table>
<h2>Lisa oma presidendi</h2>
<form action="?" method="post">
    <label for="presidentiNimi">President nimi: </label>
    <input type="text" name="presidentiNimi" id="presidentiNimi">
    <br><br>
    <label for="pilt">President pilt: </label>
    <textarea name="pilt" id="pilt"></textarea>
    <br><br>
    <input type="submit" value="Lisa">
</form>
</body>
</html>
