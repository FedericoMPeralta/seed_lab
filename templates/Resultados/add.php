<div class="resultados form content">
    <h3>Cargar Nuevo Resultado<?= isset($muestraSeleccionada) ? ' - Muestra ' . h($muestraSeleccionada->codigo) : '' ?></h3>
    
    <?= $this->Form->create($resultado) ?>
    <fieldset>
        <legend>Datos del Análisis</legend>
        
        <?php if (isset($muestraSeleccionada)): ?>
            <div class="input text disabled">
                <label>Muestra</label>
                <input type="text" value="<?= h($muestraSeleccionada->codigo) ?>" disabled />
                <?= $this->Form->control('muestra_id', [
                    'type' => 'hidden',
                    'value' => $muestraSeleccionada->id
                ]) ?>
            </div>
        <?php else: ?>
            <div class="input text">
                <label for="muestra-search">Muestra</label>
                <input 
                    type="text" 
                    id="muestra-search" 
                    name="muestra_search"
                    autocomplete="off"
                    list="codigos-list"
                />
                <datalist id="codigos-list"></datalist>
                <?= $this->Form->control('muestra_id', [
                    'type' => 'hidden',
                    'id' => 'muestra-id'
                ]) ?>
            </div>
        <?php endif; ?>

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

<?php if (!isset($muestraSeleccionada)): ?>
<script>
const muestrasData = <?= json_encode(array_map(function($m) {
    return ['id' => $m->id, 'codigo' => $m->codigo];
}, $muestras)) ?>;

const searchInput = document.getElementById('muestra-search');
const hiddenInput = document.getElementById('muestra-id');
const datalist = document.getElementById('codigos-list');

let allOptions = muestrasData.map(m => m.codigo);

searchInput.addEventListener('input', function() {
    const searchTerm = this.value;
    datalist.innerHTML = '';
    hiddenInput.value = '';
    
    if (searchTerm.length === 0) {
        return;
    }
    
    const filtered = muestrasData.filter(m => m.codigo.includes(searchTerm));
    
    filtered.slice(0, 15).forEach(muestra => {
        const option = document.createElement('option');
        option.value = muestra.codigo;
        datalist.appendChild(option);
    });
    
    const exactMatch = muestrasData.find(m => m.codigo === searchTerm);
    if (exactMatch) {
        hiddenInput.value = exactMatch.id;
    }
});

searchInput.addEventListener('blur', function() {
    const searchTerm = this.value;
    const exactMatch = muestrasData.find(m => m.codigo === searchTerm);
    if (exactMatch) {
        hiddenInput.value = exactMatch.id;
    } else {
        hiddenInput.value = '';
    }
});
</script>
<?php endif; ?>