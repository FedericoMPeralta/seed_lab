<div class="muestras view content">
    <h3>Detalle de Muestra <?= h($muestra->codigo) ?></h3>

    <table>
        <tr><th>Código:</th><td><?= h($muestra->codigo) ?></td></tr>
        <tr><th>Precinto:</th><td><?= h($muestra->numero_precinto) ?></td></tr>
        <tr><th>Empresa:</th><td><?= h($muestra->empresa ?? 'Sin datos') ?></td></tr>
        <tr><th>Especie:</th><td><?= h($muestra->especie ?? 'Sin datos') ?></td></tr>
        <tr><th>Cantidad:</th><td><?= $muestra->cantidad_semillas ?? '-' ?></td></tr>
        <tr><th>Fecha recepción:</th><td><?= $muestra->fecha_recepcion->format('d/m/Y H:i') ?></td></tr>
    </table>

    <div class="related">
        <h4>Resultados</h4>
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
                            <td><?= $resultado->fecha_recepcion->format('d/m/Y') ?></td>
                            <td><?= $resultado->poder_germinativo ?>%</td>
                            <td><?= $resultado->pureza ?>%</td>
                            <td><?= h($resultado->materiales_inertes ?? '') ?></td>
                            <td>
                                <?= $this->Html->link('Editar', ['controller' => 'Resultados', 'action' => 'edit', $resultado->id], ['class' => 'button small']) ?>
                                <?= $this->Form->postLink('Eliminar', ['controller' => 'Resultados', 'action' => 'delete', $resultado->id], ['confirm' => '¿Eliminar este resultado?', 'class' => 'button small danger']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay resultados cargados.</p>
            <?= $this->Html->link('Cargar Resultados', ['controller' => 'Resultados', 'action' => 'add', $muestra->id], ['class' => 'button']) ?>
        <?php endif; ?>
    </div>

    <br>
    <?= $this->Html->link('Editar Muestra', ['action' => 'edit', $muestra->id], ['class' => 'button']) ?>
    <?= $this->Html->link('Volver al Listado', ['action' => 'index'], ['class' => 'button']) ?>
</div>
