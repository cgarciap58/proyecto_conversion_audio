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
require_once __DIR__ . '/lib.php';

$dbError = null;
$questions = [];
$feedback = null;
$firstPerfect = null;

$mysqli = connectDatabase();
$testEnabled = isTestEnabled($mysqli);

if (!$mysqli) {
    $dbError = 'No se pudo conectar a la base de datos para cargar la pregunta.';
}


if ($mysqli && $testEnabled) {
    $result = $mysqli->query('SELECT id, question_text, option_a, option_b, option_c, option_d FROM test_questions ORDER BY id ASC');
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz']) && !empty($questions)) {
        $studentName = trim($_POST['student_name'] ?? '');

        if ($studentName === '') {
            $feedback = ['type' => 'error', 'message' => 'Debes indicar el nombre del estudiante.'];
        } else {
            $correct = 0;
            $total = count($questions);

            $stmtCheck = $mysqli->prepare('SELECT correct_option FROM test_questions WHERE id = ? LIMIT 1');
            foreach ($questions as $question) {
                $fieldName = 'q_' . $question['id'];
                $answer = strtoupper(trim($_POST[$fieldName] ?? ''));

                if (!$stmtCheck) {
                    continue;
                }

                $id = (int) $question['id'];
                $stmtCheck->bind_param('i', $id);
                $stmtCheck->execute();
                $res = $stmtCheck->get_result();
                $correctRow = $res ? $res->fetch_assoc() : null;
                $expected = $correctRow ? strtoupper($correctRow['correct_option']) : '';

                if ($answer === $expected) {
                    $correct++;
                }
            }
            if ($stmtCheck) {
                $stmtCheck->close();
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

<h2 class="mt-4">Test de teoría y práctica del conversor</h2>

<?php if ($dbError): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8') ?></div>
<?php elseif (!$testEnabled): ?>
    <div class="alert alert-info">
        El test está bloqueado por el profesor mientras se realiza la presentación.
    </div>

<?php elseif (empty($questions)): ?>
    <div class="alert alert-warning">No hay preguntas configuradas en la base de datos.</div>
<?php else: ?>

    <?php if ($firstPerfect): ?>
        <div class="alert alert-success">
            <strong>Primer estudiante con puntuación perfecta:</strong>
            <?= htmlspecialchars($firstPerfect['student_name'], ENT_QUOTES, 'UTF-8') ?>
            (<?= htmlspecialchars($firstPerfect['created_at'], ENT_QUOTES, 'UTF-8') ?>)
        </div>
    <?php else: ?>
        <div class="alert alert-secondary">Aún no hay ningún estudiante con todas las respuestas correctas.</div>
    <?php endif; ?>

    <?php if ($feedback): ?>
    
        <div class="alert alert-<?= $feedback['type'] === 'success' ? 'success' : ($feedback['type'] === 'warning' ? 'warning' : 'danger') ?>">
            <?= htmlspecialchars($feedback['message'], ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="student_name" class="form-label">Nombre del estudiante</label>
            <input type="text" id="student_name" name="student_name" class="form-control" required>
        </div>

        <?php foreach ($questions as $index => $question): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="mb-2"><strong><?= ($index + 1) ?>.</strong> <?= htmlspecialchars($question['question_text'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php foreach (['a', 'b', 'c', 'd'] as $letter): ?>
                        <?php $field = 'option_' . $letter; ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="q_<?= (int) $question['id'] ?>" id="q<?= (int) $question['id'] . $letter ?>" value="<?= strtoupper($letter) ?>" required>
                            <label class="form-check-label" for="q<?= (int) $question['id'] . $letter ?>">
                                <?= strtoupper($letter) ?>) <?= htmlspecialchars($question[$field], ENT_QUOTES, 'UTF-8') ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" name="submit_quiz" value="1" class="btn btn-primary">Enviar respuestas</button>
    </form>
<?php endif; ?>

<?php include 'footer.php'; ?>
</body>
</html>