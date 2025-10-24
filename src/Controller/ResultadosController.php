<?php
declare(strict_types=1);

namespace App\Controller;

class ResultadosController extends AppController
{
    public function add($muestraId = null)
    {
        $resultado = $this->Resultados->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $resultado = $this->Resultados->patchEntity($resultado, $this->request->getData());
            if ($this->Resultados->save($resultado)) {
                $this->Flash->success(__('El resultado ha sido guardado.'));
                return $this->redirect(['controller' => 'Muestras', 'action' => 'view', $resultado->muestra_id]);
            }
            $this->Flash->error(__('No se pudo guardar el resultado. Por favor, intente nuevamente.'));
        } else if ($muestraId) {
            $resultado->muestra_id = $muestraId;
            $muestra = $this->Resultados->Muestras->get($muestraId);
            $this->set('muestraSeleccionada', $muestra);
        }
        
        $muestras = $this->Resultados->Muestras->find('all')
            ->select(['id', 'codigo'])
            ->order(['codigo' => 'DESC'])
            ->toArray();
        
        $this->set(compact('resultado', 'muestras', 'muestraId'));
    }

    public function edit($id = null)
    {
        $resultado = $this->Resultados->get($id, contain: ['Muestras']);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resultado = $this->Resultados->patchEntity($resultado, $this->request->getData());
            if ($this->Resultados->save($resultado)) {
                $this->Flash->success(__('El resultado ha sido actualizado.'));
                return $this->redirect(['controller' => 'Muestras', 'action' => 'view', $resultado->muestra_id]);
            }
            $this->Flash->error(__('No se pudo actualizar el resultado. Por favor, intente nuevamente.'));
        }
        
        $this->set(compact('resultado'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resultado = $this->Resultados->get($id);
        $muestraId = $resultado->muestra_id;
        
        if ($this->Resultados->delete($resultado)) {
            $this->Flash->success(__('El resultado ha sido eliminado.'));
        } else {
            $this->Flash->error(__('No se pudo eliminar el resultado. Por favor, intente nuevamente.'));
        }

        return $this->redirect(['controller' => 'Muestras', 'action' => 'view', $muestraId]);
    }
}