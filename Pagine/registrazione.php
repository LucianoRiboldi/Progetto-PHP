<?php
	if (isset($_POST["password"])) {$password = $_POST["password"];} else {$password = "";}
    if(isset($_POST["conferma"])) $conferma = $_POST["conferma"];  else $conferma = "";
    if(isset($_POST["nome"])) $nome = $_POST["nome"];  else $nome = "";
    if(isset($_POST["cognome"])) $cognome = $_POST["cognome"];  else $cognome = "";
    if(isset($_POST["email"])) $email = $_POST["email"];  else $email = "";
?>
<body>
    <div class="">
        <form action="" method="post">
            <table class="tab_input tab_registrazione">
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
                <tr>
                    <td><label for="conferma">Conferma password: </label></td>
                    <td><input type="password" name="conferma" id="conferma" required></td>
                </tr>
                <tr>
                    <td><label for="nome">Nome: </label></td>
                    <td><input type="text" name="nome" id="nome" <?php echo "value = '$nome'" ?> required></td>
                </tr>
                <tr>
                    <td><label for="cognome">Cognome: </label></td>
                    <td><input type="text" name="cognome" id="cognome" <?php echo "value = '$cognome'" ?> required></td>
                </tr>
                <tr>
                    <td><label for="email">Email: </label></td>
                    <td><input type="text" name="email" id="email" <?php echo "value = '$email'" ?> required></td>
                </tr>
            </table>
            <input type="submit" value="Invia">
        </form>

        <p>
            <?php
            if(isset($_POST["nome"]) and isset($_POST["password"]) and isset($_POST["cognome"]) and isset($_POST["email"])) {
                if ($_POST["nome"] == "" or $_POST["cognome"] == "" or $_POST["password"] == "" or $_POST["email"] == "") {
                    echo "i campi sovrastanti non possono essere vuoti!";
                } elseif ($_POST["password"] != $_POST["conferma"]){
                    echo "<p>Le password inserite non corrispondono</p>";
                } else {
                    require("../data/connessione.php");

                    $query = "SELECT Nome, Cognome, Email 
						    FROM utenti 
						    WHERE Nome='$nome'
                                AND Cognome='$cognome'
                                AND Email='$email'";

                    $ris = $conn->query($query) or die("<p>Query fallita!</p>");
                    if ($ris->num_rows > 0) {
                        echo "Impossibile creare l'account; è presente un omonimo che utilizza la sua stessa email. Riprovare con un indirizzo diverso";
                    } else {

                        $query = "INSERT INTO utenti (Nome, Password, Cognome, Email)
                                    VALUES ('$nome', '$password', '$cognome','$email')";
                        if ($conn->query($query) === true) {
                            
						    $conn->close();

                            echo "Registrazione effettuata con successo!<br>sarai ridirezionato alla home tra 10 secondi.";

                        } else {
                            echo "Non è stato possibile effettuare la registrazione per il seguente motivo: " . $conn->error;
                        }
                        require('../Data/connessione.php');
                        $query="SELECT ID
                                FROM utenti
                                WHERE Nome='$nome'
                                    AND Cognome='$cognome'
                                    AND Email='$email'";
                        $ris=$conn->query($query);
                        $riga=$ris->fetch_assoc();
                        $ID = $riga['ID'];
                        session_start();
                        $_SESSION['ID']=$ID;
                        $query2="INSERT INTO conticorrenti (IDUtente, Saldo)
                                    VALUES ('$ID', '0.00')";
                        if ($conn->query($query2) === true) {
                            
						    $conn->close();

                            echo "Creazione conto corrente avvenuta";

                        } else {
                            echo "Non è stato possibile creare il conto per il seguente motivo: " . $conn->error;
                        }
                        echo "IL TUO ID IDENTIFICATIVO DA UTILIZZARE PER GLI ACCESSI FUTURI: " ."$ID";
                        header('Refresh: 10; URL=../index.html');
                    }
                }
            }
            ?>
        </p>	
    </div>
</body>
</html