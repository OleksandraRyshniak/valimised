<?php
require ('config.php');
global $connect;

//+1 punkt
function lisapunkt($id){
    global $connect;
        $paring=$connect->prepare("Update valimised SET punktid=punktid+1 WHERE id=?");
        $paring->bind_param('i',$_REQUEST['$id']);
        $paring->execute();
        $connect->close();
}
