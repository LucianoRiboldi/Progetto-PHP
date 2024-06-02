<?php require("controllo.php") ?>
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
                <div class="provacontenitore"><a href="Profilo.php">PROFILO</a></div>
                <div class="provacontenitore"><a href="Trasferimenti.php">TRASFERIMENTI</a></div>
                <div class="provacontenitore"><a href="Bonifico.php" class="attiva">BONIFICO</a></div>
            </div>         
        </nav>
        <form method="post" action="">
			<table>
				<tr>
					<td><label for="nome">Nome:</label></td>
                    <td><input class="" type="text" name="nome" id="" value="<?php echo isset($_POST['nome_ricerca']) ? $_POST['nome_ricerca'] : ''; ?>"></td>
				</tr>
				<tr>
                    <td><label for="cognome">Cognome:</label></td>
                    <td><input class="" type="text" name="cognome" id="" value="<?php echo isset($_POST['cognome_ricerca']) ? $_POST['cognome_ricerca'] : ''; ?>"></td>
				</tr>
			</table>
		</form>
        <?php
            if (isset($_POST["nome_ricerca"]) and isset($_POST["cognome_ricerca"])) {
                $nomeric = $_POST["nome_ricerca"];
                $cognomeric = $_POST["cognome_ricerca"];
                require("../Data/connessione.php");
                $query = "SELECT ID, nome, cognome
                           FROM utenti
                           WHERE nome LIKE '%$nomeric%'
                               AND cognome LIKE '%$cognomeric%'";
                $ris=$conn->query($query) or die("<p>Query fallita!</p>");
                $conn->close();
            }
        ?>
        <form action="processa_bonifico.php" method="post">
            <label for="beneficiario">Seleziona Beneficiario:</label>
            <select id="beneficiario" name="beneficiario">
                <?php
                    foreach ($ris as $riga) {
                        echo "<option value='" . $riga["ID"] . "'>" . $riga["nome"] . " " . $riga["cognome"] . "</option>";
                        
                    }
                ?>
            </select>
            <br>
            <label for="importo">Importo:</label>
            <input type="number" id="importo" name="importo" step="0.01" required>
            <br>
            <input type="submit" value="Esegui Bonifico">
        </form>
        <?php
            session_start();
            require("../Data/connessione.php");
            $querym="SELECT conticorrenti.saldo
                      FROM utenti JOIN conticorrenti ON utenti.ID=conticorrenti.IDUtente
                      WHERE utenti.ID=$_SESSION['ID']";
            $rism=$conn->query($query) or die("<p>Query fallita!</p>");
            $contom=$rism->fetch_assoc();
            $importo=$_POST['importo']
            if($contom>=$importo){
                $sqlm= "UPDATE conticorrenti
                        SET Saldo = Saldo - $importo
                        WHERE IDUtente = $_SESSION['ID']";
                $sqld= "UPDATE conticorrenti
                        SET Saldo = Saldo + $importo
                        WHERE IDUTENTE = $_POST['ID']";
                $conn->query($sqlm);
                $conn->query($sqld);
                $conn->commit();
                echo "Bonifico avvenuto con successo";
            }else{
                echo "Sul tuo conto non sono presenti i fondi necessari a completare il bonifico";
            }
            $conn->close();
        ?>
    </div>
</body>
</html>