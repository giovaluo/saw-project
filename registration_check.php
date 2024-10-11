<?php
    $error = "";
    if (isset($_POST['submit'])) {
        if (
            empty($_POST["firstname"])
            || empty($_POST["lastname"])
            || empty($_POST["email"])
            || empty($_POST["pass"])
            || empty($_POST["confirm"])) {
            $error = "Attenzione! Inserisci tutti i campi obbligatori.";
        } else {
            $firstname = trim($_POST["firstname"]);
            $lastname = trim($_POST["lastname"]);
            $email = trim($_POST["email"]);
            $pass = trim($_POST["pass"]);
            $confirm = trim($_POST["confirm"]);
            $planet = isset($_POST["planet"]) ? trim($_POST["planet"]) : "Terra";

            $regex_first_last_name = "/^[A-Z][a-z]{1,8}$/";
            // $regex_first_last_name = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";

            // validazione della password conforme agli script di test
            $regex_password = "/^[0-9A-Za-z!@&%$*#]{1,12}$/";

            // validazione della password originale
            // deve contenere: 8-30 caratteri, almeno una maiuscola, una minuscola, un numero e un carattere speciale
            // $regex_password = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,30}$/";

            // validazione dell'input
            if (!preg_match($regex_first_last_name, $firstname)) {
                $error = "Nome non valido.";
            } else if (!preg_match($regex_first_last_name, $lastname)) {
                $error = "Cognome non valido.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Indirizzo email non valido.";
            } else if (!preg_match($regex_password, $pass)) {
                $error = "La password non è abbastanza sicura! Deve contenere: 8-30 caratteri, almeno una maiuscola, una minuscola, un numero e un carattere speciale";
            } else if ($pass != $confirm) {
                $error = "La conferma della password non è uguale alla password inserita.";
            } // se tutto va bene...
            else {
                include 'db/connect_to_db.php';
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $query = "INSERT INTO users(firstname, lastname, email, pass, planet) VALUES(?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($query);

                if (!$stmt) {
                    error_log("Prepare failed: " . $conn->error . " (" . $conn->errno . ")", 0, "../errors/errors.log");
                    exit("Something went wrong... try again later.");
                }

                if (!$stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_pass, $planet)) {
                    error_log("Binding parameters failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                    exit("Something went wrong... try again later.");
                }

                if (!$stmt->execute()) {
                    // 1062 - errore se email gia esiste nel database
                    if ($stmt->errno == 1062) {
                        $error = "An account associated to this email address already exists.";
                    } else {
                        error_log("Execute failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                        exit("Something went wrong... try again later.");
                    }
                } else if ($stmt->affected_rows == 0) {
                    $error = "Something went wrong... try again later";
                } else {
                    // creiamo il carrello associato all'user appena creato
                    $query = "INSERT INTO carts(userid, total) VALUES(?, ?)";
                    $total = 00.00;
                    $new_userid = $stmt->insert_id;

                    $stmt = $conn->prepare($query);

                    if (!$stmt) {
                        error_log("Prepare failed: " . $conn->error . " (" . $conn->errno . ")", 0, "../errors/errors.log");
                        exit("Something went wrong... try again later.");
                    }

                    if (!$stmt->bind_param("id", $new_userid, $total)) {
                        error_log("Binding parameters failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                        exit("Something went wrong... try again later.");
                    }

                    if (!$stmt->execute()) {
                        error_log("Execute failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                        exit("Something went wrong... try again later.");
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);

                    header("Location: login.php");
                }
            }
        }
    }
?>