<?php
error_reporting(E_ERROR | E_PARSE);
session_start();

/* ########## Setting up Database connection #######  */
$link=mysqli_connect("localhost", // Host der Datenbank
    "root",                 // Benutzername zur Anmeldung
    "root",    // Passwort
    "emensawerbeseite"      // Auswahl der Datenbanken (bzw. des Schemas)
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

/*  update besucher nur wenn die nicht durch Anmeldung weitergeleitet wurden  */
if(!$_SESSION["erfolgreich"]) {
    $sql = "UPDATE besucher SET views=views+1";
    mysqli_query($link, $sql);
}

/* Die Anzahl von Besuchern kriegen */
$sql = "SELECT views FROM besucher";
$result = mysqli_query($link, $sql);
$AnzahlBesucher = mysqli_fetch_row($result)[0];

?>
<!DOCTYPE html>
<html lang="de">
<!--
- Praktikum DBWT. Autoren:
- Majd, Boussad, 3519015
- Nicolas, Harrje, 3518047
-->
<head>
    <meta charset="UTF-8">
    <title>E-Mensa</title>

    <style>
        *{
            font-family: cursive;
        }
        table {
            width: 100%;
        }
        td > sup{
            color:  red;
        }
        .grid-oben{
            display: grid;
            margin-top: 40px;
            padding-bottom: 10px;
            grid-gap: 5px;
            grid-template-columns: 15% 60%;
        }

        a{
            padding: 6px;

            color: #6bd3ec;
        }
        ul.nav{
            position: relative;
            top: 5px;
        }
        .border{
            border: 1px solid black;

        }
        div p{
           word-wrap: break-word;
            text-align: justify;
            margin: 5px;
            font-size: 13px;
        }

        .nav > li{
            display: inline-block;
            list-style-type: none;

        }
        .frame{
            padding: 5px;
            margin-left: auto;
            margin-right: auto;
            width: 90%;
        }
        .center{
            text-align: center;
        }

        .grid-main{
            display: grid;
            grid-gap: 20px;
            grid-template-rows: auto auto auto auto auto auto;
            justify-items: center;
            position: relative;
            right: 4.5%;


        }
        .grid-main-element{
            width: 60%;
        }

        #zahlen{
            display: grid;
            grid-template-columns: auto auto auto;

        }
        #zahlen > h1{
            grid-column: 1 / 4;
        }


        .logo > img{
            position: relative;
            top: 5px;
        }

        table, th, td {
            border: 1px solid gray;
            border-collapse: collapse;
        }
        #zahlen >h3{
            text-align: center;
        }

        form{
            position: relative;
        }
        label{
            position: absolute;
            bottom: 50px;
            color: gray;
        }
        #submit{
            position: absolute;
            right: 30px;
            width: auto;
            font-size: 15px;
            background-color: white;
            border-radius: 20px;
            text-align: left;
        }
        input:not(.check){
            width: 115px;
            margin-right: 10px;
        }
        select{
            width: 170px;

        }
        #wichtig>ul{
            margin-left: auto;
            margin-right: auto;
            width: 50%;

        }

        footer li{
            display: inline-block;
            padding: 10px;

        }
        footer ul{
            text-align: center;

        }

        footer > ul > li + li {
            border-left: 1px solid gray;
        }
        .grid-main-element > img {
            width: 100%;
            height: auto;
        }
        .error{

            color: #D8000C;

        }

    </style>
