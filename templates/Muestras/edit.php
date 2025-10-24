<div class="muestras form content">
    <h3>Editar Muestra <?= h($muestra->codigo) ?></h3>
    <?= $this->Form->create($muestra) ?>
    <fieldset>
        <legend>Datos de la Muestra</legend>
        <?php
            echo $this->Form->control('numero_precinto', ['label' => 'Número de Precinto']);
            echo $this->Form->control('empresa', ['label' => 'Empresa']);
            echo $this->Form->control('especie', ['label' => 'Especie']);
            echo $this->Form->control('cantidad_semillas', [
                'label' => 'Cantidad de Semillas',
                'type' => 'number',
                'min' => '0'
            ]);
            echo $this->Form->control('fecha_recepcion', [
                'label' => 'Fecha de Recepción',
                'type' => 'datetime-local',
                'value' => $muestra->fecha_recepcion->format('Y-m-d\TH:i')
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Actualizar'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $muestra->id], ['class' => 'button secondary']) ?>
    <?= $this->Form->end() ?>
    
    <hr>
    
    <div class="actions">
        <?php
        $cantResultados = $muestra->has('resultados') ? count($muestra->resultados) : 0;
        $confirmMsg = $cantResultados > 0 
            ? "¿Está seguro de eliminar la muestra {$muestra->codigo} y sus {$cantResultados} resultado(s)?" 
            : "¿Está seguro de eliminar la muestra {$muestra->codigo}?";
        ?>
        <?= $this->Form->postLink(
            __('Eliminar Muestra'),
            ['action' => 'delete', $muestra->id],
            [
                'confirm' => $confirmMsg,
                'class' => 'button danger'
            ]
        ) ?>
    </div>
</div>