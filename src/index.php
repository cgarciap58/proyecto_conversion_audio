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

<?php

// Estructura para el trabajo

// 1. index.php - Página HOME con nuestros nombres y una bienvenida
// 2. presentación.php - Página con explicaciones sobre formatos de audio
// 3. transformador.php - Página con transformador de audio
// 4. test.php - Página con formulario a modo de test, incluyendo preguntas sobre lo presentado y el uso del transformador


echo "Hola Mundo";
?>

<div class="row">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5>Presentación</h5>
        <a href="presentacion.php" class="btn btn-primary">Ver</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5>Transformador</h5>
        <a href="transformador.php" class="btn btn-primary">Ver</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5>Test</h5>
        <a href="test.php" class="btn btn-primary">Ver</a>
      </div>
    </div>
  </div>
</div>



<?php include 'footer.php'; ?>

</body>
</html>