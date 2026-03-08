<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Test</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --azul-oscuro:  #1e3a5f;
      --azul-medio:   #2563eb;
      --azul-claro:   #3b82f6;
      --fondo:        #f1f5f9;
      --gris-texto:   #334155;
      --gris-suave:   #64748b;
      --blanco:       #ffffff;
    }

    body {
      background-color: var(--fondo);
      font-family: 'Segoe UI', Roboto, sans-serif;
      color: var(--gris-texto);
      line-height: 1.6;
    }

    .tarjeta-custom {
      background: var(--blanco);
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.08);
      margin-bottom: 1rem;
    }

    .tarjeta-custom .card-body {
      padding: 1.4rem;
    }
  </style>

</head>

<body class="container">
    
<?php include 'header.php'; ?>

<div class="container mt-5 mb-5" style="max-width: 760px;">

  <header class="text-center mb-5">
    <h1 class="display-5 fw-bold" style="color: var(--azul-oscuro);">Test de Formatos de Audio</h1>
    <p style="color: var(--gris-suave);">Demuestra lo que has aprendido durante la presentación</p>
  </header>

<?php
require_once __DIR__ . '/lib.php';

$dbError = null;
$questions = [];
$feedback = null;
$firstPerfect = null;

function normalizeAnswer(string $value): string
{
    $value = trim($value);
    $value = toLowerUtf8Safe($value);
    $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

    return $value;
}

function hasTableColumn(mysqli $mysqli, string $table, string $column): bool
{
    $table = $mysqli->real_escape_string($table);
    $column = $mysqli->real_escape_string($column);
    $result = $mysqli->query("SHOW COLUMNS FROM `{$table}` LIKE '{$column}'");

    if (!$result) {
        return false;
    }

    $exists = $result->num_rows > 0;
    $result->close();

    return $exists;
}

function parseNumericMbValue(string $raw): ?float
{
    $value = trim($value);

    if ($value === '') {
        return null;
    }

    $value = preg_replace('/\bmb\b/ui', '', $value) ?? $value;
    $value = str_replace(',', '.', $value);
    $value = preg_replace('/[^\d\.-]+/u', '', $value) ?? $value;

    if ($value === '' || !is_numeric($value)) {
        return null;
    }

    return (float) $value;
}

function isNumericOpenQuestion(array $question): bool
{
    if (isset($question['expected_value']) && $question['expected_value'] !== null && trim((string) $question['expected_value']) !== '') {
        return true;
    }

    return parseNumericMbValue((string) ($question['correct_text'] ?? '')) !== null;
}

function isOpenTextAnswerCorrect(array $question, string $answer): bool
{
    if (!isNumericOpenQuestion($question)) {
        return normalizeAnswer($answer) !== ''
            && normalizeAnswer($answer) === normalizeAnswer((string) ($question['correct_text'] ?? ''));
    }

    $studentValue = parseNumericMbValue($answer);

    $expectedRaw = isset($question['expected_value']) && trim((string) $question['expected_value']) !== ''
        ? (string) $question['expected_value']
        : (string) ($question['correct_text'] ?? '');
    $expectedValue = parseNumericMbValue($expectedRaw);

    if ($studentValue === null || $expectedValue === null) {
        return false;
    }

    $toleranceRaw = isset($question['tolerance']) && trim((string) $question['tolerance']) !== ''
        ? (string) $question['tolerance']
        : '0.02';
    $tolerance = parseNumericMbValue($toleranceRaw) ?? 0.02;

    return abs($studentValue - $expectedValue) <= $tolerance;
}


$mysqli = connectDatabase();
$testEnabled = isTestEnabled($mysqli);

if (!$mysqli) {
    $dbError = 'No se pudo conectar a la base de datos para cargar la pregunta.';
}


if ($mysqli) {

    $optionalColumns = [];
    foreach (['expected_value', 'tolerance', 'unit'] as $column) {
        if (hasTableColumn($mysqli, 'test_questions', $column)) {
            $optionalColumns[] = $column;
        }
    }

    $selectColumns = [
        'id',
        'question_text',
        'question_type',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'correct_text',
    ];
    $selectColumns = array_merge($selectColumns, $optionalColumns);

    $result = $mysqli->query('SELECT ' . implode(', ', $selectColumns) . ' FROM test_questions ORDER BY id ASC');
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    } else {
        $dbError = 'Error al cargar las preguntas del test.';
    }

    if ($testEnabled && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz']) && !empty($questions)) {
            $studentName = trim($_POST['student_name'] ?? '');

        if ($studentName === '') {
            $feedback = ['type' => 'error', 'message' => 'Debes indicar el nombre del estudiante.'];
        } else {
            $correct = 0;
            $total = count($questions);

            $stmtCheck = $mysqli->prepare('SELECT correct_option FROM test_questions WHERE id = ? LIMIT 1');
            foreach ($questions as $question) {
                $fieldName = 'q_' . $question['id'];
                $answer = trim((string) ($_POST[$fieldName] ?? ''));

                if ($question['question_type'] === 'open_text') {
                    if (isOpenTextAnswerCorrect($question, $answer)) {
                    $correct++;
                    }
                    continue;
                }

                $answer = strtoupper($answer);
                $expected = $question['correct_option'];

                if ($answer === $expected) {
                    $correct++;
                }
            }

            $allCorrect = $correct === $total;

            $stmtAttempt = $mysqli->prepare('INSERT INTO test_attempts (student_name, correct_answers, total_questions, all_correct) VALUES (?, ?, ?, ?)');
            if ($stmtAttempt) {
                $allCorrectInt = $allCorrect ? 1 : 0;
                $stmtAttempt->bind_param('siii', $studentName, $correct, $total, $allCorrectInt);
                $stmtAttempt->execute();
                $stmtAttempt->close();
            }

            $feedback = [
                'type' => $allCorrect ? 'success' : 'warning',
                'message' => $allCorrect
                    ? "¡Perfecto, {$studentName}! Respondiste todo correctamente."
                    : "{$studentName}, acertaste {$correct} de {$total} preguntas.",
            ];
        }
    }

    $winnerQuery = $mysqli->query('SELECT student_name, created_at FROM test_attempts WHERE all_correct = 1 ORDER BY created_at ASC, id ASC LIMIT 1');
    if ($winnerQuery) {
        $firstPerfect = $winnerQuery->fetch_assoc() ?: null;
    }
}

