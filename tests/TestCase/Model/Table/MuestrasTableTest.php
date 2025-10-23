<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MuestrasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MuestrasTable Test Case
 */
class MuestrasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MuestrasTable
     */
    protected $Muestras;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Muestras',
        'app.Resultados',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Muestras') ? [] : ['className' => MuestrasTable::class];
        $this->Muestras = $this->getTableLocator()->get('Muestras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Muestras);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MuestrasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\MuestrasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
