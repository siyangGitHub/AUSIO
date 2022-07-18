<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * DisposableVapes Controller
 *
 * @property \App\Model\Table\DisposableVapesTable $DisposableVapes
 *
 * @method \App\Model\Entity\DisposableVape[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DisposableVapesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->isAllowed($this->Auth->user());
        return null;
    }
    public function index()
    {
        $disposableVapes = $this->paginate($this->DisposableVapes);

        $this->set(compact('disposableVapes'));
    }

    /**
     * View method
     *
     * @param string|null $id Disposable Vape id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $disposableVape = $this->DisposableVapes->get($id, [
            'contain' => [],
        ]);

        $this->set('disposableVape', $disposableVape);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $disposableVape = $this->DisposableVapes->newEntity();
        if ($this->request->is('post')) {
            $disposableVape = $this->DisposableVapes->patchEntity($disposableVape, $this->request->getData());
            if ($this->DisposableVapes->save($disposableVape)) {
                $this->Flash->success(__('The disposable vape has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The disposable vape could not be saved. Please, try again.'));
        }
        $this->set(compact('disposableVape'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Disposable Vape id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $disposableVape = $this->DisposableVapes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $disposableVape = $this->DisposableVapes->patchEntity($disposableVape, $this->request->getData());
            if ($this->DisposableVapes->save($disposableVape)) {
                $this->Flash->success(__('The disposable vape has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The disposable vape could not be saved. Please, try again.'));
        }
        $this->set(compact('disposableVape'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Disposable Vape id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $disposableVape = $this->DisposableVapes->get($id);
        if ($this->DisposableVapes->delete($disposableVape)) {
            $this->Flash->success(__('The disposable vape has been deleted.'));
        } else {
            $this->Flash->error(__('The disposable vape could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
