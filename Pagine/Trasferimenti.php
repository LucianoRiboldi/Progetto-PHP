<?php
    require("controllo.php");
    $ID = $_SESSION['ID'];
    require("../Data/connessione.php");
    $query="SELECT utenti.Nome, utenti.Cognome, bonifici.SommaDenaro
            FROM bonifici JOIN conticorrenti ON bonifici.IDContoMittente=conticorrenti.NumeroConto
                          JOIN utenti ON conticorrenti.IDUtente=utenti.ID
            WHERE bonifici.IDContoDestinatario = '$ID'";
    $ris1=$conn->query($query) or die("<p>Query fallita!</p>");
    $query="SELECT utenti.Nome, utenti.Cognome, bonifici.SommaDenaro
            FROM bonifici JOIN conticorrenti ON bonifici.IDContoMittente=conticorrenti.NumeroConto
                          JOIN utenti ON conticorrenti.IDUtente=utenti.ID
            WHERE bonifici.IDContoMittente = '$ID'";
    $ris2=$conn->query($query) or die("<p>Query fallita!</p>");
    $conn->close();
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
            <div class="logo"><a href="../index.php"><img src="../Immagini/logostirati.png"></a></div>
            <div class="titolo-centrale">BANCA DEGLI STIRATI</div>
            <div class="prova">
                <div class="provacontenitore"><a href="../index.php">HOME</a></div>
                <div class="provacontenitore"><a href="Profilo.php">PROFILO</a></div>
                <div class="provacontenitore"><a href="Trasferimenti.php" class="attiva">TRASFERIMENTI</a></div>
                <div class="provacontenitore"><a href="Bonifico.php">BONIFICO</a></div>
            </div>         
        </nav>
        <h1>I Tuoi movimenti</h1>
        <h2>Ricevuti</h2>
        <table>
            <tr>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Denaro</th>
            </tr>
            <?php foreach ($ris1 as $riga): ?>
                <tr>
                    <td><?php echo htmlspecialchars($riga["Cognome"]); ?></td>
                    <td><?php echo $riga["Nome"]; ?></td>
                    <td><?php echo $riga["SommaDenaro"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Inviati</h2>
        <table>
            <tr>
                <th>Cognome</th>
                <th>Nome</th>
                <th>Denaro</th>
            </tr>
            <?php foreach ($ris1 as $riga): ?>
                <tr>
                    <td><?php echo $riga["Cognome"]; ?></td>
                    <td><?php echo $riga["Nome"]; ?></td>
                    <td><?php echo $riga["SommaDenaro"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>