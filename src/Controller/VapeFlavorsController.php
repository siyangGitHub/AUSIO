<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * VapeFlavors Controller
 *
 * @property \App\Model\Table\VapeFlavorsTable $VapeFlavors
 *
 * @method \App\Model\Entity\VapeFlavor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VapeFlavorsController extends AppController
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
        $vapeFlavors = $this->VapeFlavors->find('all',['contain' => ['DisposableVapes']])->order(['disposable_vape_brand','disposable_vape_variant', 'vape_flavors_name']);
        $vapeBrands = $this->VapeFlavors->DisposableVapes->find('all')->distinct()->order(['disposable_vape_brand']);

        $this->set(compact('vapeFlavors','vapeBrands'));
    }

    /**
     * View method
     *
     * @param string|null $id Vape Flavor id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vapeFlavor = $this->VapeFlavors->get($id, [
            'contain' => ['DisposableVapes'],
        ]);

        $this->set('vapeFlavor', $vapeFlavor);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vapeFlavor = $this->VapeFlavors->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!empty($data['vape_image']['name'])) {
                $file = $data['vape_image'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($ext, $arr_ext)) {
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img' . DS . 'vapes'. DS . $file['name']);
                    $data['vape_image'] = $file['name'];
                }
            }
            $vapeFlavor = $this->VapeFlavors->patchEntity($vapeFlavor, $data);
            if ($this->VapeFlavors->save($vapeFlavor)) {
                $this->Flash->success(__('The vape flavor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vape flavor could not be saved. Please, try again.'));
        }
        $disposableVapes = $this->VapeFlavors->DisposableVapes->find('all', ['limit' => 200]);
        $this->set(compact('vapeFlavor', 'disposableVapes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vape Flavor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vapeFlavor = $this->VapeFlavors->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (!empty($data['image']['name'])) {
                $file = $data['image'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($ext, $arr_ext)) {
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img' . DS . 'vapes'. DS . $file['name']);
                    $data['vape_image'] = $file['name'];
                }
            }
            $vapeFlavor = $this->VapeFlavors->patchEntity($vapeFlavor, $data);
            if ($this->VapeFlavors->save($vapeFlavor)) {
                $this->Flash->success(__('The vape flavor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vape flavor could not be saved. Please, try again.'));
        }
        $disposableVapes = $this->VapeFlavors->DisposableVapes->find('all', ['limit' => 200]);
        $this->set(compact('vapeFlavor', 'disposableVapes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vape Flavor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vapeFlavor = $this->VapeFlavors->get($id);
        if ($this->VapeFlavors->delete($vapeFlavor)) {
            $this->Flash->success(__('The vape flavor has been deleted.'));
        } else {
            $this->Flash->error(__('The vape flavor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updateColor(){
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $jsonArray = json_decode($data['colorJson'], false);
            foreach ($jsonArray as $item){
                $vapeFlavor = $this->VapeFlavors->get($item->vape_flavors_id);
                $vapeFlavor->vape_image_color = $item->vape_image_color;
                $this->VapeFlavors->save($vapeFlavor);
            }
        }
    }
}
