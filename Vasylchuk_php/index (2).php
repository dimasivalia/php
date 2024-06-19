<?php
$dsn = "mysql:host=localhost;dbname=mandaty;charset=utf8";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Получение данных из таблиц
$stmt_policjant = $conn->query("SELECT idp, nazwisko, imie FROM policjant");
$policjanci = $stmt_policjant->fetchAll(PDO::FETCH_ASSOC);

$stmt_sprawca = $conn->query("SELECT idspr, nazwisko, imie FROM sprawca");
$sprawcy = $stmt_sprawca->fetchAll(PDO::FETCH_ASSOC);

$stmt_taryfikator = $conn->query("SELECT idt, wykroczenie FROM taryfikator");
$wykroczenia = $stmt_taryfikator->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dodaj Wykroczenie</title>
</head>
<body>

    <form method="post" action="">
        <label for="policjant">Policjant:</label>
        <select name="policjant" id="policjant">
            <?php foreach ($policjanci as $policjant): ?>
                <option value="<?= $policjant['idp']; ?>"><?= $policjant['imie'] . ' ' . $policjant['nazwisko']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="sprawca">Sprawca:</label>
        <select name="sprawca" id="sprawca">
            <?php foreach ($sprawcy as $sprawca): ?>
                <option value="<?= $sprawca['idspr']; ?>"><?= $sprawca['imie'] . ' ' . $policjant['nazwisko'] ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="wykroczenie">Wykroczenie:</label>
        <select name="wykroczenie" id="wykroczenie">
            <?php foreach ($wykroczenia as $wykroczenie): ?>
                <option value="<?= $wykroczenie['idt']; ?>"><?= $wykroczenie['wykroczenie']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="dataw">Data Wykroczenia:</label>
        <input type="date" name="dataw" id="dataw"><br>

        <label for="kwotamandatu">Kwota Mandatu:</label>
        <input type="number" name="kwotamandatu" id="kwotamandatu"><br>

        <input type="submit" name="submit" value="Dodaj Wykroczenie">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idp = $_POST['policjant'];
        $idspr = $_POST['sprawca'];
        $idt = $_POST['wykroczenie'];
        $dataw = $_POST['dataw'];
        $kwotamandatu = $_POST['kwotamandatu'];

        $sql_insert = "INSERT INTO wykroczenia (idspr, idt, idp, dataw, kwotamandatu) VALUES (:idspr, :idt, :idp, :dataw, :kwotamandatu)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindParam(':idspr', $idspr);
        $stmt->bindParam(':idt', $idt);
        $stmt->bindParam(':idp', $idp);
        $stmt->bindParam(':dataw', $dataw);
        $stmt->bindParam(':kwotamandatu', $kwotamandatu);

        if ($stmt->execute()) {
            echo "Nowe wykroczenie zostało dodane pomyślnie.";
        } else {
            echo "Błąd: " . $stmt->errorInfo()[2];
        }
    }

    $conn = null;
    ?>
</body>
</html>