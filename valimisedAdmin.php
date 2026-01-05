<?php if (isset($_GET['code'])) {die(highlight_file(__FILE__,1));}
require ('config.php');
global $connect;
//nulliks
if(isset($_REQUEST['nullpunkt'])){
    $paring=$connect->prepare("Update valimised SET punktid=0 WHERE id=?");
    $paring->bind_param('i',$_REQUEST['nullpunkt']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab päring ja jääb faili nimi
}
//Näitamine
if(isset($_REQUEST['naita'])){
    $paring=$connect->prepare("Update valimised SET avalik=1 WHERE id=?");
    $paring->bind_param('i',$_REQUEST['naita']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab päring ja jääb faili nimi
}
//Peida
if(isset($_REQUEST['peida'])){
    $paring=$connect->prepare("Update valimised SET avalik=0 WHERE id=?");
    $paring->bind_param('i',$_REQUEST['peida']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']); //aadressiriba puhastab päring ja jääb faili nimi
}
//kustutamine
if (isset($_GET["kustutusid"])) {
    $paring = $connect->prepare("DELETE FROM valimised WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustutusid"]);
    $paring->execute();
    header("Location: " . $_SERVER["PHP_SELF"]);
}
//lisamine andmetabelisse
if(isset($_REQUEST['presidentiNimi']) && !empty($_REQUEST['presidentiNimi'])){
    $paring=$connect->prepare("INSERT INTO valimised(president, pilt, lisamisaeg, avalik)
    VALUES(?,?,NOW(), ?)");
    $paring->bind_param('ssi',$_REQUEST['presidentiNimi'],$_REQUEST['pilt'],$_REQUEST['avalik']);
    $paring->execute();
    header("Location:".$_SERVER['PHP_SELF']);
    $connect->close();
}
//kustutamine kom
if(isset($_REQUEST['kustuta_komment_id'])){
    $paring=$connect->prepare("
Update valimised SET kommentaarid=' ' WHERE id=?");
    $paring->bind_param('i', $_REQUEST['kustuta_komment_id']);;
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
        <th>Punktid nullida</th>
        <th>Kommentaarid</th>
        <th>Kustuta kommentaarid</th>
        <th>Haldus </th>
        <th>Staatus</th>
        <th>Kustuta</th>
    </tr>
    <?php
    global $connect;
    $paring=$connect->prepare("Select id, president, pilt, punktid, lisamisaeg, avalik, kommentaarid from valimised");
    $paring->bind_result($id,$president, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$president."</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td><a href='?nullpunkt=$id'>Punktid nuulida</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td><a href='?kustuta_komment_id=$id'>Kustuta kommentarid</a></td>";
        $tekst="Näita";
        $seisund="naita";
        $tekstLehel="Peidetud";
        if($avalik==1){
        $tekstLehel='Näidatud';
        $seisund='peida';
        $tekst='Peida';
        }
        echo "<td><a href='?$seisund=$id'>$tekst</a></td>";
        echo "<td>$tekstLehel</td>";
        echo "<td><a href='?kustutusid=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    /*ADMIN:
    1.delete presidenti kandidaadi+
    2.punktid nulliks +
    3.ei saa +/-1 punkt +
    4.admin kohe saab lisada avalikuse staatus+
    */
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
    <label for="avalik">Staatus: </label>

<select name='avalik' id='avalik'>
<option value=''></option>
<option value='1'>Avalik</option>
<option value='0'>Peidetud</option>
</select>

    <br><br>
    <input type="submit" value="Lisa">
</form>
</body>
</html>
