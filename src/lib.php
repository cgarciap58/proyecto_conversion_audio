<?php

declare(strict_types=1);

function connectDatabase(): ?mysqli
{
    $databaseCandidates = array_values(array_unique(array_filter([
        getenv('MYSQL_DATABASE') ?: null,
        getenv('DB_NAME') ?: null,
        'lamp_db',
    ])));

    $usernameCandidates = array_values(array_unique(array_filter([
        getenv('MYSQL_USER') ?: null,
        getenv('DB_USER') ?: null,
        'lamp_user',
        'root',
    ])));

    $passwordCandidates = array_values(array_unique(array_filter([
        getenv('MYSQL_PASSWORD') ?: null,
        getenv('DB_PASSWORD') ?: null,
        getenv('MYSQL_ROOT_PASSWORD') ?: null,
        'lamp_password',
        '1234',
        '',
    ], static fn ($value): bool => $value !== null)));

    $hosts = [
        ['host' => getenv('DB_HOST') ?: 'mysql', 'port' => (int) (getenv('DB_PORT') ?: 3306)],
        ['host' => '127.0.0.1', 'port' => 13306],
        ['host' => 'localhost', 'port' => 13306],
        ['host' => '127.0.0.1', 'port' => 3306],
    ];

    mysqli_report(MYSQLI_REPORT_OFF);

    foreach ($hosts as $candidateHost) {
        foreach ($databaseCandidates as $database) {
            foreach ($usernameCandidates as $username) {
                foreach ($passwordCandidates as $password) {
                    $mysqli = @new mysqli(
                        $candidateHost['host'],
                        $username,
                        $password,
                        $database,
                        $candidateHost['port']
                    );

                    if (!$mysqli->connect_errno) {
                        $mysqli->set_charset('utf8mb4');
                        return $mysqli;
                    }
                }
            }
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
function toLowerUtf8Safe(string $text): string
{
    if (function_exists('mb_strtolower')) {
        return mb_strtolower($text, 'UTF-8');
    }

    return strtolower($text);
}