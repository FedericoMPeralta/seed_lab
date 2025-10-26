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
                        'resultado' => 'Fecha Análisis'
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
                    <th>
                        <?php
                        $newDirection = ($sort === 'poder_germinativo' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'poder_germinativo') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'poder_germinativo';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Poder Germinativo' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                    <th>
                        <?php
                        $newDirection = ($sort === 'pureza' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'pureza') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'pureza';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Pureza' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
                    <th>
                        <?php
                        $newDirection = ($sort === 'materiales_inertes' && $direction === 'asc') ? 'desc' : 'asc';
                        $arrow = ($sort === 'materiales_inertes') ? ($direction === 'asc' ? ' ▲' : ' ▼') : '';
                        $query = $this->request->getQuery();
                        $query['sort'] = 'materiales_inertes';
                        $query['direction'] = $newDirection;
                        echo $this->Html->link('Materiales Inertes' . $arrow, ['?' => $query], ['escape' => false, 'class' => 'sort-link']);
                        ?>
                    </th>
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
                <?php if (count($muestras) > 0): ?>
                    <?php if ($modo === 'detallado'): ?>
                        <?php foreach ($muestras as $item): ?>
                            <?php 
                            $muestra = $item['muestra'];
                            $resultado = $item['resultado'];
                            ?>
                            <tr>
                                <td><?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?></td>
                                <td><?= h($muestra->empresa) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= h($muestra->especie) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= $muestra->fecha_recepcion ? $muestra->fecha_recepcion->format('d/m/Y') : '<span class="sin-datos">Sin datos</span>' ?></td>
                                
                                <?php if ($resultado): ?>
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
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php foreach ($muestras as $muestra): ?>
                            <tr>
                                <td><?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?></td>
                                <td><?= h($muestra->empresa) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= h($muestra->especie) ?: '<span class="sin-datos">Sin datos</span>' ?></td>
                                <td><?= $muestra->fecha_recepcion ? $muestra->fecha_recepcion->format('d/m/Y') : '<span class="sin-datos">Sin datos</span>' ?></td>
                                
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
                        <?php endforeach; ?>
                    <?php endif; ?>
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
    
    <?php if (count($muestras) > 0): ?>
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