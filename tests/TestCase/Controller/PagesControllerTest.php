<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class PagesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected array $fixtures = ['app.Muestras', 'app.Resultados'];

    public function testHomeMuestraEstadisticas()
    {
        $this->get('/');
        
        $this->assertResponseOk();
        $this->assertResponseContains('SEED LAB - INASE');
        $this->assertResponseContains('Sistema de Gestión');
    }

    public function testHomeCalculaEstadisticasCorrectamente()
    {
        $this->get('/');
        
        $totalMuestras = $this->viewVariable('totalMuestras');
        $conResultados = $this->viewVariable('muestrasConResultados');
        
        $this->assertEquals(3, $totalMuestras);
        $this->assertGreaterThan(0, $conResultados);
    }

    public function testHomeTieneLinkAMuestras()
    {
        $this->get('/');
        
        $this->assertResponseContains('Gestión de Muestras');
        $this->assertResponseContains('/muestras');
    }

    public function testHomeTieneLinkAReportes()
    {
        $this->get('/');
        
        $this->assertResponseContains('Reportes');
        $this->assertResponseContains('reporte');
    }
}