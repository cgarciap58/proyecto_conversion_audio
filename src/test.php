<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Test</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    
<?php include 'header.php'; ?>

<h2 class="mt-4">Test de conversión</h2>

<?php
$quizQuestion = null;
$dbError = null;
$feedback = null;

$mysqli = connectDatabase();


if (!$mysqli) {
    $dbError = 'No se pudo conectar a la base de datos para cargar la pregunta.';
} else {
    $mysqli->set_charset("utf8mb4");
    $slug = 'mercadona_aac_size';
    $stmt = $mysqli->prepare('SELECT question_text, expected_bytes, tolerance_bytes FROM quiz_questions WHERE slug = ? LIMIT 1');

    if ($stmt) {
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $quizQuestion = $result->fetch_assoc() ?: null;
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $quizQuestion) {
        $value = isset($_POST['answer_value']) ? (float)$_POST['answer_value'] : 0;
        $unit = isset($_POST['answer_unit']) ? $_POST['answer_unit'] : 'KB';

        $factor = $unit === 'MB' ? 1024 * 1024 : 1024;
        $userBytes = (int) round($value * $factor);

        $expectedBytes = (int) $quizQuestion['expected_bytes'];
        $toleranceBytes = isset($quizQuestion['tolerance_bytes']) ? (int) $quizQuestion['tolerance_bytes'] : 0;
        $difference = abs($userBytes - $expectedBytes);
        $isCorrect = $difference <= $toleranceBytes;

        $feedback = [
            'is_correct' => $isCorrect,
            'user_bytes' => $userBytes,
            'expected_bytes' => $expectedBytes,
            'difference' => $difference,
            'tolerance' => $toleranceBytes,
        ];
    }

    $mysqli->close();
}

function formatBytesHuman(int $bytes): string
{
    if ($bytes >= 1024 * 1024) {
        return number_format($bytes / (1024 * 1024), 2) . ' MB';
    }
    return number_format($bytes / 1024, 2) . ' KB';
}

function connectDatabase(): ?mysqli
{
    $database = getenv('MYSQL_DATABASE') ?: 'lamp_db';
    $username = getenv('MYSQL_USER') ?: 'lamp_user';
    $password = getenv('MYSQL_PASSWORD') ?: 'lamp_password';

    $candidates = [
        ['host' => getenv('DB_HOST') ?: 'mysql', 'port' => (int)(getenv('DB_PORT') ?: 3306)],
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
?>

<?php if ($dbError): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8') ?></div>
<?php elseif (!$quizQuestion): ?>
    <div class="alert alert-warning">No se encontró la pregunta del test en la base de datos.</div>
<?php else: ?>
    <div class="card mt-3">
        <div class="card-body">
            <p class="mb-2"><strong>Pregunta:</strong> <?= htmlspecialchars($quizQuestion['question_text'], ENT_QUOTES, 'UTF-8') ?></p>
            <p class="mb-3 text-muted">
                Pista visual: el tamaño oficial está en torno a
                <strong><?= htmlspecialchars(formatBytesHuman((int) $quizQuestion['expected_bytes']), ENT_QUOTES, 'UTF-8') ?></strong>.
            </p>

            <form method="POST" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="answer_value" class="form-label">Tu respuesta</label>
                    <input type="number" step="0.01" min="0" id="answer_value" name="answer_value" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="answer_unit" class="form-label">Unidad</label>
                    <select id="answer_unit" name="answer_unit" class="form-select">
                        <option value="KB">KB</option>
                        <option value="MB">MB</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Comprobar</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($feedback): ?>
        <div class="alert <?= $feedback['is_correct'] ? 'alert-success' : 'alert-danger' ?> mt-3">
            <?php if ($feedback['is_correct']): ?>
                ¡Correcto! Tu estimación está dentro del margen permitido.
            <?php else: ?>
                Incorrecto. Tu estimación no entra en el margen permitido.
            <?php endif; ?>
            <hr>
            <ul class="mb-0">
                <li>Tu respuesta (convertida internamente): <strong><?= (int) $feedback['user_bytes'] ?> bytes</strong></li>
                <li>Tamaño oficial: <strong><?= (int) $feedback['expected_bytes'] ?> bytes</strong></li>
                <li>Diferencia: <strong><?= (int) $feedback['difference'] ?> bytes</strong></li>
                <li>Tolerancia: <strong><?= (int) $feedback['tolerance'] ?> bytes</strong></li>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>


<?php include 'footer.php'; ?>
</body>
</html>