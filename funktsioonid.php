<?php
require ('config.php');
global $connect;

//+1 punkt
function lisapunkt($id){
    global $connect;
        $paring=$connect->prepare("Update valimised SET punktid=punktid+1 WHERE id=?");
        $paring->bind_param('i',$id);
        $paring->execute();
        $connect->close();
}

//-1 punkt
function kustutapunkt($id)
{
    global $connect;
    $paring=$connect->prepare("Update valimised SET punktid=punktid-1 WHERE id=?");
    $paring->bind_param('i',$id);
    $paring->execute();
    $connect->close();
}

function naitaTabel(){
    global $connect;
    $paring=$connect->prepare("Select id, president, pilt, punktid, lisamisaeg, kommentaarid, avalik  from valimised where avalik=1 or avalik=0");
    $paring->bind_result($id,$president, $pilt, $punktid, $lisamisaeg, $kommentaarid, $avalik);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>{$president}</td>";
        echo "<td>{$punktid}</td>";
        echo "<td><a href='?lisa1punkt={$id}'> +1 punkt</a></td>";
        echo "<td><a href='?minus1punkt={$id}'> -1 punkt</a></td>";
        echo "<td><a href='?nullpunkt={$id}'>Punktid nuulida</a></td>";
        echo "<td><a href='?kustuta={$id}'>Kustuta</a></td>";
        echo "<td>{$kommentaarid}</td>";
        echo "<td><a href='?kustutakom={$id}'>Kustuta kommentaarid</a></td>";
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
        echo "</tr>";
    }
}
//uue presidenti lisamine - INSERT
function lisaPresident($presidentiNimi, $pilt, $punktid){
    global $connect;
    $paring=$connect->prepare("INSERT INTO valimised(president, pilt, punktid,  lisamisaeg)
    VALUES(?,?,?,NOW())");
    $paring->bind_param('ssi',$presidentiNimi, $pilt, $punktid);
    $paring->execute();
    $connect->close();
}
//kustutamine
function kustutaPresident($id){
    global $connect;
    $paring = $connect->prepare("DELETE FROM valimised WHERE id=?");
    $paring->bind_param("i", $id);
    $paring->execute();
    $connect->close();
}

function kustutaKom($id){
    global $connect;
    $paring=$connect->prepare("
Update valimised SET kommentaarid=' ' WHERE id=?");
    $paring->bind_param('i', $id);;
    $paring->execute();
    $connect->close();
}

function nullpunkt($id){
    global $connect;
    $paring=$connect->prepare("Update valimised SET punktid=0 WHERE id=?");
    $paring->bind_param('i',$id);
    $paring->execute();
    $paring->close();
}

//Näitamine
function naita($id)
{
    global $connect;
    $paring=$connect->prepare("Update valimised SET avalik=1 WHERE id=?");
    $paring->bind_param('i',$id);
    $paring->execute();
    $paring->close();
}
//Peida
function peida($id){
    global $connect;
    $paring=$connect->prepare("Update valimised SET avalik=0 WHERE id=?");
    $paring->bind_param('i',$id);
    $paring->execute();
    $paring->close();
}