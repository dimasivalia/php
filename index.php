<?php
if(!isset($_GET['action']) || $_GET['action']==''){$id=0;}
else{
    $id=$_GET['action'];
}

$db_user = "root";
$db_host = "localhost";
$db_pass = "";
$db = "todo";
$db_type = "mysql";
$db_encode = "utf8mb4";
$port = '';

$dsn = "$db_type:host=$db_host;dbname=$db;port=$port;charset=$db_encode;";

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);

}
catch(PDOException $e){
    throw new PDOException($e->getMessage(), $e->getCode());
}

$sql = $pdo->query("SELECT * FROM todo;");

$ttodo = $sql->fetch();


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>

<form name="todo_from" action="" method="post">
    <label for="sprawa">Sprawa:</label>
    <input name="sprawa" id="sprawa" required>
    <br>
    <label for="termin">Termin:</label>
    <input type="date" name="termin"  required>
    <br>
    <input type="submit" value="Submit">
    </form>

    <p>
        <?php
        foreach($sql as $todos){
        $last_id=$todos['id'];?>
        <?=$todos['sprawa'] ?>
        <?=$todos['czasdodawania'] ?>
        <?=$todos['termin'] ?>
        <br/>
        <?php
            };
        ?>
    </p>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $last_id=$last_id+1;
        $sprawa = $_POST['sprawa'];
        $termin = $_POST['termin'];
        $czasdodawania = date("y.m.d");

        $sql_insert = "INSERT INTO todo (id, sprawa, czasdodawania, termin) VALUES (:last_id, :sprawa, :czasdodawania, :termin)";
        $stmt = $pdo->prepare($sql_insert);
        $stmt->bindParam(':last_id', $last_id);
        $stmt->bindParam(':sprawa', $sprawa);
        $stmt->bindParam(':czasdodawania', $czasdodawania);
        $stmt->bindParam(':termin', $termin);

        if ($stmt->execute()) {
            echo "Nowe todo zostało dodane";
            header("Location: " . $_SERVER['REQUEST_URI']);
        } else {
            echo "Błąd: " . $stmt->errorInfo()[2];
        }

    }
    ?>

</body>
</html>