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
                'type' => 'text',
                'class' => 'datepicker',
                'value' => $muestra->fecha_recepcion->format('d/m/Y'),
                'placeholder' => 'dd/mm/aaaa'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Actualizar'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Cancelar'), ['action' => 'view', $muestra->id], ['class' => 'button secondary']) ?>
    <?= $this->Form->end() ?>
</div>