<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Resultado extends Entity
{
    protected array $_accessible = [
        'muestra_id' => true,
        'poder_germinativo' => true,
        'pureza' => true,
        'materiales_inertes' => true,
        'fecha_recepcion' => true,
        'fecha_modificacion' => true,
        'muestra' => true,
    ];
}
