<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resultado $resultado
 * @var \Cake\Collection\CollectionInterface|string[] $muestras
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Resultados'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="resultados form content">
            <?= $this->Form->create($resultado) ?>
            <fieldset>
                <legend><?= __('Add Resultado') ?></legend>
                <?php
                    echo $this->Form->control('muestra_id', ['options' => $muestras]);
                    echo $this->Form->control('poder_germinativo');
                    echo $this->Form->control('pureza');
                    echo $this->Form->control('materiales_inertes');
                    echo $this->Form->control('fecha_recepcion', ['empty' => true]);
                    echo $this->Form->control('fecha_modificacion', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
