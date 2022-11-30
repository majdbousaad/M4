<!--
- Praktikum DBWT. Autoren:
- Majd, Boussad, 3519015
- Nicolas, Harrje, 3518047
-->
<?php

session_start();
//Zeige Errors an
ini_set("display_errors", "on");
error_reporting(E_ALL);


$name = trim($_POST["Name"]); // trimming
$name = preg_replace('/[\x00-\x1F\x7F]/u', '', $name); // removing unsichtbare Chars

//Whitespaces entfernen
$email = trim($_POST["Email"]);

//Datenschutz
$ds = $_POST["ds"];
//Language
$lan = $_POST["lan"];


//Feld für Fehlermeldungen erzeugen
$_SESSION["msgs"] = [];


$fehler = false;

//Fehlermeldung für fehlenden Namen
if($name == ""){
    $_SESSION["msgs"][] = 'Dein Name ist leer';
    $fehler = true;

}

//Fehlermeldung für fehlendes Häckchen
if($ds == NULL){
    $_SESSION["msgs"][] = 'Bitte setze das Häckchen für den Datenschutz';
    $fehler = true;
}

//Fehlermeldung für ungültiges mail Format
$invalidEmail = false;
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["msgs"][] = 'Invalid email format';
    $fehler = true;
    $invalidEmail = true;
}


$domain = substr(strrchr($email, "@"), 1);
$dispose_domain = array();
/*
* fetching disposable emails from text file to array.
*/
$handle = fopen("dispose.txt", "r");
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $dispose_domain[$data[0]] = $data[0];
}
fclose($handle);
/*
* checking disposable email addresses which are stored in text file dispos1.txt
*/
if (in_array($domain, $dispose_domain) || str_contains($domain, "trashmail.")) {
    $fehler = true;
    if($invalidEmail)
        $_SESSION["msgs"][] = 'btw, Deine E-Mail Adresse ist trash';
    else
        $_SESSION["msgs"][] = 'Deine E-Mail Adresse ist trash';
}

$_SESSION["fehler"] = $fehler;
$_SESSION["name"] = $name;
$_SESSION["email"] = $email;
$_SESSION["ds"] = $ds;
$_SESSION["lan"] = $lan;
$_SESSION["erfolgreich"] = true;
if($fehler) {

    header("Location: ./emensa#kontakt");
    die(400);
}

//Newletter Anmeldungen in Database einfügen um Auszählung zu vereinfachen
$link=mysqli_connect("localhost", // Host der Datenbank
    "root",                 // Benutzername zur Anmeldung
    "root",    // Passwort
    "emensawerbeseite"      // Auswahl der Datenbanken (bzw. des Schemas)
// optional port der Datenbank
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

$sql ="INSERT INTO newsletter(name, email, sprache) VALUES('$name', '$email', '$lan')";

mysqli_query($link, $sql);





header("Location: ./emensa#kontakt");
