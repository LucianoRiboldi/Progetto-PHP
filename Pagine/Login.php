<?php
    if (isset($_POST["ID"])) $ID = $_POST["ID"]; else $ID = "";
    if (isset($_POST["password"])) $password = $_POST["password"]; else $password = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProgettoPHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contenitorepagina">
        <form action="" method="post">
            <table class="">
                <tr>
                    <td><label for="ID">ID Identificativo: </label></td>
                    <td><input type="number" name="ID" id="ID" value = "<?php echo $ID ?>" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
            </table>
            <input type="submit" value="Accedi">
        </form>
        <p>Non sei ancora registrato? <a href="registrazione.php">Clicca qui</a></p>
        <?php
            if (isset($_POST["ID"]) and isset($_POST["password"])) {
                require("../Data/connessione.php");

                $query = "SELECT ID, Password 
                            FROM utenti
                            WHERE ID='$ID'
                                AND Password='$password'";

                $ris = $conn->query($query) or die("<p>Query fallita! ".$conn->error."</p>");

                if ($ris->num_rows == 0) {
                    echo "<p>ID o password non trovati.</p>";
                    $conn->close();
                } else {
                    session_start();
                    $_SESSION["ID"] = $ID;

                    $conn->close();
					header("location: ../index.php");
                }
            }
        ?>
    </div>
</body>
</html>