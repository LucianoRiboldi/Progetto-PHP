<?php
    if (isset($_POST["username"])) {$username = $_POST["username"];} else {$username = "";}
	if (isset($_POST["password"])) {$password = $_POST["password"];} else {$password = "";}
    if(isset($_POST["conferma"])) $conferma = $_POST["conferma"];  else $conferma = "";
    if(isset($_POST["nome"])) $nome = $_POST["nome"];  else $nome = "";
    if(isset($_POST["cognome"])) $cognome = $_POST["cognome"];  else $cognome = "";
    if(isset($_POST["email"])) $email = $_POST["email"];  else $email = "";
    if(isset($_POST["telefono"])) $telefono = $_POST["telefono"];  else $telefono = "";
    if(isset($_POST["comune"])) $comune = $_POST["comune"];  else $comune = "";
    if(isset($_POST["indirizzo"])) $indirizzo = $_POST["indirizzo"];  else $indirizzo = "";

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Banca-Registrazione</title>
</head>
<body>
    <?php
        require("nav.php");
    ?>
    <div class="contenenitorepagina">
        <h1>Banca-Registrazione</h1>
        <div class="logo"><a href="../index.html"><img src="../Immagini/logostirati.png"></a></div>
            <div class="titolo-centrale">BANCA DEGLI STIRATI</div>
            <div class="prova">
                <div class="provacontenitore"><a href="../index.html">HOME</a></div>
                <div class="provacontenitore"><a href="Profilo.html">PROFILO</a></div>
                <div class="provacontenitore"><a href="Trasferimenti.html">TRASFERIMENTI</a></div>
                <div class="provacontenitore"><a href="Bonifico.html" class="attiva">BONIFICO</a></div>
        <form action="" method="post">
            <table class="tab_input tab_registrazione">
                <tr>
                    <td><label for="username">Username: </label></td>
                    <td><input type="text" name="username" id="username" value="<?php echo $username ?>" required></td>
                    
                </tr>
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

                    $query = "SELECT nome, cognome, email 
						    FROM utenti 
						    WHERE nome='$username'
                                AND cognome='$cognome'
                                AND email='$email'";

                    $ris = $conn->query($query) or die("<p>Query fallita!</p>");
                    if ($ris->num_rows > 0) {
                        echo "Impossibile creare l'account; è presente un omonimo che utilizza la sua stessa email. Riprovare con un indirizzo diverso";
                    } else {

                        $query = "INSERT INTO utenti (nome, password, cognome, email)
                                    VALUES ('$nome', '$password', '$cognome','$email')";

                        if ($conn->query($query) === true) {
                            session_start();
                            $_SESSION["ID"]=$ID;
                            
						    $conn->close();

                            echo "Registrazione effettuata con successo!<br>sarai ridirezionato alla home tra 5 secondi.";
                            header('Refresh: 5; URL=home.php');

                        } else {
                            echo "Non è stato possibile effettuare la registrazione per il seguente motivo: " . $conn->error;
                        }
                    }
                }
            }
            ?>
        </p>
        <?php 
            require('footer.php');
        ?>	
    </div>
</body>
</html>
