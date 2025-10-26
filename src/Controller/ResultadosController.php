<?php
declare(strict_types=1);

namespace App\Controller;

class ResultadosController extends AppController{

    public function add($muestraId = null)
    {
        $resultado = $this->Resultados->newEmptyEntity();
        $referer = $this->request->getQuery('referer', 'muestra');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            if (empty($data['muestra_id'])) {
                $this->Flash->error(__('Debe seleccionar una muestra.'));
                $this->_prepareAddView($resultado, $muestraId, $referer);
                return;
            }
            
            if (!empty($data['fecha_recepcion'])) {
                $fechaObj = \DateTime::createFromFormat('d/m/Y', $data['fecha_recepcion']);
                if ($fechaObj) {
                    $data['fecha_recepcion'] = $fechaObj->format('Y-m-d H:i:s');
                }
            }
            
            $resultado = $this->Resultados->patchEntity($resultado, $data);
            if ($this->Resultados->save($resultado)) {
                $muestra = $this->Resultados->Muestras->get($resultado->muestra_id);
                $this->Flash->success(__('Resultado asignado exitosamente a muestra {0}.', $muestra->codigo));
                
                if ($referer === 'home') {
                    return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
                }
                return $this->redirect(['controller' => 'Muestras', 'action' => 'view', $resultado->muestra_id]);
            }
            $this->Flash->error(__('No se pudo guardar el resultado. Por favor, intente nuevamente.'));
        }
        
        $this->_prepareAddView($resultado, $muestraId, $referer);
    }

    private function _prepareAddView($resultado, $muestraId = null, $referer = 'muestra')
    {
        if ($muestraId) {
            try {
                $muestra = $this->Resultados->Muestras->get($muestraId);
                $resultado->muestra_id = $muestraId;
                $this->set('muestraSeleccionada', $muestra);
            } catch (\Exception $e) {
                $this->Flash->error(__('Muestra no encontrada.'));
            }
        }
        
        $muestras = $this->Resultados->Muestras->find('all')
            ->select(['id', 'codigo'])
            ->order(['codigo' => 'DESC'])
            ->toArray();
        
        $this->set(compact('resultado', 'muestras', 'muestraId', 'referer'));
    }

    public function edit($id = null)
    {
        if (!is_numeric($id)) {
            $this->Flash->error(__('ID de resultado inválido.'));
            return $this->redirect(['controller' => 'Muestras', 'action' => 'index']);
        }

        try {
            $resultado = $this->Resultados->get($id, contain: ['Muestras']);
        } catch (\Exception $e) {
            $this->Flash->error(__('Resultado no encontrado.'));
            return $this->redirect(['controller' => 'Muestras', 'action' => 'index']);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            if (isset($data['poder_germinativo']) && ($data['poder_germinativo'] < 0 || $data['poder_germinativo'] > 100)) {
                $this->Flash->error(__('El poder germinativo debe estar entre 0 y 100.'));
                $this->set(compact('resultado'));
                return;
            }
            
            if (isset($data['pureza']) && ($data['pureza'] < 0 || $data['pureza'] > 100)) {
                $this->Flash->error(__('La pureza debe estar entre 0 y 100.'));
                $this->set(compact('resultado'));
                return;
            }
            
            $resultado = $this->Resultados->patchEntity($resultado, $data);
            if ($this->Resultados->save($resultado)) {
                $this->Flash->success(__('Actualización de resultado de muestra {0} exitosa.', $resultado->muestra->codigo));
                return $this->redirect(['controller' => 'Muestras', 'action' => 'view', $resultado->muestra_id]);
            }
            $this->Flash->error(__('No se pudo actualizar el resultado. Por favor, intente nuevamente.'));
        }
        
        $this->set(compact('resultado'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        if (!is_numeric($id)) {
            $this->Flash->error(__('ID de resultado inválido.'));
            return $this->redirect(['controller' => 'Muestras', 'action' => 'index']);
        }

        try {
            $resultado = $this->Resultados->get($id, contain: ['Muestras']);
        } catch (\Exception $e) {
            $this->Flash->error(__('Resultado no encontrado.'));
            return $this->redirect(['controller' => 'Muestras', 'action' => 'index']);
        }

        $muestraId = $resultado->muestra_id;
        $codigoMuestra = $resultado->muestra->codigo;
        
        if ($this->Resultados->delete($resultado)) {
            $this->Flash->success(__('Resultado de muestra {0} eliminado exitosamente.', $codigoMuestra));
        } else {
            $this->Flash->error(__('No se pudo eliminar el resultado. Por favor, intente nuevamente.'));
        }

        return $this->redirect(['controller' => 'Muestras', 'action' => 'view', $muestraId]);
    }
}