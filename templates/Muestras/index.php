<div class="muestras index content">
    <h3>Listado de Muestras</h3>
    <div class="header-actions">
        <?= $this->Html->link('← Volver al Inicio', ['controller' => 'Pages', 'action' => 'home'], ['class' => 'button secondary']) ?>
        <?= $this->Html->link('Nueva Muestra', ['action' => 'add', '?' => ['referer' => 'index']], ['class' => 'button']) ?>
    </div>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Precinto</th>
                <th>Resultados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($muestras as $muestra): ?>
            <tr class="clickable-row" data-href="<?= $this->Url->build(['action' => 'view', $muestra->id]) ?>">
                <td><?= h($muestra->codigo) ?></td>
                <td><?= h($muestra->numero_precinto) ?></td>
                <td class="text-center"><?= count($muestra->resultados) ?></td>
                <td class="actions" onclick="event.stopPropagation();">
                    <?= $this->Html->link('Ver Detalle', ['action' => 'view', $muestra->id], ['class' => 'button small white-text']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.clickable-row');
    rows.forEach(row => {
        row.addEventListener('click', function() {
            window.location.href = this.dataset.href;
        });
    });
});
</script>

<style>
.header-actions {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.button.small.white-text {
    color: white !important;
}
.text-center {
    text-align: center;
}
.clickable-row {
    cursor: pointer;
}
.clickable-row:hover {
    background-color: #f0f0f0;
}
</style>