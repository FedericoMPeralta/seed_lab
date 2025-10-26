<div class="home content">
    <div class="main-title-header">
        <h1>SEED LAB - INASE</h1>
        <p>Sistema de Gestión de Muestras de Semillas</p>
    </div>

    <div class="cards-container">
        <div class="card">
            <h3>Gestión de Muestras</h3>
            <p>Vista de muestras y sus resultados</p>
            <?= $this->Html->link('Ir a Muestras →', ['controller' => 'Muestras', 'action' => 'index'], ['class' => 'card-button']) ?>
        </div>

        <div class="card">
            <h3>Reportes</h3>
            <p>Vista de reportes y análisis</p>
            <?= $this->Html->link('Ver Reportes →', ['controller' => 'Muestras', 'action' => 'reporte'], ['class' => 'card-button']) ?>
        </div>

        <div class="card">
            <h3>Nueva Muestra</h3>
            <p>Registrar una nueva muestra en el sistema</p>
            <?= $this->Html->link('Crear Muestra →', ['controller' => 'Muestras', 'action' => 'add', '?' => ['referer' => 'home']], ['class' => 'card-button']) ?>
        </div>

        <div class="card">
            <h3>Nuevo Resultado</h3>
            <p>Cargar resultado a una muestra existente</p>
            <?= $this->Html->link('Agregar Resultado →', ['controller' => 'Resultados', 'action' => 'add', '?' => ['referer' => 'home']], ['class' => 'card-button']) ?>
        </div>
    </div>
</div>