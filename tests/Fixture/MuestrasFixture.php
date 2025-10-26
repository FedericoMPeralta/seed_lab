<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class MuestrasFixture extends TestFixture
{
    public $import = ['table' => 'muestras'];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'codigo' => 'SEED-2025-0001',
                'numero_precinto' => 'A123',
                'empresa' => 'Monsanto',
                'especie' => 'Trigo',
                'cantidad_semillas' => 1000,
                'fecha_recepcion' => '2025-10-22 08:30:00',
                'fecha_modificacion' => '2025-10-22 08:30:00'
            ],
            [
                'id' => 2,
                'codigo' => 'SEED-2025-0002',
                'numero_precinto' => 'A124',
                'empresa' => 'Bayer',
                'especie' => 'Soja',
                'cantidad_semillas' => 800,
                'fecha_recepcion' => '2025-10-23 10:15:00',
                'fecha_modificacion' => '2025-10-23 10:15:00'
            ],
            [
                'id' => 3,
                'codigo' => 'SEED-2025-0003',
                'numero_precinto' => 'B789',
                'empresa' => null,
                'especie' => 'Maíz',
                'cantidad_semillas' => null,
                'fecha_recepcion' => '2025-10-20 14:00:00',
                'fecha_modificacion' => '2025-10-20 14:00:00'
            ]
        ];
        parent::init();
    }
}