<?php
$conn = new mysqli("localhost", "root", "", "foro");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    $stmt = $conn->prepare("INSERT INTO contactos (nombres, telefono, mensaje) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombres, $telefono, $mensaje);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Mensaje enviado'); window.history.back();</script>";
    } else {
        echo "<script>alert('❌ Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
