<div class="muestras form content">
    <h3>Registrar Nueva Muestra</h3>
    <?= $this->Form->create($muestra) ?>
    <fieldset>
        <?php
            echo $this->Form->control('numero_precinto', ['label' => 'Número de Precinto']);
            echo $this->Form->control('empresa', ['label' => 'Empresa']);
            echo $this->Form->control('especie', ['label' => 'Especie']);
            echo $this->Form->control('cantidad_semillas', ['label' => 'Cantidad de Semillas']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Guardar'), ['class' => 'button']) ?>
    <?= $this->Form->end() ?>
</div>
