<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Inicio</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6: libreria de iconos. Nos da iconos de marcas (Spotify, Apple, YouTube) -->
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

    section {
      padding: 50px 0;
      scroll-margin-top: 70px;
    }

    .navbar-custom {
      background-color: var(--azul-oscuro);
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .titulo-seccion {
      border-left: 6px solid var(--azul-medio);
      padding-left: 15px;
      font-weight: 700;
      color: var(--azul-oscuro);
      margin-bottom: 25px;
    }

    .tarjeta-custom {
      background: var(--blanco);
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      height: 100%;
    }

    .tarjeta-custom:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 20px -3px rgba(0,0,0,0.12);
    }

    .cabecera-azul {
      background: var(--azul-oscuro);
      color: white;
      padding: 12px 20px;
      border-radius: 12px 12px 0 0;
      font-weight: 600;
    }

    .border-mp3 { border-top: 5px solid #1e3a5f; }
    .border-wav { border-top: 5px solid #1d4ed8; }
    .border-aac { border-top: 5px solid #2563eb; }
    .border-ogg { border-top: 5px solid #3b82f6; }

    .caja-info {
      background-color: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 8px;
      padding: 0.9rem 1.2rem;
      color: var(--gris-texto);
      font-size: 0.95rem;
    }

    .table-container {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0,0,0,0.06);
    }

    .tarjeta-plataforma {
      background: var(--blanco);
      border: none;
      border-radius: 12px;
      padding: 1.4rem;
      text-align: center;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.08);
      height: 100%;
      transition: all 0.3s ease;
    }

    .tarjeta-plataforma:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px -3px rgba(0,0,0,0.1);
    }

    .icono-marca       { font-size: 2.4rem; display: block; margin-bottom: 0.5rem; }
    .icono-spotify     { color: #1DB954; }
    .icono-youtube     { color: #FF0000; }
    .icono-apple       { color: #555555; }
    .icono-tidal       { color: var(--azul-oscuro); }

    .caja-conclusion {
      background-color: var(--azul-oscuro);
      color: white;
      border-radius: 12px;
      padding: 1.4rem 1.8rem;
    }

    .caja-conclusion p {
      color: #cbd5e1;
      margin: 0;
    }

  </style>

</head>

<body class="container">

<?php include 'header.php'; ?>
    
<div class="container mt-5 mb-5" style="max-width: 680px;">

  <header class="text-center mb-5">
    <h1 class="display-5 fw-bold" style="color: var(--azul-oscuro);">Transformador de Audio</h1>
    <p style="color: var(--gris-suave);">Convierte tu archivo de audio al formato que necesites</p>
  </header>

  <div class="tarjeta-custom p-4 mb-4">

    <h2 class="titulo-seccion">
      <i class="fa-solid fa-sliders me-2"></i>Configuración
    </h2>

    <form method="POST" enctype="multipart/form-data">

      <div class="mb-4">
        <label class="form-label fw-semibold">
          <i class="fa-solid fa-upload me-1" style="color:var(--azul-claro)"></i>Archivo de audio
        </label>
        <input type="file" name="audio" class="form-control" required>
        <div class="form-text">Formatos aceptados: MP3, WAV, AAC, OGG. Tamaño máximo: 20 MB.</div>
      </div>

      <div class="mb-4">
        <label class="form-label fw-semibold">
          <i class="fa-solid fa-file-audio me-1" style="color:var(--azul-claro)"></i>Formato de salida
        </label>
        <select name="format" class="form-select">
          <option value="mp3">MP3 — Universal, compatible con todo</option>
          <option value="wav">WAV — Sin pérdida, máxima calidad</option>
          <option value="aac">AAC — Mejor calidad que MP3 a igual tamaño</option>
          <option value="ogg">OGG — Libre de patentes, código abierto</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary w-100" style="background:var(--azul-medio); border:none; padding: 0.6rem;">
        <i class="fa-solid fa-rotate me-2"></i>Convertir
      </button>

    </form>
  </div>

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