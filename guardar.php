<?php
// Conexión
$host = "localhost";
$usuario = "root";
$contrasena = "";
$basedatos = "foro";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Variables
$id = "";
$nombres = "";
$telefono = "";
$mensaje = "";
$modo = "crear";

// Editar
if (isset($_GET['editar'])) {
    $modo = "editar";
    $id = $_GET['editar'];
    $resultado = $conn->query("SELECT * FROM contactos WHERE id = $id");
    $fila = $resultado->fetch_assoc();
    $nombres = $fila['nombres'];
    $telefono = $fila['telefono'];
    $mensaje = $fila['mensaje'];
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM contactos WHERE id = $id");
    echo "<script>alert('Registro eliminado'); window.location='guardar.php';</script>";
}

// Guardar o actualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombres = $_POST['nombres'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];

    if (!empty($_POST['id'])) {
        // Modo editar
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE contactos SET nombres=?, telefono=?, mensaje=? WHERE id=?");
        $stmt->bind_param("sssi", $nombres, $telefono, $mensaje, $id);
        $stmt->execute();
        echo "<script>alert('Registro actualizado'); window.location='guardar.php';</script>";
    } else {
        // Modo crear
        $stmt = $conn->prepare("INSERT INTO contactos (nombres, telefono, mensaje) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombres, $telefono, $mensaje);
        $stmt->execute();
        echo "<script>alert('✅ Registro guardado'); window.location='guardar.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="text-center mb-4"><?= $modo == 'editar' ? 'Editar Contacto' : 'REGISTROS' ?></h2>

    <form method="POST" class="bg-light p-4 rounded shadow">
        <?php if ($modo == 'editar'): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Nombres</label>
            <input type="text" name="nombres" class="form-control" required value="<?= $nombres ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="tel" name="telefono" class="form-control" required pattern="[0-9]{9}" value="<?= $telefono ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="4" required><?= $mensaje ?></textarea>
        </div>

        <button type="submit" class="btn btn-<?= $modo == 'editar' ? 'warning' : 'primary' ?>">
            <?= $modo == 'editar' ? 'Actualizar' : 'Guardar' ?>
        </button>
        <?php if ($modo == 'editar'): ?>
            <a href="guardar.php" class="btn btn-secondary">Cancelar</a>
        <?php endif; ?>
    </form>

    <hr class="my-5">

    <h3 class="mb-3">Lista de Contactos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Nombres</th><th>Teléfono</th><th>Mensaje</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $resultado = $conn->query("SELECT * FROM contactos");
            while ($fila = $resultado->fetch_assoc()):
            ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= $fila['nombres'] ?></td>
                    <td><?= $fila['telefono'] ?></td>
                    <td><?= $fila['mensaje'] ?></td>
                    <td>
                        <a href="?editar=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?eliminar=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este contacto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>

<?php $conn->close(); ?>

