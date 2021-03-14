<?php
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=mysql-server; dbname=reservations", "user_db", "abcd");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $timeslotId = filter_input(INPUT_POST, 'timeslot_id', FILTER_VALIDATE_INT);
        $courtId = filter_input(INPUT_POST, 'court_id', FILTER_VALIDATE_INT);

        if (empty($name)) {
            $errors[] = "The name is mandatory";
        }

        // we get the date directly
        $dirtyDate = $_POST['date'];
        // we try to convert dirtDate into a DateTime object
        // if succeed we have a correct date.
        $date = DateTime::createFromFormat('Y-m-d', $dirtyDate);
        if (empty($date)) {
            $errors[] = "Please, select a date";
        }

        if (empty($timeslotId)) {
            $errors[] = "Please, select a timeslot";
        }
        if (empty($courtId)) {
            $errors[] = "Please, select a court";
        }

        if (empty($errors)) {
            $stmt = $pdo->prepare("INSERT INTO reservation (name,date,court_id,timeslot_id) 
                    VALUES (:name,:date,:court_id,:timeslot_id)");
            $stmt->bindValue('name', $name, PDO::PARAM_STR);
            $stmt->bindValue('date', $date->format("Y-m-d"), PDO::PARAM_STR);
            $stmt->bindValue('court_id', $courtId, PDO::PARAM_INT);
            $stmt->bindValue('timeslot_id', $timeslotId, PDO::PARAM_INT);
            $stmt->execute();
        }
    } catch (PDOException $PDOException) {
        die($PDOException->getMessage());
    } catch (Exception $exception) {
        die($exception->getMessage());
    }
} else
    die("cannot access with GET Method");


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear</title>

</head>
<body>
<h1>Reservation process result</h1>
<?php if (!empty($errors)): ?>
    <h2>Error!</h2>
    <p>There are some errors:</p>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <h2>Success</h2>
    <p>Your reservation has been saved successfully!</p>
    <a href="../index.php">Volver</a>
<?php endif; ?>
</body>
</html>
