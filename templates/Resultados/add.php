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
            'type' => 'datetime-local',
            'value' => $resultado->fecha_recepcion ? $resultado->fecha_recepcion->format('Y-m-d\TH:i') : date('Y-m-d\TH:i')
        ]) ?>
    </fieldset>
    
    <?= $this->Form->button(__('Guardar Resultado'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancelar'), ['controller' => 'Muestras', 'action' => isset($muestraId) ? 'view' : 'index', isset($muestraId) ? $muestraId : null], ['class' => 'button secondary']) ?>
    <?= $this->Form->end() ?>
</div>

<script>
const muestrasData = <?= json_encode(array_map(function($m) {
    return ['id' => $m->id, 'codigo' => $m->codigo];
}, $muestras)) ?>;

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('muestra-search');
    const hiddenInput = document.getElementById('muestra-id');
    const suggestionsDiv = document.getElementById('suggestions');
    
    searchInput.addEventListener('input', function() {
        const searchValue = this.value.toUpperCase();
        suggestionsDiv.innerHTML = '';
        
        if (searchValue.length === 0) {
            hiddenInput.value = '';
            return;
        }
        
        const filtered = muestrasData.filter(m => m.codigo.toUpperCase().includes(searchValue));
        
        if (filtered.length > 0) {
            filtered.slice(0, 10).forEach(muestra => {
                const div = document.createElement('div');
                div.textContent = muestra.codigo;
                div.className = 'suggestion-item';
                div.onclick = function() {
                    searchInput.value = muestra.codigo;
                    hiddenInput.value = muestra.id;
                    suggestionsDiv.innerHTML = '';
                };
                suggestionsDiv.appendChild(div);
            });
        } else {
            hiddenInput.value = '';
        }
    });
    
    document.addEventListener('click', function(e) {
        if (e.target !== searchInput) {
            suggestionsDiv.innerHTML = '';
        }
    });
    
    <?php if (isset($muestraId) && $muestraId): ?>
    hiddenInput.value = '<?= $muestraId ?>';
    <?php endif; ?>
});
</script>

<style>
#muestra-search {
    width: 100%;
    padding: 8px;
    margin-bottom: 5px;
}
.suggestions {
    border: 1px solid #ddd;
    max-height: 200px;
    overflow-y: auto;
    background: white;
    position: absolute;
    width: calc(100% - 20px);
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.suggestion-item {
    padding: 8px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}
.suggestion-item:hover {
    background: #f0f0f0;
}
.input.text {
    position: relative;
}
</style>