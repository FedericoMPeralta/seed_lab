<div class="home content">
    <div class="main-title">
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
            <?= $this->Html->link('Agregar Resultado →', ['controller' => 'Resultados', 'action' => 'add'], ['class' => 'card-button']) ?>
        </div>
    </div>
</div>

<style>
.home.content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.main-title {
    text-align: center;
    padding: 40px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    margin-bottom: 30px;
}

.main-title h1 {
    margin: 0 0 10px 0;
    font-size: 2.5em;
}

.main-title p {
    margin: 0;
    font-size: 1.2em;
    opacity: 0.9;
}

.cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.card-icon {
    font-size: 3em;
    margin-bottom: 15px;
}

.card h3 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1.3em;
}

.card p {
    color: #666;
    margin: 0 0 20px 0;
    font-size: 0.95em;
    line-height: 1.5;
}

.card-button {
    display: inline-block;
    padding: 12px 25px;
    background: #667eea;
    color: white !important;
    text-decoration: none;
    border-radius: 6px;
    transition: background 0.2s;
}

.card-button:hover {
    background: #5568d3;
}
</style>