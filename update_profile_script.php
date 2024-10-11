<?php
$error = "";

if (isset($_POST['submit'])) {
    if (!empty($_POST["firstname"])) {
        $firstname = trim($_POST["firstname"]);
    } else {
        $firstname = $_SESSION["firstname"];
    }

    if (!empty($_POST["lastname"])) {
        $lastname = trim($_POST["lastname"]);
    } else {
        $lastname = $_SESSION["lastname"];
    }

    if (!empty($_POST["email"])) {
        $email = trim($_POST["email"]);
    } else {
        $email = $_SESSION["email"];
    }

    if (isset($_POST["planet"]) && !empty($_POST["planet"])) {
        $planet = trim($_POST["planet"]);
    } else {
        $planet = $_SESSION["planet"];
    }

    $regex_first_last_name = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
    $regex_planet = "/^[A-Za-z0-9-]+$/";

    if (!preg_match($regex_first_last_name, $firstname)) {
        $error = "Invalid first name!";
    } else if (!preg_match($regex_first_last_name, $lastname)) {
        $error = "Invalid last name!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address!";
    } else if (!empty($planet) && !preg_match($regex_planet, $planet)) {
        $error = "Only citizens of the Milky Way are allowed!";
    }// se tutto va bene, aggiorniamo le informazioni
    else {
        include 'db/connect_to_db.php';
        // controllo se è stato inserito un pianeta
        if (!empty($planet)) {
            $query = "UPDATE users SET firstname=?, lastname=?, email=?, planet=? WHERE userid=?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error . " (" . $conn->errno . ")", 0, "../errors/errors.log");
                exit("Something went wrong... try again later.");
            }

            if (!$stmt->bind_param("ssssi", $firstname, $lastname, $email, $planet, $_SESSION["id"])) {
                error_log("Binding parameters failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                exit("Something went wrong... try again later.");
            }
        } else {
            $query = "UPDATE users SET firstname=?, lastname=?, email=? WHERE userid=?";
            $stmt = $conn->prepare($query);

            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error . " (" . $conn->errno . ")", 0, "../errors/errors.log");
                exit("Something went wrong... try again later.");
            }

            if (!$stmt->bind_param("sssi", $firstname, $lastname, $email, $_SESSION["id"])) {
                error_log("Binding parameters failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                exit("Something went wrong... try again later.");
            }
        }

        if (!$stmt->execute()) {
            if ($stmt->errno == 1062) {
                // 1062 - Checking that email is not already registered within the db.
                $error = "An account associated to this email address already exists.";
            } else {
                error_log("Execute failed: " . $stmt->error . " (" . $stmt->errno . ")", 0, "errors/errors.log");
                exit("Something went wrong... try again later.");
            }
        } else if ($stmt->affected_rows == 0) {
            $error = "Something went wrong... try again later";
        } else {
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $email;
            if (!empty($planet)) {
                $_SESSION['planet'] = $planet;
            }
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: show_profile.php");
        }
    }
}
?>
