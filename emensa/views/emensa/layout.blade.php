<!DOCTYPE html>
<html lang="de">
<!--
- Praktikum DBWT. Autoren:
- Majd, Boussad, 3519015
- Nicolas, Harrje, 3518047
-->
<head>
    <meta charset="UTF-8">
    <title>@yield("title")</title>
    <link href="css/emensa.css" rel="stylesheet" />
</head>
<body style="margin-bottom: 900px">
<div class="frame border">


    <div class="grid-oben">
        <div class="grid-oben-element border logo">
            <img src="img/Logo_E-Mensa.PNG" alt="E-Mensa Logo" height="auto" width="100%">
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
            <img src="img/alte-mensa-bratquadrat_0.jpg" alt="Mense Blau">
        </div>

        <div class="grid-main-element" id="info">
            <div  class="border">
            @yield("info")
            </div>

        </div>
        <div class="grid-main-element" id="speisen">

            @yield("speisen")
        </div>

        <div class="grid-main-element" id="zahlen">
            @yield("zahlen")
        </div>
        <div class="grid-main-element" id="kontakt">
            @yield("kontakt")
        </div>
        <div class="grid-main-element" id="wichtig">
           @yield("wichtig")
        </div>

    </div>

    <h1 class="center">Wir freuen uns auf Ihren Besuch!</h1>

    <br>
    <br>

    <hr>
    <footer>
        @yield("footer")
    </footer>
</div>

</body>
</html>