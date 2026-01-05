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

function naitaTabel(){
    global $connect;
    $paring=$connect->prepare("Select id, president, pilt, punktid, lisamisaeg, kommentaarid  from valimised where avalik=1");
    $paring->bind_result($id,$president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>{$president}</td>";
        echo "<td>{$punktid}</td>";
        echo "<td><a href='?lisa1punkt=$id'> +1 punkt</a></td>";
        echo "</tr>";
    }
}
