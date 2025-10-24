<div class="muestras index content">
    <h3>Listado de Muestras</h3>
    <?= $this->Html->link('Nueva Muestra', ['action' => 'add'], ['class' => 'button float-right']) ?>
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
            <tr>
                <td><?= h($muestra->codigo) ?></td>
                <td><?= h($muestra->numero_precinto) ?></td>
                <td class="text-center"><?= count($muestra->resultados) ?></td>
                <td class="actions">
                    <?= $this->Html->link('Ver Detalle', ['action' => 'view', $muestra->id], ['class' => 'button small white-text']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.button.small.white-text {
    color: white !important;
}
.text-center {
    text-align: center;
}
</style>