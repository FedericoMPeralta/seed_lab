<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Behavior;

use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

class CodigoGeneratorBehaviorTest extends TestCase
{
    protected array $fixtures = ['app.Muestras'];
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

    public function testCodigoDeMuestraSeGeneraAutomaticamente()
    {
        $muestra = $this->Muestras->newEntity([
            'numero_precinto' => 'AUTO-GEN-001',
        ]);
        
        $this->Muestras->save($muestra);
        
        $this->assertNotEmpty($muestra->codigo);
        $this->assertStringStartsWith('SEED-', $muestra->codigo);
    }

    public function testFormatoCodigoAñoActual()
    {
        $muestra = $this->Muestras->newEntity(['numero_precinto' => 'FMT-001']);
        $this->Muestras->save($muestra);
        
        $añoActual = date('Y');
        $this->assertStringContainsString("-{$añoActual}-", $muestra->codigo);
    }

    public function testNumeroSecuencialTiene4Digitos()
    {
        $muestra = $this->Muestras->newEntity(['numero_precinto' => 'PAD-001']);
        $this->Muestras->save($muestra);
        
        $secuencia = substr($muestra->codigo, -4);
        
        $this->assertEquals(4, strlen($secuencia));
        $this->assertMatchesRegularExpression('/^\d{4}$/', $secuencia);
    }

    public function testSecuenciaIncrementaCorrectamente()
    {
        $m1 = $this->Muestras->newEntity(['numero_precinto' => 'SEQ-001']);
        $m2 = $this->Muestras->newEntity(['numero_precinto' => 'SEQ-002']);
        
        $this->Muestras->save($m1);
        $this->Muestras->save($m2);
        
        $num1 = (int)substr($m1->codigo, -4);
        $num2 = (int)substr($m2->codigo, -4);
        
        $this->assertEquals($num1 + 1, $num2);
    }

    public function testGenerarMultiplesCodigosSeguidos()
    {
        $codigos = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $m = $this->Muestras->newEntity(['numero_precinto' => "MULTI-{$i}"]);
            $this->Muestras->save($m);
            $codigos[] = $m->codigo;
        }
        
        $unicos = array_unique($codigos);
        $this->assertCount(5, $unicos);
    }
}