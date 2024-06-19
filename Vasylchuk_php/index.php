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

if($_SERVER["REQUEST_METHOD"]=='POST'){
    header("Location: " . $_SERVER['REQUEST_URI']);
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='index.css'/>
</head>
<body>
    <h1>ToDo</h1>
    <form name="todo_from" action="" method="post">
        <div>
            <label for="sprawa">Sprawa:</label>
            <input name="sprawa" id="sprawa" placeholder="Wpisz swoją sprawę..." value='<?='test'.rand(1,100)?>' required>
        </div>
        <label for="termin">Termin:</label>
        <input type="date" name="termin" value='<?=date('Y-m-d')?>' required>
        <input type="submit" value="Submit">
    </form>
    <ul>
        <?php
        foreach($sql as $todos){
        $last_id=$todos['id'];?>

        <li style='background-color:<?=date('Y-m-d') <= $todos['termin'] ? 'rgb(254,216,0)' : 'rgb(254,100,0)'?>'>
        <div>Co? <span><?=$todos['sprawa'] ?></span></div>
        <div>Kiedy? <span><?=$todos['termin'] ?></span></div>
        <div>Dodane: <span><?=$todos['czasdodawania'] ?></span></div>
        <form name='del_form' action='' method="post"><button onclick=document.getElementById("del_form").submit() value='<?=$last_id?>' name='del_id'>Usuń</button></form>
        </li>
        <?php
            };
        ?>
    </ul>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!isset($_POST['del_id'])){
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
        } else {
            echo "Błąd: " . $stmt->errorInfo()[2];
        }
        }else{
            header('Location: '.$_SERVER['REQUEST_URI']);
            $del_id = $_POST['del_id'];
            $sql_delete = "DELETE FROM `todo` WHERE id = :del_id";
            $del_stmt = $pdo->prepare($sql_delete);
            $del_stmt->bindParam(':del_id',$del_id);
            if($del_stmt->execute()){
                echo "Todo zostało usuniente.";
                
            }else{
                echo "Bląd: ".$stmt->errorInfo()[2];
            }
        }

    }
    ?>

</body>
</html>