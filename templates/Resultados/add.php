<div class="resultados form content">
    <h3>Cargar Nuevo Resultado<?= isset($muestraSeleccionada) ? ' - Muestra ' . h($muestraSeleccionada->codigo) : '' ?></h3>
    
    <?= $this->Form->create($resultado) ?>
    <fieldset>
        <legend>Datos del Análisis</legend>
        
        <div class="input text">
            <label for="muestra-search">Muestra</label>
            <input 
                type="text" 
                id="muestra-search" 
                name="muestra_search"
                value="<?= isset($muestraSeleccionada) ? h($muestraSeleccionada->codigo) : '' ?>"
                autocomplete="off"
            />
            <div id="suggestions" class="suggestions"></div>
            <?= $this->Form->control('muestra_id', [
                'type' => 'hidden',
                'id' => 'muestra-id',
                'value' => $resultado->muestra_id ?? ''
            ]) ?>
        </div>

        <?= $this->Form->control('poder_germinativo', [
            'label' => 'Poder Germinativo (%)',
            'type' => 'number',
            'step' => '0.01',
            'min' => '0',
            'max' => '100',
        ]) ?>
        
        <?= $this->Form->control('pureza', [
            'label' => 'Pureza (%)',
            'type' => 'number',
            'step' => '0.01',
            'min' => '0',
            'max' => '100',
        ]) ?>
        
        <?= $this->Form->control('materiales_inertes', [
            'label' => 'Materiales Inertes',
            'type' => 'textarea',
            'rows' => 3,
        ]) ?>
        
        <?= $this->Form->control('fecha_recepcion', [
            'label' => 'Fecha de Recepción',
            'type' => 'text',
            'class' => 'datepicker',
            'value' => date('d/m/Y'),
            'placeholder' => 'dd/mm/aaaa'
        ]) ?>
    </fieldset>
    
    <?= $this->Form->button(__('Guardar Resultado'), ['class' => 'button']) ?>
    <?php if (isset($referer) && $referer === 'home'): ?>
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Pages', 'action' => 'home'], ['class' => 'button secondary']) ?>
    <?php else: ?>
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Muestras', 'action' => isset($muestraId) ? 'view' : 'index', isset($muestraId) ? $muestraId : null], ['class' => 'button secondary']) ?>
    <?php endif; ?>
    <?= $this->Form->end() ?>
</div>

<script>
const muestrasData = <?= json_encode(array_map(function($m) {
    return ['id' => $m->id, 'codigo' => $m->codigo];
}, $muestras)) ?>;

initMuestraAutocomplete(muestrasData);

<?php if (isset($muestraId) && $muestraId): ?>
document.getElementById('muestra-id').value = '<?= $muestraId ?>';
<?php endif; ?>
</script>