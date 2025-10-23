<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Muestra $muestra
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $muestra->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $muestra->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Muestras'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="muestras form content">
            <?= $this->Form->create($muestra) ?>
            <fieldset>
                <legend><?= __('Edit Muestra') ?></legend>
                <?php
                    echo $this->Form->control('codigo');
                    echo $this->Form->control('numero_precinto');
                    echo $this->Form->control('empresa');
                    echo $this->Form->control('especie');
                    echo $this->Form->control('cantidad');
                    echo $this->Form->control('fecha_recepcion', ['empty' => true]);
                    echo $this->Form->control('fecha_modificacion', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
