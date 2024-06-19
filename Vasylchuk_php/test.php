<?php
if (!isset($_GET['action']) || $_GET['action'] == '') {
    $id = 0;
} else {
    $id = $_GET['action'];
}

$db_user = "root";
$db_host = "localhost";
$db_pass = "";
$db = "todo";
$db_type = "mysql";
$db_encode = "utf8mb4";
$port = '3306';

$dsn = "$db_type:host=$db_host;dbname=$db;port=$port;charset=$db_encode;";

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sprawa = $_POST['sprawa'];
    $termin = $_POST['termin'];
    $czasdodawania = date("Y-m-d");

    if ($sprawa && $termin) {
        $sql_insert = "INSERT INTO todo (sprawa, czasdodawania, termin) VALUES (:sprawa, :czasdodawania, :termin)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt->bindParam(':sprawa', $sprawa);
        $stmt->bindParam(':czasdodawania', $czasdodawania);
        $stmt->bindParam(':termin', $termin);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "Błąd: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Wszystkie pola są wymagane!";
    }
}

$sql = $pdo->query("SELECT * FROM todo;");
$todos = $sql->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TODO List</title>
</head>
<body>

<form name="todo_form" action="" method="post">
    <label for="sprawa">Sprawa:</label>
    <input type="text" name="sprawa" id="sprawa" required>
    <br>
    <label for="termin">Termin:</label>
    <input type="date" name="termin" id="termin" required>
    <br>
    <input type="submit" value="Submit">
</form>

<p>
    <?php foreach ($todos as $todo) { ?>
        <div>
            <strong>Sprawa:</strong> <?= htmlspecialchars($todo['sprawa']) ?><br>
            <strong>Dodano:</strong> <?= htmlspecialchars($todo['czasdodawania']) ?><br>
            <strong>Termin:</strong> <?= htmlspecialchars($todo['termin']) ?><br>
        </div>
        <br>
    <?php } ?>
</p>

</body>
</html>
