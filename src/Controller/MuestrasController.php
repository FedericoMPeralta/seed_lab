<?php
declare(strict_types=1);

namespace App\Controller;

class MuestrasController extends AppController
{
    public function index()
    {
        $query = $this->Muestras->find()->contain(['Resultados']);
        $muestras = $this->paginate($query);

        $this->set(compact('muestras'));
    }

    public function view($id = null)
    {
        if (!is_numeric($id)) {
            $this->Flash->error(__('ID de muestra inválido.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $muestra = $this->Muestras->get($id, contain: ['Resultados']);
            $this->set(compact('muestra'));
        } catch (\Exception $e) {
            $this->Flash->error(__('Muestra no encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    public function add()
    {
        $muestra = $this->Muestras->newEmptyEntity();
        $referer = $this->request->getQuery('referer', 'index');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if (isset($data['cantidad_semillas']) && $data['cantidad_semillas'] !== '' && $data['cantidad_semillas'] < 0) {
                $this->Flash->error(__('La cantidad de semillas no puede ser negativa.'));
                $this->set(compact('muestra', 'referer'));
                return;
            }
            
            if (!empty($data['fecha_recepcion'])) {
                $fechaObj = \DateTime::createFromFormat('d/m/Y', $data['fecha_recepcion']);
                if ($fechaObj) {
                    $data['fecha_recepcion'] = $fechaObj->format('Y-m-d');
                }
            } else {
                $data['fecha_recepcion'] = null;
            }
            
            $muestra = $this->Muestras->patchEntity($muestra, $data);
            if ($this->Muestras->save($muestra)) {
                $this->Flash->success(__('Muestra creada con código {0} exitosamente.', $muestra->codigo));
                
                if ($referer === 'home') {
                    return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar la muestra. Por favor, intente nuevamente.'));
        }
        
        $this->set(compact('muestra', 'referer'));
    }

    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->Flash->error(__('ID de muestra inválido.'));
            return $this->redirect(['action' => 'index']);
        }
    
        try {
            $muestra = $this->Muestras->get($id, contain: ['Resultados']);
        } catch (\Exception $e) {
            $this->Flash->error(__('Muestra no encontrada.'));
            return $this->redirect(['action' => 'index']);
        }
    
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            if (isset($data['cantidad_semillas']) && $data['cantidad_semillas'] !== '' && $data['cantidad_semillas'] < 0) {
                $this->Flash->error(__('La cantidad de semillas no puede ser negativa.'));
                $this->set(compact('muestra'));
                return;
            }
            
            if (!empty($data['fecha_recepcion'])) {
                $fechaObj = \DateTime::createFromFormat('d/m/Y', $data['fecha_recepcion']);
                if ($fechaObj) {
                    $data['fecha_recepcion'] = $fechaObj->format('Y-m-d');
                }
            }
            
            $muestra = $this->Muestras->patchEntity($muestra, $data);
            if ($this->Muestras->save($muestra)) {
                $this->Flash->success(__('Actualización de muestra {0} exitosa.', $muestra->codigo));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('No se pudo actualizar la muestra. Por favor, intente nuevamente.'));
        }
        $this->set(compact('muestra'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        if (!is_numeric($id)) {
            $this->Flash->error(__('ID de muestra inválido.'));
            return $this->redirect(['action' => 'index']);
        }

        try {
            $muestra = $this->Muestras->get($id, contain: ['Resultados']);
        } catch (\Exception $e) {
            $this->Flash->error(__('Muestra no encontrada.'));
            return $this->redirect(['action' => 'index']);
        }

        $cantResultados = count($muestra->resultados);
        $codigo = $muestra->codigo;
        
        if ($this->Muestras->delete($muestra)) {
            if ($cantResultados > 0) {
                $this->Flash->success(__('Muestra {0} y sus {1} resultado(s) eliminados exitosamente.', $codigo, $cantResultados));
            } else {
                $this->Flash->success(__('Muestra {0} eliminada exitosamente.', $codigo));
            }
        } else {
            $this->Flash->error(__('No se pudo eliminar la muestra. Por favor, intente nuevamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function reporte()
    {
        $fechaDesde = $this->request->getQuery('fecha_desde');
        $fechaHasta = $this->request->getQuery('fecha_hasta');
        $tipoFecha = $this->request->getQuery('tipo_fecha', 'muestra');
        $sort = $this->request->getQuery('sort', 'codigo');
        $direction = $this->request->getQuery('direction', 'asc');
        $modo = $this->request->getQuery('modo', 'resumen');
        
        $query = $this->buildReporteQuery($fechaDesde, $fechaHasta, $tipoFecha);
        $muestras = $query->all();
        
        if ($modo === 'resumen') {
            $muestrasArray = $this->buildModoResumen($muestras, $sort, $direction);
        } else {
            $muestrasArray = $this->buildModoDetallado($muestras, $sort, $direction);
        }
        
        $especies = $this->getEspeciesDistintas();
        
        $this->set(compact('muestrasArray', 'especies', 'modo', 'tipoFecha', 'sort', 'direction'));
        $this->set('muestras', $muestrasArray);
    }
    
    private function buildReporteQuery($fechaDesde, $fechaHasta, $tipoFecha)
    {
        $query = $this->Muestras->find();
        
        if ($this->request->getQuery('especie')) {
            $query->where(['Muestras.especie' => $this->request->getQuery('especie')]);
        }
        
        if ($fechaDesde || $fechaHasta) {
            if ($tipoFecha === 'resultado') {
                $muestrasIds = $this->Muestras->Resultados->find()
                    ->select(['muestra_id'])
                    ->distinct(['muestra_id']);
                
                if ($fechaDesde) {
                    $fechaDesdeObj = \DateTime::createFromFormat('d/m/Y', $fechaDesde);
                    if ($fechaDesdeObj) {
                        $muestrasIds->where(['Resultados.fecha_recepcion >=' => $fechaDesdeObj->format('Y-m-d') . ' 00:00:00']);
                    }
                }
                if ($fechaHasta) {
                    $fechaHastaObj = \DateTime::createFromFormat('d/m/Y', $fechaHasta);
                    if ($fechaHastaObj) {
                        $muestrasIds->where(['Resultados.fecha_recepcion <=' => $fechaHastaObj->format('Y-m-d') . ' 23:59:59']);
                    }
                }
                
                $ids = $muestrasIds->all()->map(function($row) {
                    return $row->muestra_id;
                })->toArray();
                
                if (!empty($ids)) {
                    $query->where(['Muestras.id IN' => $ids]);
                } else {
                    $query->where(['1 = 0']);
                }
            } else {
                if ($fechaDesde) {
                    $fechaDesdeObj = \DateTime::createFromFormat('d/m/Y', $fechaDesde);
                    if ($fechaDesdeObj) {
                        $query->where(['Muestras.fecha_recepcion >=' => $fechaDesdeObj->format('Y-m-d') . ' 00:00:00']);
                    }
                }
                if ($fechaHasta) {
                    $fechaHastaObj = \DateTime::createFromFormat('d/m/Y', $fechaHasta);
                    if ($fechaHastaObj) {
                        $query->where(['Muestras.fecha_recepcion <=' => $fechaHastaObj->format('Y-m-d') . ' 23:59:59']);
                    }
                }
            }
        }
        
        $query->contain(['Resultados' => function ($q) use ($fechaDesde, $fechaHasta, $tipoFecha) {
            if ($tipoFecha === 'resultado' && ($fechaDesde || $fechaHasta)) {
                if ($fechaDesde) {
                    $fechaDesdeObj = \DateTime::createFromFormat('d/m/Y', $fechaDesde);
                    if ($fechaDesdeObj) {
                        $q->where(['Resultados.fecha_recepcion >=' => $fechaDesdeObj->format('Y-m-d') . ' 00:00:00']);
                    }
                }
                if ($fechaHasta) {
                    $fechaHastaObj = \DateTime::createFromFormat('d/m/Y', $fechaHasta);
                    if ($fechaHastaObj) {
                        $q->where(['Resultados.fecha_recepcion <=' => $fechaHastaObj->format('Y-m-d') . ' 23:59:59']);
                    }
                }
            }
            return $q->order(['Resultados.fecha_recepcion' => 'DESC']);
        }]);
        
        return $query;
    }
    
    private function buildModoResumen($muestras, $sort, $direction)
    {
        $muestrasConResultados = [];
        
        foreach ($muestras as $muestra) {
            if (!empty($muestra->resultados)) {
                $muestra->resultados = [$muestra->resultados[0]];
                $muestrasConResultados[] = $muestra;
            }
        }
        
        usort($muestrasConResultados, function($a, $b) use ($sort, $direction) {
            return $this->compareForSort($a, $b, $sort, $direction, true);
        });
        
        return $muestrasConResultados;
    }
    
    private function buildModoDetallado($muestras, $sort, $direction)
    {
        $resultadosFlat = [];
        
        foreach ($muestras as $muestra) {
            if (!empty($muestra->resultados)) {
                foreach ($muestra->resultados as $resultado) {
                    $resultadosFlat[] = [
                        'muestra' => $muestra,
                        'resultado' => $resultado
                    ];
                }
            }
        }
        
        usort($resultadosFlat, function($a, $b) use ($sort, $direction) {
            return $this->compareForSort($a, $b, $sort, $direction, false);
        });
        
        return $resultadosFlat;
    }
    
    private function compareForSort($a, $b, $sort, $direction, $isResumen)
    {
        $asc = ($direction === 'asc') ? 1 : -1;
        
        if ($isResumen) {
            $aMuestra = $a;
            $bMuestra = $b;
            $aResultado = !empty($a->resultados) ? $a->resultados[0] : null;
            $bResultado = !empty($b->resultados) ? $b->resultados[0] : null;
        } else {
            $aMuestra = $a['muestra'];
            $bMuestra = $b['muestra'];
            $aResultado = $a['resultado'];
            $bResultado = $b['resultado'];
        }
        
        $codigoFallback = strcasecmp($aMuestra->codigo, $bMuestra->codigo);
        
        switch ($sort) {
            case 'poder_germinativo':
                $aVal = $aResultado && $aResultado->poder_germinativo !== null ? $aResultado->poder_germinativo : null;
                $bVal = $bResultado && $bResultado->poder_germinativo !== null ? $bResultado->poder_germinativo : null;
                return $this->compareValues($aVal, $bVal, $asc, $codigoFallback, 'numeric');
                
            case 'pureza':
                $aVal = $aResultado && $aResultado->pureza !== null ? $aResultado->pureza : null;
                $bVal = $bResultado && $bResultado->pureza !== null ? $bResultado->pureza : null;
                return $this->compareValues($aVal, $bVal, $asc, $codigoFallback, 'numeric');
                
            case 'materiales_inertes':
                $aVal = $aResultado && $aResultado->materiales_inertes !== null ? $aResultado->materiales_inertes : null;
                $bVal = $bResultado && $bResultado->materiales_inertes !== null ? $bResultado->materiales_inertes : null;
                return $this->compareValues($aVal, $bVal, $asc, $codigoFallback, 'numeric');
                
            case 'fecha_analisis':
                $aVal = $aResultado && $aResultado->fecha_recepcion !== null ? $aResultado->fecha_recepcion->toDateTimeString() : null;
                $bVal = $bResultado && $bResultado->fecha_recepcion !== null ? $bResultado->fecha_recepcion->toDateTimeString() : null;
                return $this->compareValues($aVal, $bVal, $asc, $codigoFallback, 'string');
                
            case 'empresa':
                return $this->compareValues($aMuestra->empresa, $bMuestra->empresa, $asc, $codigoFallback, 'string');
                
            case 'especie':
                return $this->compareValues($aMuestra->especie, $bMuestra->especie, $asc, $codigoFallback, 'string');
                
            case 'fecha_recepcion':
                $aVal = $aMuestra->fecha_recepcion !== null ? $aMuestra->fecha_recepcion->toDateTimeString() : null;
                $bVal = $bMuestra->fecha_recepcion !== null ? $bMuestra->fecha_recepcion->toDateTimeString() : null;
                return $this->compareValues($aVal, $bVal, $asc, $codigoFallback, 'string');
                
            case 'codigo':
                return strcasecmp($aMuestra->codigo, $bMuestra->codigo) * $asc;
                
            default:
                return $codigoFallback * $asc;
        }
    }
    
    private function compareValues($aVal, $bVal, $asc, $codigoFallback, $type)
    {
        if ($aVal === null && $bVal === null) {
            return $codigoFallback;
        }
        if ($aVal === null) return 1;
        if ($bVal === null) return -1;
        
        if ($type === 'numeric') {
            $cmp = ($aVal <=> $bVal) * $asc;
        } else {
            $cmp = strcasecmp($aVal, $bVal) * $asc;
        }
        
        return $cmp === 0 ? $codigoFallback : $cmp;
    }
    
    private function getEspeciesDistintas()
    {
        return $this->Muestras->find('list', [
            'keyField' => 'especie',
            'valueField' => 'especie',
        ])
        ->select(['especie'])
        ->where(['especie IS NOT' => null])
        ->distinct(['especie'])
        ->order(['especie' => 'ASC'])
        ->toArray();
    }
}