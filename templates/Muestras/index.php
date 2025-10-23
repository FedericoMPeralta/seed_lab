<div class="muestras index content">
    <h3>Listado de Muestras</h3>
    <?= $this->Html->link('Nueva Muestra', ['action' => 'add'], ['class' => 'button float-right']) ?>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Precinto</th>
                <th>Empresa</th>
                <th>Especie</th>
                <th>Semillas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($muestras as $muestra): ?>
            <tr>
                <td><?= h($muestra->codigo) ?></td>
                <td><?= h($muestra->numero_precinto) ?></td>
                <td><?= h($muestra->empresa ?? 'Sin datos') ?></td>
                <td><?= h($muestra->especie ?? 'Sin datos') ?></td>
                <td><?= $muestra->cantidad_semillas ?? 'Sin datos' ?></td>
                <td>
                    <?= $this->Html->link('Ver', ['action' => 'view', $muestra->id], ['class' => 'button small']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
