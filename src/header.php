<?php
require_once __DIR__ . '/lib.php';
$mysqliHeader = connectDatabase();
$testEnabled = isTestEnabled($mysqliHeader);
if ($mysqliHeader) {
  $mysqliHeader->close();
}
?>

<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5>Inicio</h5>
                <a href="index.php" class="btn btn-primary">Ver</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5>Presentación</h5>
                <a href="presentacion.php" class="btn btn-primary">Ver</a>
            </div>
        </div>
    </div>

      <div class="col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5>Transformador</h5>
                <a href="transformador.php" class="btn btn-primary">Ver</a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card h-100 <?= $testEnabled ? 'border-success' : 'border-secondary' ?>">
            <div class="card-body">
                <h5>Test</h5>
                        <?php if ($testEnabled): ?>
                            <a href="test.php" class="btn btn-success">Ver</a>
                        <?php else: ?>
                            <p class="text-muted small mb-2">Disponible al terminar la presentación.</p>
                            <button class="btn btn-secondary" disabled>Bloqueado</button>
                        <?php endif; ?>
            </div>
        </div>
    </div>
</div>