<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\EventInterface;
use ArrayObject;

class CodigoGeneratorBehavior extends Behavior
{
    public function beforeSave(EventInterface $event, $entity, ArrayObject $options)
    {
        if ($entity->isNew() && empty($entity->codigo)) {
            $entity->codigo = $this->generarCodigoUnico();
        }
    }

    private function generarCodigoUnico(): string
    {
        $year = date('Y');
        $prefix = "SEED-{$year}-";
        
        $ultimoRegistro = $this->table()->find()
            ->where(['codigo LIKE' => "{$prefix}%"])
            ->order(['codigo' => 'DESC'])
            ->first();

        if ($ultimoRegistro) {
            $ultimoNumero = (int)substr($ultimoRegistro->codigo, -4);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return $prefix . str_pad((string)$nuevoNumero, 4, '0', STR_PAD_LEFT);
    }
}