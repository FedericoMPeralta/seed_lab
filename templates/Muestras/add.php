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
            echo $this->Form->control('fecha_recepcion', [
                'label' => 'Fecha de Recepción',
                'type' => 'text',
                'class' => 'datepicker',
                'value' => date('d/m/Y'),
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('.datepicker');
    
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' || e.key === 'Delete') {
            return;
        }
        
        const value = e.target.value.replace(/\D/g, '');
        
        if (value.length >= 8 && e.key >= '0' && e.key <= '9') {
            e.preventDefault();
        }
    });
    
    input.addEventListener('input', function(e) {
        const cursorPos = e.target.selectionStart;
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = '';
        
        if (value.length > 0) {
            formattedValue = value.substring(0, 2);
        }
        if (value.length >= 3) {
            formattedValue += '/' + value.substring(2, 4);
        }
        if (value.length >= 5) {
            formattedValue += '/' + value.substring(4, 8);
        }
        
        e.target.value = formattedValue;
        
        let newCursorPos = cursorPos;
        if (cursorPos === 3 || cursorPos === 6) {
            newCursorPos = cursorPos + 1;
        }
        e.target.setSelectionRange(newCursorPos, newCursorPos);
    });
    
    input.addEventListener('blur', function(e) {
        const value = e.target.value;
        const parts = value.split('/');
        
        if (value && parts.length === 3) {
            const day = parseInt(parts[0]);
            const month = parseInt(parts[1]);
            const year = parseInt(parts[2]);
            
            if (day < 1 || day > 31 || month < 1 || month > 12 || year < 1900) {
                alert('Fecha inválida. Use formato dd/mm/aaaa');
                e.target.value = '';
            }
        }
    });
});
</script>