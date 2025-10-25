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
            
            if (empty($data['numero_precinto'])) {
                $this->Flash->error(__('El número de precinto es obligatorio.'));
                $this->set(compact('muestra', 'referer'));
                return;
            }
            
            if (isset($data['cantidad_semillas']) && $data['cantidad_semillas'] !== '' && $data['cantidad_semillas'] < 0) {
                $this->Flash->error(__('La cantidad de semillas no puede ser negativa.'));
                $this->set(compact('muestra', 'referer'));
                return;
            }
            
            if (!empty($data['fecha_recepcion'])) {
                $data['fecha_recepcion'] = $data['fecha_recepcion'];
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
        $query = $this->Muestras->find()->contain(['Resultados']);

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

        $query->contain(['Resultados' => function ($q) {
            return $q->order(['Resultados.fecha_recepcion' => 'DESC']);
        }]);

        $modo = $this->request->getQuery('modo', 'resumen');

        $muestras = $query->all();

        if ($modo === 'resumen') {
            foreach ($muestras as $muestra) {
                if (!empty($muestra->resultados)) {
                    $muestra->resultados = [$muestra->resultados[0]];
                }
            }
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

        $this->set(compact('muestras', 'especies', 'modo', 'tipoFecha'));
    }
}