<?php
    if(!isset($_SESSION['ID'])){
        header('location:Pagine/Login.php')
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProgettoPHP</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="contenitorepagina">
        <nav>
            <div class="logo"><a href="../index.html"><img src="../Immagini/logostirati.png"></a></div>
            <div class="titolo-centrale">BANCA DEGLI STIRATI</div>
            <div class="prova">
                <div class="provacontenitore"><a href="../index.html">HOME</a></div>
                <div class="provacontenitore"><a href="Profilo.html">PROFILO</a></div>
                <div class="provacontenitore"><a href="Trasferimenti.html">TRASFERIMENTI</a></div>
                <div class="provacontenitore"><a href="Bonifico.html" class="attiva">BONIFICO</a></div>
            </div>         
        </nav>
    </div>
</body>
</html>