<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Muestra extends Entity
{
    protected array $_accessible = [
        'codigo' => false,
        'numero_precinto' => true,
        'empresa' => true,
        'especie' => true,
        'cantidad_semillas' => true,
        'fecha_recepcion' => false,
        'fecha_modificacion' => false,
        'resultados' => true,
    ];
}