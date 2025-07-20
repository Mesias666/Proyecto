<?php
// 1. Conexión
$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "foro";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

// 2. Verifica conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// 3. Verifica envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';

    // 4. Prepara la consulta
    $stmt = $conn->prepare("INSERT INTO contactos (nombres, telefono, mensaje) VALUES (?, ?, ?)");

    if (!$stmt) {
        // Mostrar error de SQL si la preparación falla
        die("Error en prepare(): " . $conn->error);
    }

    // 5. Ejecuta
    $stmt->bind_param("sss", $nombres, $telefono, $mensaje);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('✅ Registro guardado correctamente');
            window.history.back();
        </script>
        ";
    } else {
        echo "
        <script>
            alert('❌ Error al guardar: " . $stmt->error . "');
            window.history.back();
        </script>
        ";
    }

    $stmt->close();
}

$conn->close();
?>