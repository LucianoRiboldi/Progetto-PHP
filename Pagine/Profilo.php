<?php 
    require("controllo.php")
    $username = $_SESSION["ID"];
    require('../data/connessione_db.php');

	$strmodifica = "Modifica";
	$strconferma = "Conferma";

	$modifica = false;
	if (isset($_POST["pulsante_modifica"])) {
		if($_POST["pulsante_modifica"] == $strmodifica){
			$modifica = true;
		} else {
			$modifica = false;
		}

		if ($modifica == false){
			$sql = "UPDATE utenti
					SET Password = '".$_POST["password"]."', 
						Nome = '".$_POST["nome"]."', 
						Cognome = '".$_POST["cognome"]."', 
						Email = '".$_POST["email"]."', 
					WHERE ID = '".$username."'";
			if($conn->query($sql) === true) {
				//echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}
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
    <?php require("nav.php");?>
    <div class="contenitorepagina">
        <nav>
            <div class="logo"><a href="../index.html"><img src="../Immagini/logostirati.png"></a></div>
            <div class="titolo-centrale">BANCA DEGLI STIRATI</div>
            <div class="prova">
                <div class="provacontenitore"><a href="../index.html">HOME</a></div>
                <div class="provacontenitore"><a href="Profilo.php" class="attiva">PROFILO</a></div>
                <div class="provacontenitore"><a href="Trasferimenti.php">TRASFERIMENTI</a></div>
                <div class="provacontenitore"><a href="Bonifico.php">BONIFICO</a></div>
            </div>         
        </nav>
        <h1>Dati Personali</h1>
		<?php
			$sql = "SELECT ID, Password, Nome, Cognome, Email
				FROM utenti 
				WHERE ID='$username'";
			//echo $sql;
			$ris = $conn->query($sql) or die("<p>Query fallita!</p>");
			$row = $ris->fetch_assoc();
		?>
		<form action="" method="post">
			<table id="tab_dati_personali">
				<tr>
					<td>Username:</td> <td><input class="input_dati_personali" type="text" name="username" value="<?php echo $row["ID"]; ?>" disabled="disabled"></td>
				</tr>
				<tr>
					<td>Password:</td> <td><input class="input_dati_personali" type="text" name="password" value="<?php echo $row["Password"]; ?>" <?php if(!$modifica) echo "disabled='disabled'"?>></td>
				</tr>
				<tr>
					<td>Nome:</td> <td><input class="input_dati_personali" type="text" name="nome" value="<?php echo $row["Nome"]; ?>" <?php if(!$modifica) echo "disabled='disabled'"?>></td>
				</tr>
				<tr>
					<td>Cognome:</td> <td><input type="text" class="input_dati_personali" name="cognome" value="<?php echo $row["Cognome"]; ?>" <?php if(!$modifica) echo "disabled='disabled'"?>></td>
				</tr>
				<tr>
					<td>Email:</td> <td><input type="text" class="input_dati_personali" name="email" value="<?php echo $row["Email"]; ?>" <?php if(!$modifica) echo "disabled='disabled'"?>></td>
				</tr>
			</table>
			<p style="text-align: center">
				<input type="submit" name="pulsante_modifica" value="<?php if($modifica==false) echo $strmodifica; else echo $strconferma; ?>">
			</p>
		</form>
    </div>
    <?php 
		include('footer.php')
	?>
</body>
</html>