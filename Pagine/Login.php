<?php
    if (isset($_POST["username"])) $username = $_POST["username"]; else $username = "";
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
                    <td><label for="username">Username: </label></td>
                    <td><input type="text" name="username" id="username" value = "<?php echo $username ?>" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password: </label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
            </table>
            <input type="submit" value="Accedi">
        </form>
        <?php
            if (isset($_POST["username"]) and isset($_POST["password"])) {
                require("data/connessione_db.php");

                $myquery = "SELECT username, password 
                            FROM utenti
                            WHERE username='$username'
                                AND password='$password'";

                $ris = $conn->query($myquery) or die("<p>Query fallita! ".$conn->error."</p>");

                if ($ris->num_rows == 0) {
                    echo "<p>Utente o password non trovati.</p>";
                    $conn->close();
                } else {
                    session_start();
                    $_SESSION["username"] = $username;

                    $conn->close();
					header("location: pagine/home.php");
                }
            }
        ?>
    </div>
</body>
</html>