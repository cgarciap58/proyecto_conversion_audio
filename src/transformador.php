<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Inicio</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">

<?php include 'header.php'; ?>
    

<h2>Transformador de Audio</h2>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label class="form-label">Selecciona un archivo de audio</label>
    <input type="file" name="audio" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Formato de salida</label>
    <select name="format" class="form-select">
      <option value="mp3">MP3</option>
      <option value="wav">WAV</option>
      <option value="aac">AAC</option>
      <option value="ogg">OGG</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">Convertir</button>
</form>

<hr>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uploadDir = "uploads/";
    $outputDir = "converted/";

    // Allowed extensions
    $allowedExt = ["mp3", "wav", "ogg", "aac"];
    $maxSize_MB = 20;
    $maxSize = $maxSize_MB * 1024 * 1024; // De bytes a KB a MB

    $filename = basename($_FILES["audio"]["name"]);
    $tempPath = $_FILES["audio"]["tmp_name"];
    $fileSize = $_FILES["audio"]["size"];

    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    // Validación de extensión del archivo
    if (!in_array($ext, $allowedExt)) {
        echo "<div class='alert alert-danger'>Formato no permitido. Solo MP3, AAC, OGG o WAV.</div>";
        exit;
    }

    // Validación del tamaño del archivo
    if ($fileSize > $maxSize) {
        echo "<div class='alert alert-danger'>El archivo supera el límite de $maxSize_MB MB.</div>";
        exit;
    }

    // Validación de tipo de archivo (contenido real del archivo)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tempPath);
    finfo_close($finfo);

    $allowedMime = [
        "audio/mpeg",  // mp3
        "audio/wav",   // wav
        "audio/x-wav", // algunas variantes de wav
        "audio/ogg",   // ogg
        "audio/aac"    // aac
    ];

    if (!in_array($mime, $allowedMime)) {
        echo "<div class='alert alert-danger'>El archivo no es un audio válido. Ricardo, deja de hacer tonterías.</div>";
        exit;
    }

    // Se guarda el archivo subido con un nombre único
    $uniqueInput = uniqid() . "." . $ext;
    $inputPath = $uploadDir . $uniqueInput;

    move_uploaded_file($tempPath, $inputPath);

    // Se genera nombre de salida
    $name = uniqid();
    $format = $_POST["format"];
    $outputFile = $outputDir . $name . "." . $format;

    // Se lanza ffmpeg
    $command = "ffmpeg -i " . escapeshellarg($inputPath) . " " . escapeshellarg($outputFile) . " 2>&1";
    shell_exec($command);

    // Output de resultado de la conversión
    if (file_exists($outputFile)) {
        echo "<div class='alert alert-success'>";
        echo "Archivo convertido correctamente.<br><br>";
        echo "<a class='btn btn-success' href='$outputFile' download>Descargar archivo</a>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger'>Error en la conversión.</div>";
    }
}
?>

<?php include 'footer.php'; ?>
</body>
</html>