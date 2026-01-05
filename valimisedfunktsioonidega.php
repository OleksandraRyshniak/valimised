<?php
require ('funktsioonid.php');
//päringud funktsioonide otsimiseks failis funktsioonid.php
if(isset($_REQUEST['lisa1punkt'])){
    lisapunkt($_REQUEST['lisa1punkt']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['minus1punkt'])){
    kustutapunkt($_REQUEST['minus1punkt']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

//päring lisaPresident funktsiooni otsimiseks
if(!empty($_REQUEST['presidentiNimi'])){
    lisaPresident($_REQUEST['presidentiNimi'], $_REQUEST['pilt'], $_REQUEST['punktid']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['kustuta'])){
    kustutaPresident($_REQUEST['kustuta']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['kustutakom'])){
    kustutaKom($_REQUEST['kustutakom']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['nullpunkt'])){
    nullpunkt($_REQUEST['nullpunkt']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['naita'])){
    naita($_REQUEST['naita']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
if(isset($_REQUEST['peida'])){
    peida($_REQUEST['peida']);
    header("Location:". $_SERVER['PHP_SELF']);
    exit();
}
if (!empty($_REQUEST['uue_komment_id']) && !empty($_REQUEST['uus_kommentaar'])) {
    lisakom($_REQUEST['uue_komment_id'], $_REQUEST['uus_kommentaar']);
    header("Location: ".$_SERVER['PHP_SELF']);
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
        <th>-1 punkt</th>
        <th>Punktid nullida</th>
        <th>Kustuta</th>
        <th>Kommentaarid</th>
        <th>Kustuta kommentaarid</th>
        <th>Lisa kommentaarid</th>
        <th>Haldus </th>
        <th>Staatus</th>
    </tr>

    <?php
    naitaTabel();?>
</table>

<h2>Lisa oma presidendi</h2>
<form action="?" method="post">
    <label for="presidentiNimi">President nimi: </label>
    <input type="text" name="presidentiNimi" id="presidentiNimi">
    <br><br>
    <label for="pilt">President pilt: </label>
    <textarea name="pilt" id="pilt"></textarea>
    <br><br>
    <label for="punktid">Punktid: </label>
    <input type="number" name="punktid" id="punktid">
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

