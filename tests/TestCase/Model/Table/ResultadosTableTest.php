<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class ResultadosTableTest extends TestCase
{
    protected array $fixtures = ['app.Muestras', 'app.Resultados'];
    protected $Resultados;

    public function setUp(): void
    {
        parent::setUp();
        $this->Resultados = TableRegistry::getTableLocator()->get('Resultados');
    }

    public function tearDown(): void
    {
        unset($this->Resultados);
        parent::tearDown();
    }

    public function testPoderGerminativoMayorA100Rechazado()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 1,
            'poder_germinativo' => 105.5
        ]);
        
        $this->assertFalse($this->Resultados->save($resultado));
        $this->assertArrayHasKey('poder_germinativo', $resultado->getErrors());
    }

    public function testPoderGerminativoNegativoRechazado()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 1,
            'poder_germinativo' => -5
        ]);
        
        $this->assertFalse($this->Resultados->save($resultado));
    }

    public function testPurezaFueraRangoSuperior()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 1,
            'pureza' => 100.01
        ]);
        
        $this->assertFalse($this->Resultados->save($resultado));
    }

    public function testPurezaFueraRangoInferior()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 1,
            'pureza' => -0.01
        ]);
        
        $this->assertFalse($this->Resultados->save($resultado));
    }

    public function testGuardadoConValoresLimite()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 1,
            'poder_germinativo' => 0,
            'pureza' => 100
        ]);
        
        $guardado = $this->Resultados->save($resultado);
        
        $this->assertNotFalse($guardado);
        $this->assertEquals(0, $guardado->poder_germinativo);
        $this->assertEquals(100, $guardado->pureza);
    }

    public function testGuardadoConDecimales()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 2,
            'poder_germinativo' => 87.55,
            'pureza' => 94.23
        ]);
        
        $guardado = $this->Resultados->save($resultado);
        
        $this->assertNotFalse($guardado);
        $this->assertEquals(87.55, $guardado->poder_germinativo);
    }

    public function testCamposOpcionalesNulos()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 1
        ]);
        
        $guardado = $this->Resultados->save($resultado);
        
        $this->assertNotFalse($guardado);
        $this->assertNull($guardado->poder_germinativo);
        $this->assertNull($guardado->pureza);
    }

    public function testRelacionConMuestrasEsInner()
    {
        $assoc = $this->Resultados->getAssociation('Muestras');
        
        $this->assertNotNull($assoc);
        $this->assertEquals('INNER', $assoc->getJoinType());
    }

    public function testMuestraIdInexistenteRechazado()
    {
        $resultado = $this->Resultados->newEntity([
            'muestra_id' => 99999,
            'poder_germinativo' => 85
        ]);
        
        $this->assertFalse($this->Resultados->save($resultado));
        $this->assertArrayHasKey('muestra_id', $resultado->getErrors());
    }

    public function testMismasMuestrasVariosResultados()
    {
        $r1 = $this->Resultados->newEntity([
            'muestra_id' => 2,
            'poder_germinativo' => 80
        ]);
        
        $r2 = $this->Resultados->newEntity([
            'muestra_id' => 2,
            'poder_germinativo' => 85
        ]);
        
        $this->assertNotFalse($this->Resultados->save($r1));
        $this->assertNotFalse($this->Resultados->save($r2));
        
        $count = $this->Resultados->find()->where(['muestra_id' => 2])->count();
        $this->assertGreaterThanOrEqual(2, $count);
    }
}