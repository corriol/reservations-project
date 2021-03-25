<?php

$errors = [];

if ($_SERVER["REQUEST_METHOD"]!=="POST") 
    die("Something wrong ocurred!");

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$name= filter_input(INPUT_POST, "name");

/* TODO: VALIDAR */

$pdo = new PDO("mysql:host=mysql-server;dbname=reservations;charset=utf8", "user_db", "abcd");
$pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("SELECT R.*, C.name as court,
 T.name as time 
 FROM reservation R 
    INNER JOIN court C
    ON C.id = R.court_id INNER JOIN timeslot T ON
        T.id = R.timeslot_id WHERE
        R.id=:id and R.name=:name");

$stmt->bindValue("id", $id, PDO::PARAM_INT);
$stmt->bindValue("name", $name, PDO::PARAM_STR);

$stmt->execute();

$stmt->setFetchMode(PDO::FETCH_ASSOC);

$reservation = $stmt->fetch();

if (empty($reservation)) {
    $errors[] = "There are errors processing your request";
} 

?>


<html>

<head></head>

<body>
<h1>Cancel reservation</h1>

<p>Do you really want to cancel this reservation?</p>
<?php if (empty($errors)): ?>
<ul>
    <li><?=$reservation["id"] ?></li>
    <li><?=$reservation["name"] ?></li>
    <li><?=$reservation["date"] ?></li>
    <li><?=$reservation["court"] ?></li>
    <li><?=$reservation["time"] ?></li>
</ul>

<form action="reservations-cancel-delete.php" method="post">
    <input type="hidden" name="id" value="<?=$reservation["id"]?>" />
    <input type="submit" name="userAnswer" value="yes" />
    <input type="submit" name="userAnswer" value="no" />
</form>

<?php else: ?>
<p>There were errors</p>
<ul>
<?php foreach ($errors as $error) :?>
<li><?=$error ?></li>
<?php endforeach; ?>
</ul>
<?php endif ?>

</body>
</html>
