<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Activar test</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
<?php include 'header.php'; ?>

<?php
require_once __DIR__ . '/lib.php';

$feedback = null;
$mysqli = connectDatabase();
$expectedPin = getenv('TEST_ADMIN_PIN') ?: '1234';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $providedPin = trim($_POST['admin_pin'] ?? '');

    if ($providedPin === '') {
        $feedback = ['type' => 'danger', 'message' => 'Debes introducir la contraseña/PIN.'];
    } elseif (!$mysqli) {
        $feedback = ['type' => 'danger', 'message' => 'No se pudo conectar con la base de datos.'];
    } elseif ($providedPin !== $expectedPin) {
        $feedback = ['type' => 'danger', 'message' => 'Contraseña/PIN incorrecto.'];
    } else {
        $sql = "INSERT INTO app_settings (setting_key, setting_value) VALUES ('test_enabled','1') ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value), updated_at=CURRENT_TIMESTAMP";

        if ($mysqli->query($sql)) {
            $feedback = ['type' => 'success', 'message' => 'Test habilitado correctamente.'];
        } else {
            $feedback = ['type' => 'danger', 'message' => 'No se pudo habilitar el test.'];
        }
    }
}

if ($mysqli) {
    $mysqli->close();
}
?>

<h2 class="mt-4">Activar test</h2>
<p class="text-muted">Introduce la contraseña/PIN del profesor para desbloquear el test para la clase.</p>

<?php if ($feedback): ?>
  <div class="alert alert-<?= htmlspecialchars($feedback['type'], ENT_QUOTES, 'UTF-8') ?>">
    <?= htmlspecialchars($feedback['message'], ENT_QUOTES, 'UTF-8') ?>
  </div>
<?php endif; ?>

<form method="POST" class="mt-3" autocomplete="off">
  <div class="mb-3 col-md-4">
    <label for="admin_pin" class="form-label">Contraseña/PIN del profesor</label>
    <input id="admin_pin" name="admin_pin" type="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-success">Activar test</button>
</form>

<?php include 'footer.php'; ?>
</body>
</html>