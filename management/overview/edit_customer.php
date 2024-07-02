<?php
$title = "Management Dashboard";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Daten aus dem Formular
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $telephone_number = $_POST['telephone_number'];
    $isVip = isset($_POST['isVip']) ? 1 : 0;

    // Kunden aktualisieren
    $sql = "UPDATE customers SET name=?, telephone_number=?, isVip=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $name, $telephone_number, $isVip, $customer_id);

    if ($stmt->execute()) {
        echo "Kundendaten wurden erfolgreich aktualisiert.";
    } else {
        echo "Fehler beim Aktualisieren der Kundendaten: " . $conn->error;
    }

    $stmt->close();
} else {
    // Kundendaten abrufen
    $customer_id = $_GET['id'];
    $sql = "SELECT id, name, telephone_number, isVip FROM customers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $telephone_number, $isVip);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Kundendaten bearbeiten</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

<body>
    <h1>Kundendaten bearbeiten</h1>
    <form action="edit_customer.php" method="POST">
        <input type="hidden" name="customer_id" value="<?php echo $id; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="telephone_number">Telefonnummer:</label>
        <input type="text" id="telephone_number" name="telephone_number" value="<?php echo $telephone_number; ?>"
            required><br><br>

        <label for="isVip">VIP Status:</label>
        <input type="checkbox" id="isVip" name="isVip" <?php echo $isVip ? 'checked' : ''; ?>><br><br>

        <input type="submit" value="Aktualisieren">
    </form>
</body>

</html>