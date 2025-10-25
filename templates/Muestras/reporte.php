<?php
$sort = $this->request->getQuery('sort', 'codigo');
$direction = $this->request->getQuery('direction', 'asc');
?>

<div class="muestras reporte content">
    <h3>Reporte de Análisis de Muestras</h3>
    
    <div class="filters card">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'filter-form']) ?>
        <fieldset>
            <legend>Filtros</legend>
            <div class="form-row">
                <?= $this->Form->control('especie', [
                    'options' => $especies,
                    'empty' => '-- Todas las especies --',
                    'value' => $this->request->getQuery('especie'),
                    'label' => 'Especie'
                ]) ?>
                
                <?= $this->Form->control('tipo_fecha', [
                    'options' => [
                        'muestra' => 'Fecha Recepción Muestra',
                        'resultado' => 'Fecha Recepción Resultado'
                    ],
                    'value' => $tipoFecha,
                    'label' => 'Filtrar por'
                ]) ?>
                
                <?= $this->Form->control('fecha_desde', [
                    'type' => 'text',
                    'label' => 'Desde',
                    'value' => $this->request->getQuery('fecha_desde'),
                    'placeholder' => 'dd/mm/aaaa',
                    'class' => 'datepicker-filtro'
                ]) ?>
                
                <?= $this->Form->control('fecha_hasta', [
                    'type' => 'text',
                    'label' => 'Hasta',
                    'value' => $this->request->getQuery('fecha_hasta'),
                    'placeholder' => 'dd/mm/aaaa',
                    'class' => 'datepicker-filtro'
                ]) ?>
            </div>
            
            <div class="form-row modo-vista">
                <label>Modo de vista:</label>
                <div class="radio-group">
                    <?= $this->Form->radio('modo', [
                        ['value' => 'resumen', 'text' => 'Resumen (último resultado por muestra)'],
                        ['value' => 'detallado', 'text' => 'Detallado (todos los resultados)']
                    ], [
                        'value' => $modo,
                        'hiddenField' => false
                    ]) ?>
                </div>
            </div>
        </fieldset>
        
        <div class="form-actions">
            <?= $this->Form->button(__('Aplicar Filtros'), ['class' => 'button']) ?>
            <?= $this->Html->link(__('Limpiar'), ['action' => 'reporte'], ['class' => 'button secondary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <?php
                        $newDirection = ($sort === 'codigo' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'codigo') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'codigo';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Código' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                    <th>
                        <?php
                        $newDirection = ($sort === 'empresa' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'empresa') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'empresa';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Empresa' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                    <th>
                        <?php
                        $newDirection = ($sort === 'especie' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'especie') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'especie';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Especie' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                    <th>
                        <?php
                        $newDirection = ($sort === 'fecha_recepcion' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'fecha_recepcion') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'fecha_recepcion';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Fecha Recep. Muestra' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                    <th>Poder Germinativo</th>
                    <th>Pureza</th>
                    <th>Materiales Inertes</th>
                    <th>
                        <?php
                        $newDirection = ($sort === 'fecha_analisis' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'fecha_analisis') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'fecha_analisis';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Fecha Análisis' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if ($muestras->count() > 0): ?>
                    <?php foreach ($muestras as $muestra): ?>
                        <?php if ($modo === 'detallado' && !empty($muestra->resultados)): ?>
                            <?php foreach ($muestra->resultados as $index => $resultado): ?>
                            <tr>
                                <?php if ($index === 0): ?>
                                    <td rowspan="<?= count($muestra->resultados) ?>" class="muestra-codigo">
                                        <?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?>
                                    </td>
                                    <td rowspan="<?= count($muestra->resultados) ?>"><?= h($muestra->empresa) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                    <td rowspan="<?= count($muestra->resultados) ?>"><?= h($muestra->especie) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                    <td rowspan="<?= count($muestra->resultados) ?>"><?= $muestra->fecha_recepcion->format('d/m/Y') ?></td>
                                <?php endif; ?>
                                
                                <td class="text-center"><?= $resultado->poder_germinativo !== null ? $this->Number->format($resultado->poder_germinativo) . '%' : '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td class="text-center"><?= $resultado->pureza !== null ? $this->Number->format($resultado->pureza) . '%' : '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= h($resultado->materiales_inertes) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= $resultado->fecha_recepcion ? $resultado->fecha_recepcion->format('d/m/Y') : '<span class="sin-datos">Sin datos</span>' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php elseif ($modo === 'detallado' && empty($muestra->resultados)): ?>
                            <tr>
                                <td><?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?></td>
                                <td><?= h($muestra->empresa) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= h($muestra->especie) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= $muestra->fecha_recepcion->format('d/m/Y') ?></td>
                                <td class="text-center"><span class="sin-datos">Sin datos</span></td>
                                <td class="text-center"><span class="sin-datos">Sin datos</span></td>
                                <td><span class="sin-datos">Sin datos</span></td>
                                <td><span class="sin-datos">Sin datos</span></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td><?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?></td>
                                <td><?= h($muestra->empresa) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= h($muestra->especie) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= $muestra->fecha_recepcion->format('d/m/Y') ?></td>
                                
                                <?php if (!empty($muestra->resultados)): ?>
                                    <?php $resultado = $muestra->resultados[0]; ?>
                                    <td class="text-center"><?= $resultado->poder_germinativo !== null ? $this->Number->format($resultado->poder_germinativo) . '%' : '<span class="sin-datos">Sin datos</span>' ?></td>
                                    <td class="text-center"><?= $resultado->pureza !== null ? $this->Number->format($resultado->pureza) . '%' : '<span class="sin-datos">Sin datos</span>' ?></td>
                                    <td><?= h($resultado->materiales_inertes) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                    <td><?= $resultado->fecha_recepcion ? $resultado->fecha_recepcion->format('d/m/Y') : '<span class="sin-datos">Sin datos</span>' ?></td>
                                <?php else: ?>
                                    <td class="text-center"><span class="sin-datos">Sin datos</span></td>
                                    <td class="text-center"><span class="sin-datos">Sin datos</span></td>
                                    <td><span class="sin-datos">Sin datos</span></td>
                                    <td><span class="sin-datos">Sin datos</span></td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            <em>No se encontraron muestras que coincidan con los filtros aplicados.</em>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($muestras->count() > 0): ?>
    <div class="info-box">
        <p>
            <?php if ($modo === 'resumen'): ?>
                <strong>Modo Resumen:</strong> Mostrando el resultado más reciente de cada muestra.
            <?php else: ?>
                <strong>Modo Detallado:</strong> Mostrando todos los resultados de cada muestra.
            <?php endif; ?>
        </p>
    </div>
    <?php endif; ?>
    
    <br>
    <?= $this->Html->link('← Volver al Inicio', ['controller' => 'Pages', 'action' => 'home'], ['class' => 'button secondary']) ?>
</div>