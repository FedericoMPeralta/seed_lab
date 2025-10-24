<div class="muestras form content">
    <h3>Registrar Nueva Muestra</h3>
    <?= $this->Form->create($muestra) ?>
    <fieldset>
        <?php
            echo $this->Form->control('numero_precinto', ['label' => 'Número de Precinto']);
            echo $this->Form->control('empresa', ['label' => 'Empresa']);
            echo $this->Form->control('especie', ['label' => 'Especie']);
            echo $this->Form->control('cantidad_semillas', [
                'label' => 'Cantidad de Semillas',
                'type' => 'number',
                'min' => '0'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Guardar'), ['class' => 'button']) ?>
    <?= $this->Html->link(__('Volver'), ['action' => 'index'], ['class' => 'button secondary']) ?>
    <?= $this->Form->end() ?>
</div>