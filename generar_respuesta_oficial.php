<!-- <?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Este script debe ejecutarse en CLI.\n");
    exit(1);
}

$projectRoot = dirname(__DIR__);
$inputFile = $projectRoot . '/mercadona.wav';
$outputDir = $projectRoot . '/tmp';
$outputFile = $outputDir . '/mercadona_aac_oficial.aac';

if (!file_exists($inputFile)) {
    fwrite(STDERR, "No se encontró el archivo de entrada: {$inputFile}\n");
    exit(1);
}

if (!is_dir($outputDir) && !mkdir($outputDir, 0775, true) && !is_dir($outputDir)) {
    fwrite(STDERR, "No se pudo crear el directorio temporal: {$outputDir}\n");
    exit(1);
}

$command = sprintf(
    'ffmpeg -y -i %s -vn -c:a aac -b:a 128k %s 2>&1',
    escapeshellarg($inputFile),
    escapeshellarg($outputFile)
);

exec($command, $ffmpegOutput, $ffmpegExitCode);

if ($ffmpegExitCode !== 0 || !file_exists($outputFile)) {
    fwrite(STDERR, "Error al convertir con FFmpeg.\n");
    fwrite(STDERR, implode("\n", $ffmpegOutput) . "\n");
    exit(1);
}

$expectedBytes = filesize($outputFile);
if ($expectedBytes === false) {
    fwrite(STDERR, "No se pudo obtener el tamaño del archivo convertido.\n");
    exit(1);
}

$mysqli = connectDatabase();

$slug = 'mercadona_aac_size';
$questionText = '¿Cuánto ocupa el archivo mercadona.wav convertido a AAC 128 kbps?';
$toleranceBytes = 1024;

$stmt = $mysqli->prepare(
    'INSERT INTO quiz_questions (slug, question_text, expected_bytes, tolerance_bytes)\n     VALUES (?, ?, ?, ?)\n     ON DUPLICATE KEY UPDATE\n       question_text = VALUES(question_text),\n       expected_bytes = VALUES(expected_bytes),\n       tolerance_bytes = VALUES(tolerance_bytes)'
);

if (!$stmt) {
    fwrite(STDERR, "Error preparando sentencia SQL: {$mysqli->error}\n");
    exit(1);
}

$stmt->bind_param('ssii', $slug, $questionText, $expectedBytes, $toleranceBytes);

if (!$stmt->execute()) {
    fwrite(STDERR, "Error ejecutando sentencia SQL: {$stmt->error}\n");
    exit(1);
}

$stmt->close();
$mysqli->close();

printf("Respuesta oficial guardada para '%s': %d bytes\n", $slug, $expectedBytes);

function connectDatabase(): mysqli
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

    fwrite(STDERR, "No se pudo conectar a MySQL con ninguna configuración conocida.\n");
    exit(1);
} -->
