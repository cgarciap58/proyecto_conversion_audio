<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Presentacion</title>

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

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
  <div class="container">
    <span class="navbar-brand fw-bold">
      <i class="fa-solid fa-headphones me-2"></i>Presentación
    </span>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#digitalizacion">Digitalización</a></li>
        <li class="nav-item"><a class="nav-link" href="#compresion">Compresión</a></li>
        <li class="nav-item"><a class="nav-link" href="#psicoacustica">Psicoacústica</a></li>
        <li class="nav-item"><a class="nav-link" href="#formatos">Formatos</a></li>
        <li class="nav-item"><a class="nav-link" href="#comparativa">Comparativa</a></li>
        <li class="nav-item"><a class="nav-link" href="#streaming">Streaming</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-5">

  <header class="text-center mb-5">
    <h1 class="display-4 fw-bold" style="color: var(--azul-oscuro);">Presentación Formatos de Audio</h1>
    <h4><strong>César García y Felipe Manosalva</strong></p></h4>
    <div class="d-flex justify-content-center gap-3 mt-3">
      <span class="badge bg-secondary">ASIR 2</span>
      <span class="badge" style="background:var(--azul-medio)">Servicios de Red e Internet</span>
      <span class="badge" style="background:var(--azul-oscuro)">Grupo 6</span>
    </div>
  </header>


  <!-- SECCIÓN 1: DIGITALIZACIÓN -->
  <section id="digitalizacion">
    <h2 class="titulo-seccion">
      <i class="fa-solid fa-microchip me-2"></i>1. Cómo se digitaliza el sonido
    </h2>

    <p>El sonido es una onda continua. Para almacenarlo en un ordenador hay que convertirlo a datos digitales. Este proceso se define por dos parámetros clave:</p>

    <div class="row g-4">

      <div class="col-md-6">
        <div class="tarjeta-custom p-4">
          <h4 style="color:var(--azul-medio)">
            <i class="fa-solid fa-wave-square me-2"></i>Frecuencia de muestreo
          </h4>
          <p>Número de veces por segundo que el ordenador registra el sonido. Según el <strong>Teorema de Nyquist</strong>, para reconstruir un sonido hay que muestrear al menos al doble de la frecuencia máxima que queremos captar.</p>
          <ul class="list-unstyled mt-3">
            <li class="mb-1">
              <i class="fa-solid fa-check-circle me-2" style="color:var(--azul-claro)"></i>
              <strong>44.100 Hz</strong> — Calidad CD estándar
            </li>
            <li class="mb-1">
              <i class="fa-solid fa-check-circle me-2" style="color:var(--azul-claro)"></i>
              <strong>48.000 Hz</strong> — Estándar en cine y TV
            </li>
            <li>
              <i class="fa-solid fa-check-circle me-2" style="color:var(--azul-claro)"></i>
              <strong>96.000 Hz</strong> — Estudio de grabación profesional
            </li>
          </ul>
          <div class="caja-info mt-3">
            Cuanto mayor la frecuencia, más fiel al original, pero mayor el tamaño del archivo.
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="tarjeta-custom p-4">
          <h4 style="color:var(--azul-medio)">
            <i class="fa-solid fa-layer-group me-2"></i>Profundidad de bits
          </h4>
          <p>Precisión con la que se guarda cada muestra. Define el <strong>rango dinámico</strong>, es decir, la diferencia entre el sonido más suave y el más fuerte. A mayor número de bits, menor es el ruido de cuantificación.</p>
          <ul class="list-unstyled mt-3">
            <li class="mb-1">
              <i class="fa-solid fa-check-circle me-2" style="color:var(--azul-claro)"></i>
              <strong>16 bits</strong> — 65.536 niveles, 96 dB de rango dinámico (CD)
            </li>
            <li>
              <i class="fa-solid fa-check-circle me-2" style="color:var(--azul-claro)"></i>
              <strong>24 bits</strong> — 16 millones de niveles (estudio profesional)
            </li>
          </ul>
          <div class="caja-info mt-3">
            <strong>Ejemplo práctico:</strong> 1 minuto WAV estéreo =
            44.100 &times; 2 canales &times; 2 bytes &times; 60s = <strong>~10 MB</strong>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- SECCIÓN 2: COMPRESIÓN -->
  <section id="compresion">
    <h2 class="titulo-seccion">
      <i class="fa-solid fa-compress me-2"></i>2. Tipos de compresión
    </h2>

    <div class="row g-4 text-center">

      <div class="col-md-6">
        <div class="tarjeta-custom border-top border-primary border-5">
          <div class="p-4">
            <i class="fa-solid fa-shield-halved fa-3x mb-3" style="color:var(--azul-medio)"></i>
            <h3 style="color:var(--azul-oscuro)">Sin pérdida (Lossless)</h3>
            <p>Conserva el <strong>100% de la información original</strong>. Al descomprimir se recupera el sonido exactamente igual. Funciona de forma similar a un ZIP de datos.</p>
            <p class="small" style="color:var(--gris-suave)">Imprescindible en producción musical y edición profesional. Los archivos son mucho más grandes.</p>
            <div class="mt-3">
              <span class="badge bg-dark me-1">WAV</span>
              <span class="badge bg-secondary me-1">FLAC</span>
              <span class="badge bg-secondary">AIFF</span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="tarjeta-custom border-top border-5" style="border-color:var(--azul-claro) !important">
          <div class="p-4">
            <i class="fa-solid fa-scissors fa-3x mb-3" style="color:var(--azul-claro)"></i>
            <h3 style="color:var(--azul-oscuro)">Con pérdida (Lossy)</h3>
            <p>Aprovecha la <strong>psicoacústica</strong> para eliminar datos que el cerebro no percibe. Reduce el tamaño del archivo drásticamente. La pérdida es <strong>irreversible</strong>.</p>
            <p class="small" style="color:var(--gris-suave)">Ideal para streaming y distribución masiva. A 128 kbps se elimina ~90% de los datos originales.</p>
            <div class="mt-3">
              <span class="badge me-1" style="background:var(--azul-oscuro)">MP3</span>
              <span class="badge me-1" style="background:var(--azul-medio)">AAC</span>
              <span class="badge" style="background:var(--azul-claro)">OGG</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- SECCIÓN 3: PSICOACÚSTICA -->
  <section id="psicoacustica">
    <h2 class="titulo-seccion">
      <i class="fa-solid fa-brain me-2"></i>3. Psicoacústica
    </h2>

    <div class="caja-info mb-4">
      <strong>Qué es:</strong> La psicoacústica estudia cómo el cerebro humano percibe el sonido.
      Los algoritmos de compresión con pérdida aprovechan sus limitaciones para eliminar datos
      que no vamos a escuchar de todas formas, reduciendo el tamaño sin que se note.
    </div>

    <div class="row g-4">

      <div class="col-md-4">
        <div class="tarjeta-custom p-4 text-center">
          <i class="fa-solid fa-ear-listen fa-2x mb-3" style="color:var(--azul-claro)"></i>
          <h6 class="fw-bold" style="color:var(--azul-oscuro)">Enmascaramiento de frecuencias</h6>
          <p class="small" style="color:var(--gris-suave)">Si suena algo muy fuerte, el oído no percibe sonidos suaves en frecuencias cercanas al mismo tiempo. El algoritmo detecta esto y elimina esos sonidos suaves.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="tarjeta-custom p-4 text-center">
          <i class="fa-solid fa-clock fa-2x mb-3" style="color:var(--azul-claro)"></i>
          <h6 class="fw-bold" style="color:var(--azul-oscuro)">Enmascaramiento temporal</h6>
          <p class="small" style="color:var(--gris-suave)">Después de un sonido fuerte, el oído tarda unos milisegundos en recuperarse. Durante ese tiempo no percibe sonidos suaves, y el algoritmo los descarta.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="tarjeta-custom p-4 text-center">
          <i class="fa-solid fa-chart-simple fa-2x mb-3" style="color:var(--azul-claro)"></i>
          <h6 class="fw-bold" style="color:var(--azul-oscuro)">Rango del oído humano</h6>
          <p class="small" style="color:var(--gris-suave)">El oído humano percibe frecuencias entre 20 Hz y 20.000 Hz. Cualquier información fuera de ese rango no se guarda, ahorrando espacio sin ninguna pérdida perceptible.</p>
        </div>
      </div>

    </div>
  </section>

  <!-- SECCIÓN 4: LOS 4 FORMATOS -->
  <section id="formatos">
    <h2 class="titulo-seccion">
      <i class="fa-solid fa-file-audio me-2"></i>4. Análisis de formatos
    </h2>

    <div class="row g-4">

      <!-- MP3 -->
      <div class="col-lg-6">
        <div class="tarjeta-custom border-mp3">
          <div class="cabecera-azul" style="background:#1e3a5f">
            <i class="fa-solid fa-music me-2"></i>MP3 &mdash; MPEG-1 Audio Layer III
          </div>
          <div class="p-4">
            <table class="table table-sm mb-3">
              <tr>
                <th style="width:38%">Año</th>
                <td>
                  1993
                  <div class="small text-muted">Lleva más de 30 años siendo el formato de audio más usado del mundo.</div>
                </td>
              </tr>
              <tr>
                <th>Compresión</th>
                <td>
                  <span class="badge" style="background:var(--azul-oscuro)">Con pérdida</span>
                  <div class="small text-muted mt-1">Elimina partes del sonido que el oído no percibe bien. Una vez comprimido no se puede recuperar el audio original.</div>
                </td>
              </tr>
              <tr>
                <th>Algoritmo</th>
                <td>
                  MPEG Layer III
                  <div class="small text-muted">Es el método matemático que decide qué partes del sonido se pueden eliminar sin que se note. Fue desarrollado por el grupo MPEG en los años 90.</div>
                </td>
              </tr>
              <tr>
                <th>Bitrate típico</th>
                <td>
                  128 &ndash; 320 kbps
                  <div class="small text-muted">Kilobits por segundo: cuanto más alto, mejor calidad pero más pesa el archivo. 128 kbps es calidad estándar, 320 kbps es la máxima calidad MP3 (la que usa Spotify Premium).</div>
                </td>
              </tr>
              <tr>
                <th>Patentes</th>
                <td>
                  Expiradas en 2017
                  <div class="small text-muted">Antes había que pagar para usar MP3 en aplicaciones. Desde 2017 es completamente libre.</div>
                </td>
              </tr>
            </table>
            <p class="small mb-0"><strong>Usos:</strong> música general, podcasts, reproductores portátiles</p>
          </div>
        </div>
      </div>

      <!-- WAV -->
      <div class="col-lg-6">
        <div class="tarjeta-custom border-wav">
          <div class="cabecera-azul" style="background:#1d4ed8">
            <i class="fa-solid fa-waveform me-2"></i>WAV &mdash; Waveform Audio File Format
          </div>
          <div class="p-4">
            <table class="table table-sm mb-3">
              <tr>
                <th style="width:38%">Año</th>
                <td>
                  1991
                  <div class="small text-muted">Creado por Microsoft e IBM para Windows. Es el formato de audio más antiguo de los cuatro.</div>
                </td>
              </tr>
              <tr>
                <th>Compresión</th>
                <td>
                  <span class="badge bg-secondary">Sin pérdida (PCM)</span>
                  <div class="small text-muted mt-1">Guarda el sonido tal cual, sin eliminar nada. Al reproducirlo suena exactamente igual que el original grabado.</div>
                </td>
              </tr>
              <tr>
                <th>Algoritmo</th>
                <td>
                  PCM &mdash; Pulse Code Modulation
                  <div class="small text-muted">No hay compresión: el sonido se convierte directamente en números y se guarda en bruto. Es como guardar una foto sin comprimir en vez de como JPG.</div>
                </td>
              </tr>
              <tr>
                <th>Bitrate típico</th>
                <td>
                  ~1.400 kbps
                  <div class="small text-muted">Casi 10 veces más que un MP3 a 128k. Por eso 1 minuto de WAV pesa ~10 MB mientras que el mismo minuto en MP3 pesa ~1 MB.</div>
                </td>
              </tr>
              <tr>
                <th>Patentes</th>
                <td>
                  No tiene
                  <div class="small text-muted">Formato abierto, cualquiera puede usarlo sin pagar licencias.</div>
                </td>
              </tr>
            </table>
            <p class="small mb-0"><strong>Usos:</strong> grabación en estudio, edición profesional, postproducción</p>
          </div>
        </div>
      </div>

      <!-- AAC -->
      <div class="col-lg-6">
        <div class="tarjeta-custom border-aac">
          <div class="cabecera-azul" style="background:#2563eb">
            <i class="fa-solid fa-headphones me-2"></i>AAC &mdash; Advanced Audio Coding
          </div>
          <div class="p-4">
            <table class="table table-sm mb-3">
              <tr>
                <th style="width:38%">Año</th>
                <td>
                  1997
                  <div class="small text-muted">Diseñado como sucesor oficial del MP3, con algoritmos más modernos y eficientes.</div>
                </td>
              </tr>
              <tr>
                <th>Compresión</th>
                <td>
                  <span class="badge" style="background:var(--azul-medio)">Con pérdida</span>
                  <div class="small text-muted mt-1">Igual que MP3 elimina partes del sonido que el oído no percibe, pero con un método más inteligente que da mejor resultado.</div>
                </td>
              </tr>
              <tr>
                <th>Algoritmo</th>
                <td>
                  MPEG-4 Audio
                  <div class="small text-muted">Un método de compresión más avanzado que el del MP3. Aprovecha mejor los modelos psicoacústicos, por eso a igual tamaño suena mejor.</div>
                </td>
              </tr>
              <tr>
                <th>Bitrate típico</th>
                <td>
                  96 &ndash; 256 kbps
                  <div class="small text-muted">A 128 kbps de AAC la calidad equivale aproximadamente a 192 kbps de MP3. Necesita menos datos para sonar igual de bien.</div>
                </td>
              </tr>
              <tr>
                <th>Patentes</th>
                <td>
                  Sí, activas
                  <div class="small text-muted">Hay que pagar licencia para usarlo en productos comerciales. Por eso algunos prefieren OGG, que es libre.</div>
                </td>
              </tr>
            </table>
            <p class="small mb-0"><strong>Usos:</strong> Spotify, YouTube, Apple Music, iPhone</p>
          </div>
        </div>
      </div>

      <!-- OGG -->
      <div class="col-lg-6">
        <div class="tarjeta-custom border-ogg">
          <div class="cabecera-azul" style="background:#3b82f6">
            <i class="fa-solid fa-compact-disc me-2"></i>OGG &mdash; Ogg Vorbis
          </div>
          <div class="p-4">
            <table class="table table-sm mb-3">
              <tr>
                <th style="width:38%">Año</th>
                <td>
                  2000
                  <div class="small text-muted">Creado por la fundación Xiph.Org como alternativa libre y gratuita al MP3 y AAC.</div>
                </td>
              </tr>
              <tr>
                <th>Compresión</th>
                <td>
                  <span class="badge" style="background:var(--azul-claro)">Con pérdida</span>
                  <div class="small text-muted mt-1">Igual que MP3 y AAC, elimina partes del sonido imperceptibles. Calidad comparable a AAC con tamaños similares.</div>
                </td>
              </tr>
              <tr>
                <th>Algoritmo</th>
                <td>
                  Vorbis
                  <div class="small text-muted">El motor de compresión desarrollado por Xiph.Org. Es de código abierto: cualquiera puede ver cómo funciona por dentro y mejorarlo.</div>
                </td>
              </tr>
              <tr>
                <th>Bitrate típico</th>
                <td>
                  Variable (q0 &ndash; q10)
                  <div class="small text-muted">En vez de un número fijo de kbps, OGG usa una escala de calidad del 0 al 10. q4 equivale aproximadamente a 128 kbps de MP3.</div>
                </td>
              </tr>
              <tr>
                <th>Patentes</th>
                <td>
                  Ninguna &mdash; completamente libre
                  <div class="small text-muted">No hay que pagar nada para usarlo. Por eso Spotify lo eligió para su cliente de escritorio y Android.</div>
                </td>
              </tr>
            </table>
            <p class="small mb-0"><strong>Usos:</strong> Spotify en Android/PC, Minecraft, Steam, HTML5</p>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- SECCIÓN 5: TABLA COMPARATIVA -->
  <section id="comparativa">
    <h2 class="titulo-seccion">
      <i class="fa-solid fa-table me-2"></i>5. Tabla comparativa
    </h2>

    <div class="table-container">
      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-dark">
            <tr>
              <th>Formato</th>
              <th>Compresión</th>
              <th>Tamaño (1 min)</th>
              <th>Calidad</th>
              <th>Patentes</th>
              <th>Compatibilidad</th>
              <th>Uso principal</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>MP3</strong></td>
              <td>Con pérdida</td>
              <td>~1 MB a 128k</td>
              <td>Alta</td>
              <td>Expiradas</td>
              <td>Universal</td>
              <td>Música general</td>
            </tr>
            <tr>
              <td><strong>WAV</strong></td>
              <td>Sin pérdida</td>
              <td>~10 MB</td>
              <td>Máxima</td>
              <td>No tiene</td>
              <td>Universal</td>
              <td>Estudio / edición</td>
            </tr>
            <tr>
              <td><strong>AAC</strong></td>
              <td>Con pérdida</td>
              <td>~0,9 MB a 128k</td>
              <td>Muy alta</td>
              <td>Sí</td>
              <td>Muy alta</td>
              <td>Streaming moderno</td>
            </tr>
            <tr>
              <td><strong>OGG</strong></td>
              <td>Con pérdida</td>
              <td>~0,8 MB calidad 4</td>
              <td>Muy alta</td>
              <td>No tiene</td>
              <td>Media</td>
              <td>Streaming / juegos</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </section>


  <!-- SECCIÓN 6: STREAMING -->
  <section id="streaming" class="mb-5">
    <h2 class="titulo-seccion">
      <i class="fa-solid fa-tower-broadcast me-2"></i>6. Audio en Streaming
    </h2>

    <p>El formato de audio tiene impacto directo en el rendimiento de un servicio de streaming. Hay tres problemas técnicos que resolver:</p>

    <div class="row g-4 mb-5">

      <div class="col-md-4">
        <div class="tarjeta-custom p-4">
          <h6 class="fw-bold mb-3" style="color:var(--azul-medio)">
            <i class="fa-solid fa-network-wired me-2"></i>Ancho de banda
          </h6>
          <p class="small">Spotify tiene 600 millones de usuarios. Si cada uno usara WAV (1.400 kbps), el coste de red sería inasumible. Con OGG a 160 kbps se reduce casi 10 veces.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="tarjeta-custom p-4">
          <h6 class="fw-bold mb-3" style="color:var(--azul-medio)">
            <i class="fa-solid fa-bolt me-2"></i>Latencia y buffering
          </h6>
          <p class="small">El audio llega en fragmentos pequeños. Un formato más ligero hace que cada fragmento llegue antes y haya menos cortes. Por eso en conexiones lentas la calidad baja automáticamente.</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="tarjeta-custom p-4">
          <h6 class="fw-bold mb-3" style="color:var(--azul-medio)">
            <i class="fa-solid fa-server me-2"></i>Almacenamiento y CDN
          </h6>
          <p class="small">Los servidores guardan millones de canciones. Si cada canción pesa 10 veces menos, el ahorro en almacenamiento y en servidores de distribución es enorme.</p>
        </div>
      </div>

    </div>

    <h5 class="fw-bold mb-3" style="color:var(--azul-oscuro)">Qué formato usa cada plataforma</h5>

    <div class="table-container mb-4">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark">
          <tr>
            <th>Plataforma</th>
            <th>Formato principal</th>
            <th>Bitrate máximo</th>
            <th>Ventaja en red</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><i class="fa-brands fa-spotify me-2" style="color:#1DB954"></i><strong>Spotify</strong></td>
            <td>OGG Vorbis / AAC (iOS)</td>
            <td>320 kbps</td>
            <td>Baja latencia en móviles</td>
          </tr>
          <tr>
            <td><i class="fa-brands fa-apple me-2" style="color:#555"></i><strong>Apple Music</strong></td>
            <td>
              AAC / ALAC sin pérdida
              <div class="small text-muted">ALAC: formato sin pérdida exclusivo de Apple, integrado en todos sus dispositivos.</div>
            </td>
            <td>Lossless 24 bits</td>
            <td>Integración con ecosistema Apple</td>
          </tr>
          <tr>
            <td><i class="fa-brands fa-youtube me-2" style="color:#FF0000"></i><strong>YouTube Music</strong></td>
            <td>
              Opus / AAC
              <div class="small text-muted">Opus: evolución de OGG diseñada para streaming en tiempo real. Mejor calidad que MP3 a bitrates bajos.</div>
            </td>
            <td>256 kbps</td>
            <td>Eficiencia de datos extrema</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Conclusión -->
    <div class="caja-conclusion">
      <h6 class="fw-bold text-white mb-2">
        <i class="fa-solid fa-circle-check me-2"></i>Conclusión
      </h6>
      <p>En streaming se usa AAC u OGG porque ofrecen la mejor relación calidad/tamaño, reduciendo el ancho de banda necesario sin que el usuario note pérdida de calidad en una escucha casual. Un servicio como Spotify ahorra millones en infraestructura gracias a la elección del formato correcto.</p>
    </div>

  </section>

</div>

<?php include 'footer.php'; ?>
</body>
</html>