if ($mysqli) {
    $mysqli->close();
}
?>

<?php if ($dbError): ?>
    <div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-2"></i><?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8') ?></div>

<?php elseif (empty($questions)): ?>
    <div class="alert alert-warning"><i class="fa-solid fa-triangle-exclamation me-2"></i>No hay preguntas configuradas en la base de datos.</div>
<?php else: ?>

    <?php if (!$testEnabled): ?>
        <div class="alert alert-info">
            <i class="fa-solid fa-lock me-2"></i>El test está bloqueado por el profesor mientras se realiza la presentación. Se muestran las preguntas, pero no se puede enviar el formulario.
        </div>
    <?php endif; ?>


    <?php if ($firstPerfect): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-trophy me-2"></i><strong>Primer estudiante con puntuación perfecta:</strong>
            <?= htmlspecialchars($firstPerfect['student_name'], ENT_QUOTES, 'UTF-8') ?>
            (<?= htmlspecialchars($firstPerfect['created_at'], ENT_QUOTES, 'UTF-8') ?>)
        </div>
    <?php else: ?>
        <div class="alert alert-secondary"><i class="fa-solid fa-hourglass me-2"></i>Aún no hay ningún estudiante con todas las respuestas correctas.</div>
    <?php endif; ?>

    <?php if ($feedback): ?>
    
        <div class="alert alert-<?= $feedback['type'] === 'success' ? 'success' : ($feedback['type'] === 'warning' ? 'warning' : 'danger') ?>">
            <i class="fa-solid fa-<?= $feedback['type'] === 'success' ? 'circle-check' : 'circle-exclamation' ?> me-2"></i>
            <?= htmlspecialchars($feedback['message'], ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="tarjeta-custom mb-4">
          <div class="card-body">
            <label for="student_name" class="form-label fw-semibold">
              <i class="fa-solid fa-user me-1" style="color:var(--azul-claro)"></i>Nombre del estudiante
            </label>
            <input type="text" id="student_name" name="student_name" class="form-control" required <?= $testEnabled ? '' : 'disabled' ?>>
          </div>
        </div>

        <?php foreach ($questions as $index => $question): ?>
            <div class="tarjeta-custom">
                <div class="card-body">
                    <p class="mb-2 fw-semibold" style="color:var(--azul-oscuro)">
                      <span style="color:var(--azul-medio)"><?= ($index + 1) ?>.</span>
                      <?= htmlspecialchars($question['question_text'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <?php if ($question['question_type'] === 'open_text'): ?>
                        <input
                            type="text"
                            class="form-control"
                            name="q_<?= (int) $question['id'] ?>"
                            id="q<?= (int) $question['id'] ?>"
                            required <?= $testEnabled ? '' : 'disabled' ?>
                        >
                    <?php else: ?>
                        <?php foreach (['a', 'b', 'c', 'd'] as $letter): ?>
                            <?php $field = 'option_' . $letter; ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q_<?= (int) $question['id'] ?>" id="q<?= (int) $question['id'] . $letter ?>" value="<?= strtoupper($letter) ?>" required <?= $testEnabled ? '' : 'disabled' ?>>
                                <label class="form-check-label" for="q<?= (int) $question['id'] . $letter ?>">
                                    <?= strtoupper($letter) ?>) <?= htmlspecialchars($question[$field], ENT_QUOTES, 'UTF-8') ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" name="submit_quiz" value="1" class="btn w-100 mt-2" style="background:var(--azul-medio); color:white; border:none; padding:0.6rem;" <?= $testEnabled ? '' : 'disabled' ?>>
          <i class="fa-solid fa-paper-plane me-2"></i>Enviar respuestas
        </button>
    </form>
<?php endif; ?>

</div>

<?php include 'footer.php'; ?>
</body>
</html>