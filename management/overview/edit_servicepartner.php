<?php
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Daten aus dem Formular
    $sp_id = $_POST['sp_id'];
    $name = $_POST['name'];
    $tax_number = $_POST['tax_number'];
    $isInternal = isset($_POST['isInternal']) ? 1 : 0;

    // Servicepartner aktualisieren
    $sql = "UPDATE service_partners SET name=?, tax_number=?, isInternal=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $name, $tax_number, $isInternal, $sp_id);

    if ($stmt->execute()) {
        echo "Servicepartnerdaten wurden erfolgreich aktualisiert.";
    } else {
        echo "Fehler beim Aktualisieren der Servicepartnerdaten: " . $conn->error;
    }

    $stmt->close();
} else {
    // Servicepartnerdaten abrufen
    $sp_id = $_GET['id'];
    $sql = "SELECT id, name, tax_number, isInternal FROM service_partners WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sp_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $tax_number, $isInternal);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Servicepartnerdaten bearbeiten</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

<body>
    <h1>Servicepartnerdaten bearbeiten</h1>
    <form action="edit_servicepartner.php" method="POST">
        <input type="hidden" name="sp_id" value="<?php echo $id; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="tax_number">Steuernummer:</label>
        <input type="text" id="tax_number" name="tax_number" value="<?php echo $tax_number; ?>" required><br><br>

        <label for="isInternal">Intern:</label>
        <input type="checkbox" id="isInternal" name="isInternal" <?php echo $isInternal ? 'checked' : ''; ?>><br><br>

        <input type="submit" value="Aktualisieren">
    </form>
</body>

</html>