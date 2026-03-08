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

/**
 * Arregla que los caracteres especiales se muestren mal en la base de datos
 */
function normalizePotentialMojibake(string $text): string
{
    if ($text === '') {
        return $text;
    }

    if (!preg_match('/(?:Ã.|Â.)/u', $text)) {
        return $text;
    }

    $normalized = mb_convert_encoding($text, 'UTF-8', 'ISO-8859-1');

    return is_string($normalized) ? $normalized : $text;
}