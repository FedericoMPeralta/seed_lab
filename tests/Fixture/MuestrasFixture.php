<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MuestrasFixture
 */
class MuestrasFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'codigo' => 'Lorem ipsum dolor ',
                'numero_precinto' => 'Lorem ipsum dolor sit amet',
                'empresa' => 'Lorem ipsum dolor sit amet',
                'especie' => 'Lorem ipsum dolor sit amet',
                'cantidad' => 1,
                'fecha_recepcion' => '2025-10-23 22:59:24',
                'fecha_modificacion' => '2025-10-23 22:59:24',
            ],
        ];
        parent::init();
    }
}
