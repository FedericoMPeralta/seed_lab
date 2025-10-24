<div class="muestras view content">
    <h3>Detalle de Muestra <?= h($muestra->codigo) ?></h3>

    <table>
        <tr><th>Código:</th><td><?= h($muestra->codigo) ?></td></tr>
        <tr><th>Precinto:</th><td><?= h($muestra->numero_precinto) ?></td></tr>
        <tr><th>Empresa:</th><td><?= h($muestra->empresa ?: 'Sin datos') ?></td></tr>
        <tr><th>Especie:</th><td><?= h($muestra->especie ?: 'Sin datos') ?></td></tr>
        <tr><th>Cantidad de semillas:</th><td><?= $muestra->cantidad_semillas ?: 'Sin datos' ?></td></tr>
        <tr><th>Fecha recepción:</th><td><?= $muestra->fecha_recepcion->format('d/m/Y H:i') ?></td></tr>
        <tr><th>Fecha modificación:</th><td><?= $muestra->fecha_modificacion->format('d/m/Y H:i') ?></td></tr>
    </table>

    <div class="related">
        <h4>Resultados de Análisis</h4>
        <?= $this->Html->link('+ Cargar Nuevo Resultado', ['controller' => 'Resultados', 'action' => 'add', $muestra->id], ['class' => 'button']) ?>
        <br><br>
        <?php if (!empty($muestra->resultados)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Poder Germinativo</th>
                        <th>Pureza</th>
                        <th>Materiales Inertes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($muestra->resultados as $resultado): ?>
                        <tr>
                            <td><?= $resultado->fecha_recepcion->format('d/m/Y H:i') ?></td>
                            <td><?= $resultado->poder_germinativo ?>%</td>
                            <td><?= $resultado->pureza ?>%</td>
                            <td><?= h($resultado->materiales_inertes ?: '-') ?></td>
                            <td class="actions">
                                <?= $this->Html->link('Editar', ['controller' => 'Resultados', 'action' => 'edit', $resultado->id], ['class' => 'button small white-text']) ?>
                                <?= $this->Form->postLink(
                                    'Eliminar',
                                    ['controller' => 'Resultados', 'action' => 'delete', $resultado->id],
                                    [
                                        'confirm' => '¿Eliminar este resultado?',
                                        'class' => 'button small danger white-text'
                                    ]
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay resultados cargados para esta muestra.</p>
        <?php endif; ?>
    </div>

    <br>
    <div class="actions">
        <?= $this->Html->link('Editar Muestra', ['action' => 'edit', $muestra->id], ['class' => 'button white-text']) ?>
        <?php
        $cantResultados = count($muestra->resultados);
        $confirmMsg = $cantResultados > 0 
            ? "¿Eliminar esta muestra y sus {$cantResultados} resultado(s)?" 
            : '¿Eliminar esta muestra?';
        ?>
        <?= $this->Form->postLink(
            'Eliminar Muestra',
            ['action' => 'delete', $muestra->id],
            [
                'confirm' => $confirmMsg,
                'class' => 'button danger white-text'
            ]
        ) ?>
        <?= $this->Html->link('Volver al Listado', ['action' => 'index'], ['class' => 'button secondary white-text']) ?>
    </div>
</div>

<style>
.button.white-text,
.button.small.white-text {
    color: white !important;
}
</style>