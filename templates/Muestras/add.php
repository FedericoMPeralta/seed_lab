<div class="muestras form content">
    <h3>Registrar Nueva Muestra</h3>
    <?= $this->Form->create($muestra) ?>
    <fieldset>
        <?php
            echo $this->Form->control('numero_precinto', [
                'label' => 'Número de Precinto',
                'autocomplete' => 'off'
            ]);
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
                'placeholder' => 'dd/mm/aaaa'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Guardar'), ['class' => 'button']) ?>
    <?php if (isset($referer) && $referer === 'home'): ?>
        <?= $this->Html->link(__('Cancelar'), ['controller' => 'Pages', 'action' => 'home'], ['class' => 'button secondary']) ?>
    <?php else: ?>
        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'button secondary']) ?>
    <?php endif; ?>
    <?= $this->Form->end() ?>
</div>