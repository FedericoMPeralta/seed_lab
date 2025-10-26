<div class="resultados form content">
    <h3>Editar Resultado - Muestra <?= h($resultado->muestra->codigo) ?></h3>
    
    <?= $this->Form->create($resultado) ?>
    <fieldset>
        <legend>Datos del Análisis</legend>
        
        <div class="input text disabled">
            <label>Muestra</label>
            <input type="text" value="<?= h($resultado->muestra->codigo) ?>" disabled />
        </div>
        
        <?= $this->Form->control('muestra_id', ['type' => 'hidden']) ?>

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
            'value' => $resultado->fecha_recepcion ? $resultado->fecha_recepcion->format('d/m/Y') : '',
            'placeholder' => 'dd/mm/aaaa'
        ]) ?>
    </fieldset>
    
    <?= $this->Form->button(__('Actualizar'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancelar'), ['controller' => 'Muestras', 'action' => 'view', $resultado->muestra_id], ['class' => 'button secondary']) ?>
    <?= $this->Form->end() ?>
    
    <hr>
    
    <div class="actions">
        <?= $this->Form->postLink(
            __('Eliminar'),
            ['action' => 'delete', $resultado->id],
            [
                'confirm' => __('¿Está seguro de eliminar este resultado?'),
                'class' => 'button danger'
            ]
        ) ?>
    </div>
</div>