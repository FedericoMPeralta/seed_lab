<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resultado $resultado
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Resultado'), ['action' => 'edit', $resultado->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Resultado'), ['action' => 'delete', $resultado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $resultado->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Resultados'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Resultado'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="resultados view content">
            <h3><?= h($resultado->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Muestra') ?></th>
                    <td><?= $resultado->hasValue('muestra') ? $this->Html->link($resultado->muestra->codigo, ['controller' => 'Muestras', 'action' => 'view', $resultado->muestra->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($resultado->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Poder Germinativo') ?></th>
                    <td><?= $resultado->poder_germinativo === null ? '' : $this->Number->format($resultado->poder_germinativo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pureza') ?></th>
                    <td><?= $resultado->pureza === null ? '' : $this->Number->format($resultado->pureza) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Recepcion') ?></th>
                    <td><?= h($resultado->fecha_recepcion) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fecha Modificacion') ?></th>
                    <td><?= h($resultado->fecha_modificacion) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Materiales Inertes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($resultado->materiales_inertes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>