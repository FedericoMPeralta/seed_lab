<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ResultadosFixture extends TestFixture
{
    public $import = ['table' => 'resultados'];

    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'muestra_id' => 1,
                'poder_germinativo' => 85.00,
                'pureza' => 90.00,
                'materiales_inertes' => 'Restos de paja',
                'fecha_recepcion' => '2025-10-24 09:00:00',
                'fecha_modificacion' => '2025-10-24 09:00:00',
            ],
            [
                'id' => 2,
                'muestra_id' => 1,
                'poder_germinativo' => 87.50,
                'pureza' => 92.00,
                'materiales_inertes' => null,
                'fecha_recepcion' => '2025-10-26 11:30:00',
                'fecha_modificacion' => '2025-10-26 11:30:00',
            ],
            [
                'id' => 3,
                'muestra_id' => 2,
                'poder_germinativo' => 92.00,
                'pureza' => 95.00,
                'materiales_inertes' => 'Mínimo',
                'fecha_recepcion' => '2025-10-25 10:00:00',
                'fecha_modificacion' => '2025-10-25 10:00:00',
            ],
        ];
        parent::init();
    }
}