</head>
<body style="margin-bottom: 900px">
<div class="frame border">


    <div class="grid-oben">
        <div class="grid-oben-element border logo">
            <img src="Logo_E-Mensa.PNG" alt="E-Mensa Logo" height="auto" width="100%">
        </div>
        <div class="grid-oben-element border">
            <ul class="nav">
                <li> <a href="#info">Ankündigung</a></li>
                <li> <a href="#speisen">Speisen</a></li>
                <li> <a href="#zahlen">Zahlen</a></li>
                <li> <a href="#kontakt">Kontakt</a></li>
                <li> <a href="#wichtig">Wichtig für uns</a></li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="grid-main">
        <div class="grid-main-element">
            <img src="alte-mensa-bratquadrat_0.jpg" alt="Mense Blau">
        </div>

        <div class="grid-main-element" id="info">
            <h1>Bald gibt's Essen auch online ;)</h1>
            <div  class="border">
                <p>
                     Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur culpa cum deserunt dolorum ea eaque inventore possimus quisquam recusandae, tempore? Accusantium corporis et excepturi incidunt laboriosam, nemo nesciunt perspiciatis quaerat?
                </p>
            </div>

        </div>
        <div class="grid-main-element" id="speisen">
            <h1>Köstlichkeiten, die Sie erwarten</h1>
            <table class="border">
                <tr>
                    <th>Name</th>
                    <th>Preis intern</th>
                    <th>Preis extern</th>
                </tr>
                <?php
                // 5 Gerichte zufällig nehmen (orderby Rand())
                $sql = "SELECT name, 
                               preis_intern, 
                               preis_extern, 
                               group_concat(code) 
                                    from gericht
                             left join gericht_hat_allergen on gericht.id = gericht_hat_allergen.gericht_id
                         group by gericht.name ORDER BY RAND() limit 5";

                $result = mysqli_query($link, $sql);
                if (!$result) {
                    echo "Fehler während der Abfrage:  ", mysqli_error($link);
                    exit();
                }
                // Variable zur Speicherung der AllergenCodes
                $codes = "";

                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>";
                    for ($i = 0; $i < 3; $i++){
                        echo "<td>".$row[$i];

                        // $row[3] enhält die Codes für jedes Gericht als "code1,code2 ..."
                        // $codes soll am ende alle Codes enthalten als "code1,code2,code3..."
                        if($i == 0 && $row[3] != null) {
                            echo "<sup> (" . $row[3] . ")</sup>";
                            if($codes != "")
                                $codes .= ',';
                            $codes .= $row[3];
                        }
                        echo"<br>";


                        echo "</td>";
                    }
                    echo "</tr>";

                }
                ?>
            </table>

            <?php

            // $codes soll im WHERE code in($codes) benutzt werden
            // deswegen sollen die Values in '' geschrieben werden

            // codes in '' schreiben
            $codes = explode(",", $codes);
            for ($i = 0; $i < count($codes); $i++)
                $codes[$i] = "'" . $codes[$i] . "'";

            // wieder als String sprichern
            $codes = implode(",", $codes);
            $sql = "SELECT code, name FROM allergen WHERE code IN ($codes)";

            $result = mysqli_query($link, $sql);
            if (!$result) {
                echo "Fehler während der Abfrage:  ", mysqli_error($link);
                exit();
            }
            echo " </br>
                <details>
                    <summary style='color: #D8000C'>Allergene</summary>
            ";
            echo "<ul>";
            //Abfrage ausgeben
            while ($row = mysqli_fetch_row($result)) {
                echo "<li>";
                foreach ($row as $field){
                    echo $field . " ";
                }
                echo "</li>";
            }
            echo "</ul></details>";
            ?>
        </div>
        <a href="wunschgericht.php">Dein Wunschgericht bei uns melden</a>
        <div class="grid-main-element" id="zahlen">
            <h1>E-Mensa in Zahlen</h1>
                <?php
                //Anzahl der gerichte und Newsletteranmeldungen abfragen
                $sql = "SELECT count(gericht.id) FROM gericht UNION SELECT count(newsletter.id) FROM newsletter";
                $result = mysqli_query($link, $sql);
                $AnzahlSpeisen = mysqli_fetch_row($result)[0];
                $AnzahlNewsLetter= mysqli_fetch_row($result)[0];
                ?>
            <h3><?= $AnzahlBesucher ?> Besuche</h3>

            <h3><?= $AnzahlNewsLetter ?> Anmeldungen zum Newsletter</h3>
            <h3><?= $AnzahlSpeisen ?> Speisen</h3>
        </div>
        <div class="grid-main-element" id="kontakt">
            <h1>Intersse geweckt? Wir informieren Sie!</h1>
            <br>
            <form method="post" action="newsletter.php">

                <label >Ihr Name:</label>
                <input type="text" placeholder="Vorname" name="Name" value="<?php echo $_SESSION["name"];?>">
                <label>Ihr Email:</label>
                <input type="text" name="Email" value="<?php echo $_SESSION["email"];?>">
                <label>Newsletter bitte in:</label>
                <select name="lan" >
                    <option value="D" <?php if($_SESSION["lan"] == "D")echo "selected";?>>
                        Deutsch
                    </option>
                    <option value="E" <?php if($_SESSION["lan"] == "E")echo "selected";?>>Englisch</option>
                </select>
                <br>

                <input class="check" type="checkbox" name="ds" <?php if($_SESSION["ds"] == "on")echo "checked";?> >
                Den Datenschutzbestimmungen stimme ich zu

                <input id="submit" type="submit" name="submit" value="Zum Newsletter anmleden">


            </form>

            <?php
                //Newsletter Fehlermeldungen anzeigen oder erfolgreiche speicherung zurückgeben
                if($_SESSION["fehler"]) {
                    echo "<p class='error'> Errors :</p>";
                    echo "<ul>";
                    foreach ($_SESSION["msgs"] as $msg) {
                        echo "<li class='error'>".$msg."</li>";
                    }
                    echo "</ul>";
                } else if($_SESSION["erfolgreich"]){
                    echo "<p style='color: green'> ".$_SESSION["name"].", Deine Daten wurden erfolgeich gespeichert!</p>";
                }
            ?>
        </div>
        <div class="grid-main-element" id="wichtig">
            <h1>Das ist uns wichtig</h1>
            <ul>
                <li>Beste frische Saisonale Zutaten</li>
                <li>Ausgewagene abweckslungsreiche Gerichte</li>
                <li>Sauberkeit</li>
                <li>Freundlichkeit gegenüber den Mitarbeitern</li>
            </ul>
            <br>
            <br>
        </div>

    </div>

    <h1 class="center">Wir freuen uns auf Ihren Besuch!</h1>

    <br>
    <br>

    <hr>
    <footer>
        <ul>
            <li>(c) E-Mensa GmbH</li>
            <li>Majd Bousaad & Nicolas Harrje</li>
            <li style="color: #6bd3ec">Impressum</li>
        </ul>
    </footer>
</div>

</body>
</html>
<?php session_unset();
mysqli_free_result($result);
mysqli_close($link);
?>