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
        $query = $this->Muestras->find();
    
        if ($this->request->getQuery('especie')) {
            $query->where(['Muestras.especie' => $this->request->getQuery('especie')]);
        }
    
        $fechaDesde = $this->request->getQuery('fecha_desde');
        $fechaHasta = $this->request->getQuery('fecha_hasta');
        $tipoFecha = $this->request->getQuery('tipo_fecha', 'muestra');
        
        if ($fechaDesde || $fechaHasta) {
            if ($tipoFecha === 'resultado') {
                $query->matching('Resultados', function ($q) use ($fechaDesde, $fechaHasta) {
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
                    return $q;
                });
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
    
        $sort = $this->request->getQuery('sort', 'codigo');
        $direction = $this->request->getQuery('direction', 'asc');
        $modo = $this->request->getQuery('modo', 'resumen');
        
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
    
        $muestras = $query->all();
    
        if ($modo === 'resumen') {
            foreach ($muestras as $muestra) {
                if (!empty($muestra->resultados)) {
                    $muestra->resultados = [$muestra->resultados[0]];
                }
            }
            
            $muestrasArray = $muestras->toArray();
    
            usort($muestrasArray, function($a, $b) use ($sort, $direction) {
                $asc = ($direction === 'asc') ? 1 : -1;
                
                if ($sort === 'poder_germinativo') {
                    $aVal = !empty($a->resultados) && $a->resultados[0]->poder_germinativo !== null ? $a->resultados[0]->poder_germinativo : null;
                    $bVal = !empty($b->resultados) && $b->resultados[0]->poder_germinativo !== null ? $b->resultados[0]->poder_germinativo : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'pureza') {
                    $aVal = !empty($a->resultados) && $a->resultados[0]->pureza !== null ? $a->resultados[0]->pureza : null;
                    $bVal = !empty($b->resultados) && $b->resultados[0]->pureza !== null ? $b->resultados[0]->pureza : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'materiales_inertes') {
                    $aVal = !empty($a->resultados) && $a->resultados[0]->materiales_inertes !== null ? $a->resultados[0]->materiales_inertes : null;
                    $bVal = !empty($b->resultados) && $b->resultados[0]->materiales_inertes !== null ? $b->resultados[0]->materiales_inertes : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'fecha_analisis') {
                    $aVal = !empty($a->resultados) && $a->resultados[0]->fecha_recepcion !== null ? $a->resultados[0]->fecha_recepcion->toDateTimeString() : null;
                    $bVal = !empty($b->resultados) && $b->resultados[0]->fecha_recepcion !== null ? $b->resultados[0]->fecha_recepcion->toDateTimeString() : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'empresa') {
                    $aVal = $a->empresa;
                    $bVal = $b->empresa;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = strcasecmp($aVal, $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'especie') {
                    $aVal = $a->especie;
                    $bVal = $b->especie;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = strcasecmp($aVal, $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'fecha_recepcion') {
                    $aVal = $a->fecha_recepcion !== null ? $a->fecha_recepcion->toDateTimeString() : null;
                    $bVal = $b->fecha_recepcion !== null ? $b->fecha_recepcion->toDateTimeString() : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a->codigo, $b->codigo);
                    }
                    return $cmp;
                }
                
                return strcasecmp($a->codigo, $b->codigo) * $asc;
            });
        } else {
            $resultadosFlat = [];
            foreach ($muestras as $muestra) {
                if (!empty($muestra->resultados)) {
                    foreach ($muestra->resultados as $resultado) {
                        $resultadosFlat[] = [
                            'muestra' => $muestra,
                            'resultado' => $resultado
                        ];
                    }
                } else {
                    $resultadosFlat[] = [
                        'muestra' => $muestra,
                        'resultado' => null
                    ];
                }
            }
            
            usort($resultadosFlat, function($a, $b) use ($sort, $direction) {
                $asc = ($direction === 'asc') ? 1 : -1;
                
                if ($sort === 'poder_germinativo') {
                    $aVal = $a['resultado'] && $a['resultado']->poder_germinativo !== null ? $a['resultado']->poder_germinativo : null;
                    $bVal = $b['resultado'] && $b['resultado']->poder_germinativo !== null ? $b['resultado']->poder_germinativo : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'pureza') {
                    $aVal = $a['resultado'] && $a['resultado']->pureza !== null ? $a['resultado']->pureza : null;
                    $bVal = $b['resultado'] && $b['resultado']->pureza !== null ? $b['resultado']->pureza : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'materiales_inertes') {
                    $aVal = $a['resultado'] && $a['resultado']->materiales_inertes !== null ? $a['resultado']->materiales_inertes : null;
                    $bVal = $b['resultado'] && $b['resultado']->materiales_inertes !== null ? $b['resultado']->materiales_inertes : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'fecha_analisis') {
                    $aVal = $a['resultado'] && $a['resultado']->fecha_recepcion !== null ? $a['resultado']->fecha_recepcion->toDateTimeString() : null;
                    $bVal = $b['resultado'] && $b['resultado']->fecha_recepcion !== null ? $b['resultado']->fecha_recepcion->toDateTimeString() : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'empresa') {
                    $aVal = $a['muestra']->empresa;
                    $bVal = $b['muestra']->empresa;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = strcasecmp($aVal, $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'especie') {
                    $aVal = $a['muestra']->especie;
                    $bVal = $b['muestra']->especie;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = strcasecmp($aVal, $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'fecha_recepcion') {
                    $aVal = $a['muestra']->fecha_recepcion !== null ? $a['muestra']->fecha_recepcion->toDateTimeString() : null;
                    $bVal = $b['muestra']->fecha_recepcion !== null ? $b['muestra']->fecha_recepcion->toDateTimeString() : null;
                    
                    if ($aVal === null && $bVal === null) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    $cmp = ($aVal <=> $bVal) * $asc;
                    if ($cmp === 0) {
                        return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
                    }
                    return $cmp;
                }
                
                if ($sort === 'codigo') {
                    $aVal = $a['muestra']->codigo;
                    $bVal = $b['muestra']->codigo;
                    
                    if ($aVal === null && $bVal === null) return 0;
                    if ($aVal === null) return 1;
                    if ($bVal === null) return -1;
                    
                    return strcasecmp($aVal, $bVal) * $asc;
                }
                
                return strcasecmp($a['muestra']->codigo, $b['muestra']->codigo);
            });
            
            $muestrasArray = $resultadosFlat;
        }
    
        $especies = $this->Muestras->find('list', [
            'keyField' => 'especie',
            'valueField' => 'especie',
        ])
        ->select(['especie'])
        ->where(['especie IS NOT' => null])
        ->distinct(['especie'])
        ->order(['especie' => 'ASC'])
        ->toArray();
    
        $this->set(compact('muestrasArray', 'especies', 'modo', 'tipoFecha', 'sort', 'direction'));
        $this->set('muestras', $muestrasArray);
    }    
}