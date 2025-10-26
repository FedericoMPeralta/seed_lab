<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class MuestrasTableTest extends TestCase
{
    protected array $fixtures = ['app.Muestras', 'app.Resultados'];
    protected $Muestras;

    public function setUp(): void
    {
        parent::setUp();
        $this->Muestras = TableRegistry::getTableLocator()->get('Muestras');
    }

    public function tearDown(): void
    {
        unset($this->Muestras);
        parent::tearDown();
    }

    public function testNumeroPrecintoEsObligatorio()
    {
        $muestra = $this->Muestras->newEntity([
            'empresa' => 'Sin Precinto SA',
        ]);
        
        $this->assertFalse($this->Muestras->save($muestra));
        $this->assertArrayHasKey('numero_precinto', $muestra->getErrors());
    }

    public function testPrecintoDuplicadoNoPermitido()
    {
        $m1 = $this->Muestras->newEntity(['numero_precinto' => 'DUPL-123']);
        $this->Muestras->save($m1);
        
        $m2 = $this->Muestras->newEntity(['numero_precinto' => 'DUPL-123']);
        $resultado = $this->Muestras->save($m2);
        
        $this->assertFalse($resultado);
        $this->assertArrayHasKey('numero_precinto', $m2->getErrors());
    }

    public function testCantidadNegativaEsRechazada()
    {
        $muestra = $this->Muestras->newEntity([
            'numero_precinto' => 'NEG-999',
            'cantidad_semillas' => -100
        ]);
        
        $this->assertFalse($this->Muestras->save($muestra));
    }

    public function testCamposOpcionalesAceptanNull()
    {
        $muestra = $this->Muestras->newEntity([
            'numero_precinto' => 'MINIMO-001'
        ]);
        
        $guardado = $this->Muestras->save($muestra);
        
        $this->assertNotFalse($guardado);
        $this->assertNull($guardado->empresa);
        $this->assertNull($guardado->especie);
    }

    public function testRelacionConResultadosEsCascada()
    {
        $assoc = $this->Muestras->getAssociation('Resultados');
        
        $this->assertNotNull($assoc);
        $this->assertTrue($assoc->getDependent());
    }

    public function testLongitudMaximaEmpresa()
    {
        $nombreLargo = str_repeat('X', 300);
        
        $muestra = $this->Muestras->newEntity([
            'numero_precinto' => 'LARGO-001',
            'empresa' => $nombreLargo
        ]);
        
        $this->assertFalse($this->Muestras->save($muestra));
        $this->assertArrayHasKey('empresa', $muestra->getErrors());
    }

    public function testGuardadoCompletoCamposCorrectos()
    {
        $muestra = $this->Muestras->newEntity([
            'numero_precinto' => 'COMPLETO-001',
            'empresa' => 'Test Company',
            'especie' => 'Cebada',
            'cantidad_semillas' => 2500
        ]);
        
        $guardado = $this->Muestras->save($muestra);
        
        $this->assertNotFalse($guardado);
        $this->assertEquals('Test Company', $guardado->empresa);
        $this->assertEquals(2500, $guardado->cantidad_semillas);
    }

    public function testPrecintoConCaracteresEspeciales()
    {
        $muestra = $this->Muestras->newEntity([
            'numero_precinto' => 'TEST-#@!-123'
        ]);
        
        $guardado = $this->Muestras->save($muestra);
        $this->assertNotFalse($guardado);
    }
}