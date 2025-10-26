<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ResultadosControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Muestras', 'app.Resultados'];

    public function setUp(): void
    {
        parent::setUp();
        $this->enableCsrfToken();
        $this->enableSecurityToken();
    }

    public function testAgregarResultadoConDatosValidos()
    {
        $this->post('/resultados/add', [
            'muestra_id' => 2,
            'poder_germinativo' => 88.5,
            'pureza' => 93.2,
            'materiales_inertes' => 'Tierra fina',
            'fecha_recepcion' => '28/10/2025'
        ]);
        
        $this->assertRedirect();
        
        $resultados = $this->getTableLocator()->get('Resultados');
        $nuevo = $resultados->find()->orderBy(['id' => 'DESC'])->first();
        
        $this->assertEquals(2, $nuevo->muestra_id);
        $this->assertEquals(88.5, $nuevo->poder_germinativo);
    }

    public function testEditarResultadoExistente()
    {
        $this->post('/resultados/edit/1', [
            'muestra_id' => 1,
            'poder_germinativo' => 86.0,
            'pureza' => 91.5,
            'materiales_inertes' => 'Actualizado',
            'fecha_recepcion' => '30/10/2025'
        ]);
        
        $this->assertRedirect(['controller' => 'Muestras', 'action' => 'view', 1]);
        
        $resultados = $this->getTableLocator()->get('Resultados');
        $editado = $resultados->get(1);
        
        $this->assertEquals(86.0, $editado->poder_germinativo);
    }

    public function testEliminarResultadoVuelveADetalleMuestra()
    {
        $this->post('/resultados/delete/1');
        
        $this->assertRedirect(['controller' => 'Muestras', 'action' => 'view', 1]);
    }

    public function testRefererHomeRedirigeCorrectamente()
    {
        $this->post('/resultados/add?referer=home', [
            'muestra_id' => 2,
            'poder_germinativo' => 80,
            'fecha_recepcion' => '01/11/2025'
        ]);
        
        $this->assertRedirect(['controller' => 'Pages', 'action' => 'home']);
    }

    public function testConversionFechaFormatoDMY()
    {
        $this->post('/resultados/add', [
            'muestra_id' => 3,
            'poder_germinativo' => 85,
            'fecha_recepcion' => '2025-11-15'
        ]);
    
        $resultados = $this->getTableLocator()->get('Resultados');
        $nuevo = $resultados->find()
            ->where(['muestra_id' == 3])
            ->orderBy(['id' => 'DESC'])
            ->first();
    
        $this->assertEquals('2025-11-15', $nuevo->fecha_recepcion->format('Y-m-d'));
    }
    

}