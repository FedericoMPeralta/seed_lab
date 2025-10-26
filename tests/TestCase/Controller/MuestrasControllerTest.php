<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class MuestrasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Muestras', 'app.Resultados'];

    public function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    public function testIndexMuestraListadoDeMuestras()
    {
        $this->get('/muestras');
        
        $this->assertResponseOk();
        $this->assertResponseContains('SEED-2025-0001');
        $this->assertResponseContains('Listado de Muestras');
    }

    public function testVerDetalleConIdValido()
    {
        $this->get('/muestras/view/1');
        
        $this->assertResponseOk();
        $this->assertResponseContains('SEED-2025-0001');
        $this->assertResponseContains('A123');
    }

    public function testCrearMuestraNuevaGeneraCodigoDeMuestra()
    {
        $this->post('/muestras/add', [
            'numero_precinto' => 'NUEVO-999',
            'empresa' => 'Test Corp',
            'especie' => 'Avena',
            'cantidad_semillas' => 500,
            'fecha_recepcion' => '01/11/2025'
        ]);
        
        $this->assertRedirect(['action' => 'index']);
        
        $muestras = $this->getTableLocator()->get('Muestras');
        $nueva = $muestras->find()->where(['numero_precinto' => 'NUEVO-999'])->first();
        
        $this->assertNotNull($nueva);
        $this->assertMatchesRegularExpression('/^SEED-\d{4}-\d{4}$/', $nueva->codigo);
    }

    public function testEditarActualizaFecha()
    {
        $this->post('/muestras/edit/1', [
            'numero_precinto' => 'A123',
            'empresa' => 'Monsanto Actualizada',
            'especie' => 'Trigo',
            'fecha_recepcion' => '15/11/2025'
        ]);
        
        $this->assertRedirect(['action' => 'view', 1]);
        
        $muestras = $this->getTableLocator()->get('Muestras');
        $actualizada = $muestras->get(1);
        
        $this->assertEquals('Monsanto Actualizada', $actualizada->empresa);
        $this->assertEquals('2025-11-15', $actualizada->fecha_recepcion->format('Y-m-d'));
    }

    public function testEliminarMuestraEliminaResultadosEnCascada()
    {
        $resultados = $this->getTableLocator()->get('Resultados');
        $antesCount = $resultados->find()->where(['muestra_id' => 1])->count();
        $this->assertGreaterThan(0, $antesCount);
        
        $this->post('/muestras/delete/1');
        
        $this->assertRedirect(['action' => 'index']);
        
        $despuesCount = $resultados->find()->where(['muestra_id' => 1])->count();
        $this->assertEquals(0, $despuesCount);
    }

    public function testReporteModoResumenSoloMuestraUltimosResultados()
    {
        $this->get('/muestras/reporte?modo=resumen');
        
        $this->assertResponseOk();
        $this->assertResponseContains('Modo Resumen');
        
        $viewVars = $this->viewVariable('muestras');
        $muestra1 = null;
        foreach ($viewVars as $m) {
            if ($m->id == 1) {
                $muestra1 = $m;
                break;
            }
        }
        
        $this->assertNotNull($muestra1);
        $this->assertCount(1, $muestra1->resultados);
    }

    public function testReporteFiltradoPorEspecie()
    {
        $this->get('/muestras/reporte?especie=Trigo');
        
        $this->assertResponseOk();
        $this->assertResponseContains('Trigo');
    }

    public function testReporteOrdenamientoPorCodigo()
    {
        $this->get('/muestras/reporte?sort=codigo&direction=desc');
        
        $this->assertResponseOk();
    }
}