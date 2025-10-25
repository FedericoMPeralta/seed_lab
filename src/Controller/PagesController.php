<?php
declare(strict_types=1);

namespace App\Controller;

class PagesController extends AppController
{
    public function home()
    {
        $muestrasTable = $this->fetchTable('Muestras');
        
        $totalMuestras = $muestrasTable->find()->count();
        
        $muestrasConResultados = $muestrasTable->find()
            ->innerJoinWith('Resultados')
            ->select(['Muestras.id'])
            ->distinct()
            ->count();
        
        $muestrasSinResultados = $totalMuestras - $muestrasConResultados;
        
        $this->set(compact('totalMuestras', 'muestrasConResultados', 'muestrasSinResultados'));
    }
}