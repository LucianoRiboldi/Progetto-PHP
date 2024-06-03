<?php
    require("controllo.php");
    $IDm= $_SESSION['ID'];
    $ris="NULLA";
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProgettoPHP</title>
    <link rel="stylesheet" href="../style.css">
    <script>
        function onlyOne(checkbox) {
            var checkboxes = document.getElementsByName('beneficiario');
            checkboxes.forEach((item) => {
                if (item !== checkbox) item.checked = false;
            });
        }
    </script>
</head>
<body>
    <div class="contenitorepagina">
        <nav>
            <div class="logo"><a href="../index.html"><img src="../Immagini/logostirati.png"></a></div>
            <div class="titolo-centrale">BANCA DEGLI STIRATI</div>
            <div class="prova">
                <div class="provacontenitore"><a href="../index.php">HOME</a></div>
                <div class="provacontenitore"><a href="Profilo.php">PROFILO</a></div>
                <div class="provacontenitore"><a href="Trasferimenti.php">TRASFERIMENTI</a></div>
                <div class="provacontenitore"><a href="Bonifico.php" class="attiva">BONIFICO</a></div>
            </div>         
        </nav>
        <form method="post" action="">
            <table>
                <tr>
                    <td><label for="nome_ricerca">Nome:</label></td>
                    <td><input class="" type="text" name="nome_ricerca" id="" value="<?php echo isset($_POST['nome_ricerca']) ? $_POST['nome_ricerca'] : ''; ?>"></td>
                </tr>
                <tr>
                    <td><label for="cognome_ricerca">Cognome:</label></td>
                    <td><input class="" type="text" name="cognome_ricerca" id="" value="<?php echo isset($_POST['cognome_ricerca']) ? $_POST['cognome_ricerca'] : ''; ?>"></td>
                </tr>
                <tr>
					<td style="text-align: center; padding-top: 10px" colspan="2"><input type="submit" value="Cerca"/></td>
				</tr>
            </table>
            <?php
            if (isset($_POST["nome_ricerca"]) and isset($_POST["cognome_ricerca"])) {
                $nomeric = $_POST["nome_ricerca"];
                $cognomeric = $_POST["cognome_ricerca"];
                require("../Data/connessione.php");
                $query = "SELECT ID, Nome, Cognome
                           FROM utenti
                           WHERE Nome LIKE '%$nomeric%'
                               AND Cognome LIKE '%$cognomeric%'";
                $ris=$conn->query($query) or die("<p>Query fallita!</p>");
                $conn->close();
            }
        ?>
        </form>
        <form action="" method="post">
            <label for="beneficiario">Seleziona Beneficiario:</label>
                <?php
                    if($ris!="NULLA"){
                        foreach ($ris as $riga) {
                            $cognome=$riga["Cognome"];
                            $nome=$riga["Nome"];
                            $ID = $riga["ID"];
                            if($ID != $_SESSION["ID"]){
                            echo <<<EOD
                            <p><input type="checkbox" name="beneficiario" onclick="onlyOne(this)"/>."$cognome"."$nome"</p>
                            EOD;
                            }
                            
                        }
                    }
                    else{
                        require("../Data/connessione.php");                        
                        $query2 = "SELECT ID, Nome, Cognome
                                   FROM utenti";
                        $ris2=$conn->query($query2) or die("<p>Query fallita!</p>");
                        foreach ($ris2 as $riga) {
                            $cognome=$riga["Cognome"];
                            $nome=$riga["Nome"];
                            $ID = $riga["ID"];
                            if($ID != $_SESSION["ID"]){
                            echo <<<EOD
                            <p><input type="checkbox" name="beneficiario" value="$ID" onclick="onlyOne(this)"/>."$cognome"."$nome"</p>
                            EOD;
                            }                            
                        }
                    }
                ?>
            <br>
            <label for="importo">Importo:</label>
            <input type="number" id="importo" name="importo" step="0.01" required>
            <br>
            <input type="submit" value="Esegui Bonifico">
        </form>
        <?php
            require("../Data/connessione.php");
            $querym="SELECT conticorrenti.saldo
                      FROM utenti JOIN conticorrenti ON utenti.ID=conticorrenti.IDUtente
                      WHERE utenti.ID='$IDm'";
            $rism=$conn->query($querym) or die("<p>Query fallita!</p>");
            $contom=$rism->fetch_assoc()["saldo"];
            if(isset($_POST["importo"])and isset($_POST["beneficiario"])){
                $importo=$_POST["importo"];
                $ID=$_POST["beneficiario"];
                if($contom>=$importo){
                    $sqlm= "UPDATE conticorrenti
                            SET Saldo = Saldo - $importo
                            WHERE IDUtente = '$IDm'";
                    $sqld= "UPDATE conticorrenti
                            SET Saldo = Saldo + $importo
                            WHERE  IDUtente='$ID'";
                    $conn->query($sqlm);
                    $conn->query($sqld);
                    $ricavaid="SELECT NumeroConto
                                FROM conticorrenti
                                WHERE IDutente='$ID'";
                    $ricavaid2="SELECT NumeroConto
                             FROM conticorrenti
                            WHERE IDutente='$IDm'";
                    $mittenteq=$conn->query($ricavaid);
                    $destinatarioq=$conn->query($ricavaid2);
                    $mittentear=$mittenteq->fetch_assoc();
                    $destinatarioar=$destinatarioq->fetch_assoc();
                    $mittente=$mittentear["NumeroConto"];
                    $destinatario=$destinatarioar["NumeroConto"];
                    $conn->commit();
                    echo "Bonifico avvenuto con successo";
                    $querybonifico="INSERT INTO bonifici(IDContoDestinatario, IDContoMittente, SommaDenaro)
                                        VALUES    ('$mittente', '$destinatario', '$importo')";
                    $conn->query($querybonifico);
                }else{
                    echo "Sul tuo conto non sono presenti i fondi necessari a completare il bonifico";
                }
                $conn->close();
            }
        ?>
    </div>
</body>
</html>