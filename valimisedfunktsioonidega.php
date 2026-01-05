<?php
require ('funktsioonid.php');
//päringud funktsioonide otsimiseks failis funktsioonid.php
if(isset($_REQUEST['lisa1punkt'])){
    lisapunkt($_REQUEST['lisa1punkt']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html>
<header>
    <link rel="stylesheet" href="valmisedStyle.css">
</header>
<body>
<h1>
    Tabel valimised kirjutatud funktsioonide abil
</h1>
<table>
    <tr>
        <th>Nimi</th>
        <th>Punktid</th>
        <th>+1 punkt</th>
    </tr>

    <?php
    naitaTabel();?>
</table>
</body>

