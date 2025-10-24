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
        $muestra = $this->Muestras->get($id, contain: ['Resultados']);
        $this->set(compact('muestra'));
    }

    public function add()
    {
        $muestra = $this->Muestras->newEmptyEntity();
        if ($this->request->is('post')) {
            $muestra = $this->Muestras->patchEntity($muestra, $this->request->getData());
            if ($this->Muestras->save($muestra)) {
                $this->Flash->success(__('La muestra ha sido registrada con código: {0}', $muestra->codigo));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar la muestra. Por favor, intente nuevamente.'));
        }
        $this->set(compact('muestra'));
    }

    public function edit($id = null)
    {
        $muestra = $this->Muestras->get($id, contain: ['Resultados']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $muestra = $this->Muestras->patchEntity($muestra, $this->request->getData());
            if ($this->Muestras->save($muestra)) {
                $this->Flash->success(__('La muestra ha sido actualizada.'));
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('No se pudo actualizar la muestra. Por favor, intente nuevamente.'));
        }
        $this->set(compact('muestra'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $muestra = $this->Muestras->get($id, contain: ['Resultados']);
        $cantResultados = count($muestra->resultados);
        
        if ($this->Muestras->delete($muestra)) {
            if ($cantResultados > 0) {
                $this->Flash->success(__('La muestra y sus {0} resultado(s) han sido eliminados.', $cantResultados));
            } else {
                $this->Flash->success(__('La muestra ha sido eliminada.'));
            }
        } else {
            $this->Flash->error(__('No se pudo eliminar la muestra. Por favor, intente nuevamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}