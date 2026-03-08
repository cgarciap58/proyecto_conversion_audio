<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Presentacion</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">

<?php

declare(strict_types=1);

function connectDatabase(): ?mysqli
{
    $database = getenv('MYSQL_DATABASE') ?: 'lamp_db';
    $username = getenv('MYSQL_USER') ?: 'lamp_user';
    $password = getenv('MYSQL_PASSWORD') ?: 'lamp_password';

    $candidates = [
        ['host' => getenv('DB_HOST') ?: 'mysql', 'port' => (int) (getenv('DB_PORT') ?: 3306)],
        ['host' => '127.0.0.1', 'port' => 13306],
        ['host' => 'localhost', 'port' => 13306],
        ['host' => '127.0.0.1', 'port' => 3306],
    ];

    foreach ($candidates as $candidate) {
        mysqli_report(MYSQLI_REPORT_OFF);
        $mysqli = @new mysqli(
            $candidate['host'],
            $username,
            $password,
            $database,
            $candidate['port']
        );

        if (!$mysqli->connect_errno) {
            $mysqli->set_charset('utf8mb4');
            return $mysqli;
        }
    }

    return null;
}

function isTestEnabled(?mysqli $mysqli): bool
{
    if (!$mysqli) {
        return false;
    }

    $query = "SELECT setting_value FROM app_settings WHERE setting_key = 'test_enabled' LIMIT 1";
    $result = $mysqli->query($query);

    if (!$result) {
        return false;
    }

    $row = $result->fetch_assoc();
    return isset($row['setting_value']) && (int) $row['setting_value'] === 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unlock_test'])) {
    $providedPin = trim($_POST['admin_pin'] ?? '');

    if (!$mysqli) {
        $unlockError = 'No se pudo conectar con la base de datos para habilitar el test.';
    } elseif ($providedPin !== $adminPin) {
        $unlockError = 'PIN de profesor incorrecto.';
    } else {
        $stmt = $mysqli->prepare(
            "INSERT INTO app_settings (setting_key, setting_value)
             VALUES ('test_enabled', '1')
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = CURRENT_TIMESTAMP"
        );

        if ($stmt && $stmt->execute()) {
            $unlockMessage = 'Test habilitado. Los estudiantes ya pueden entrar en test.php.';
            $testEnabled = true;
        } else {
            $unlockError = 'No fue posible habilitar el test.';
        }


echo "Hola Mundo";

// Estructura para el trabajo

// 1. index.php - Página HOME con nuestros nombres y una bienvenida
// 2. presentación.php - Página con explicaciones sobre formatos de audio
// 3. transformador.php - Página con transformador de audio
// 4. test.php - Página con formulario a modo de test, incluyendo preguntas sobre lo presentado y el uso del transformador

?>

<?php include 'footer.php'; ?>
</body>
</html>