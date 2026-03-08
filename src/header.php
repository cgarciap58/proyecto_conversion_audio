<?php
require_once __DIR__ . '/lib.php';
$mysqliHeader = connectDatabase();
$testEnabled = isTestEnabled($mysqliHeader);
if ($mysqliHeader) {
  $mysqliHeader->close();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color:#1e3a5f; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
  <div class="container">
    <span class="navbar-brand fw-bold">
      <i class="fa-solid fa-music me-2"></i>Formatos de Audio
    </span>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto gap-2">

        <li class="nav-item">
          <a href="presentacion.php" class="btn btn-sm btn-outline-light">
            <i class="fa-solid fa-file-audio me-1"></i>Presentación
          </a>
        </li>

        <li class="nav-item">
          <a href="transformador.php" class="btn btn-sm btn-outline-light">
            <i class="fa-solid fa-sliders me-1"></i>Transformador
          </a>
        </li>

        <li class="nav-item">
          <?php if ($testEnabled): ?>
            <a href="test.php" class="btn btn-sm btn-success">
              <i class="fa-solid fa-circle-check me-1"></i>Test
            </a>
          <?php else: ?>
            <button class="btn btn-sm btn-secondary" disabled title="Disponible al terminar la presentación">
              <i class="fa-solid fa-lock me-1"></i>Test
            </button>
          <?php endif; ?>
        </li>

      </ul>
    </div>
  </div>
</nav>