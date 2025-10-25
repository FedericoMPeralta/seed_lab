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
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputs = document.querySelectorAll('.datepicker-filtro');
                        
                        inputs.forEach(input => {
                            input.addEventListener('input', function(e) {
                                let value = e.target.value.replace(/\D/g, '');
                                
                                if (value.length >= 2) {
                                    value = value.substring(0, 2) + '/' + value.substring(2);
                                }
                                if (value.length >= 5) {
                                    value = value.substring(0, 5) + '/' + value.substring(5, 9);
                                }
                                
                                e.target.value = value;
                            });
                        });
                    });
                </script>
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
                    <th>Código</th>
                    <th>Empresa</th>
                    <th>Especie</th>
                    <th>Poder Germinativo</th>
                    <th>Pureza</th>
                    <th>Materiales Inertes</th>
                    <th>Fecha Análisis</th>
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
                                    <td rowspan="<?= count($muestra->resultados) ?>"><?= h($muestra->empresa ?: 'Sin datos') ?></td>
                                    <td rowspan="<?= count($muestra->resultados) ?>"><?= h($muestra->especie ?: 'Sin datos') ?></td>
                                <?php endif; ?>
                                
                                <td class="text-center"><?= $resultado->poder_germinativo !== null ? $this->Number->format($resultado->poder_germinativo) . '%' : 'Sin datos' ?></td>
                                <td class="text-center"><?= $resultado->pureza !== null ? $this->Number->format($resultado->pureza) . '%' : 'Sin datos' ?></td>
                                <td><?= h($resultado->materiales_inertes ?: 'Sin datos') ?></td>
                                <td><?= $resultado->fecha_recepcion ? $resultado->fecha_recepcion->format('d/m/Y H:i') : 'Sin datos' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php elseif ($modo === 'detallado' && empty($muestra->resultados)): ?>
                            <tr>
                                <td><?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?></td>
                                <td><?= h($muestra->empresa ?: 'Sin datos') ?></td>
                                <td><?= h($muestra->especie ?: 'Sin datos') ?></td>
                                <td class="text-center sin-datos">Sin datos</td>
                                <td class="text-center sin-datos">Sin datos</td>
                                <td class="sin-datos">Sin datos</td>
                                <td class="sin-datos">-</td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td><?= $this->Html->link($muestra->codigo, ['action' => 'view', $muestra->id]) ?></td>
                                <td><?= h($muestra->empresa ?: 'Sin datos') ?></td>
                                <td><?= h($muestra->especie ?: 'Sin datos') ?></td>
                                
                                <?php if (!empty($muestra->resultados)): ?>
                                    <?php $resultado = $muestra->resultados[0]; ?>
                                    <td class="text-center"><?= $resultado->poder_germinativo !== null ? $this->Number->format($resultado->poder_germinativo) . '%' : 'Sin datos' ?></td>
                                    <td class="text-center"><?= $resultado->pureza !== null ? $this->Number->format($resultado->pureza) . '%' : 'Sin datos' ?></td>
                                    <td><?= h($resultado->materiales_inertes ?: 'Sin datos') ?></td>
                                    <td><?= $resultado->fecha_recepcion ? $resultado->fecha_recepcion->format('d/m/Y H:i') : 'Sin datos' ?></td>
                                <?php else: ?>
                                    <td class="text-center sin-datos">Sin datos</td>
                                    <td class="text-center sin-datos">Sin datos</td>
                                    <td class="sin-datos">Sin datos</td>
                                    <td class="sin-datos">-</td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">
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

<style>
.filters.card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.modo-vista {
    display: block;
    padding: 15px 0;
    border-top: 1px solid #dee2e6;
}

.radio-group {
    display: flex;
    gap: 20px;
    margin-top: 10px;
}

.form-actions {
    display: flex;
    gap: 10px;
}

.muestra-codigo {
    font-weight: bold;
    background: #f8f9fa;
}

.sin-datos {
    color: #999;
    font-style: italic;
}

.info-box {
    background: #e7f3ff;
    border-left: 4px solid #0066cc;
    padding: 15px;
    margin-top: 20px;
    border-radius: 4px;
}

.text-center {
    text-align: center;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px;
    border: 1px solid #dee2e6;
}

.table thead {
    background: #343a40;
    color: white;
}

.table tbody tr:nth-child(even) {
    background: #f8f9fa;
}

.table tbody tr:hover {
    background: #e9ecef;
}

.table-responsive {
    overflow-x: auto;
}
</style>