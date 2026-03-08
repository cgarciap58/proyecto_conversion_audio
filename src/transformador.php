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

    $filename = basename($_FILES["audio"]["name"]);
    $tempPath = $_FILES["audio"]["tmp_name"];

    $inputPath = $uploadDir . $filename;

    move_uploaded_file($tempPath, $inputPath);

    $name = uniqid();
    $format = $_POST["format"];
    $outputFile = $outputDir . $name . "." . $format;

    $command = "ffmpeg -i $inputPath $outputFile 2>&1";

    shell_exec($command);

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