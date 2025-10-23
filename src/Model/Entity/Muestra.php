<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Muestra Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $numero_precinto
 * @property string|null $empresa
 * @property string|null $especie
 * @property int|null $cantidad
 * @property \Cake\I18n\DateTime|null $fecha_recepcion
 * @property \Cake\I18n\DateTime|null $fecha_modificacion
 *
 * @property \App\Model\Entity\Resultado[] $resultados
 */
class Muestra extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'codigo' => true,
        'numero_precinto' => true,
        'empresa' => true,
        'especie' => true,
        'cantidad' => true,
        'fecha_recepcion' => true,
        'fecha_modificacion' => true,
        'resultados' => true,
    ];
}
