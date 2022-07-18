<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\VapeFlavor;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;

/**
 * StockRecord Controller
 *
 * @property \App\Model\Table\StockRecordTable $StockRecord
 *
 * @method \App\Model\Entity\StockRecord[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockRecordController extends AppController
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
        $stockRecord = $this->StockRecord->find('all')->contain('VapeFlavors')->orderDesc('stock_record_time');
        $vapeFlavors = $this->StockRecord->VapeFlavors->find('all')->contain('DisposableVapes');
        $this->loadModel("VapeFlavors");
        $vapeBrands = $this->VapeFlavors->DisposableVapes->find('all')->distinct()->order(['disposable_vape_brand']);

        $this->set(compact('stockRecord','vapeFlavors', 'vapeBrands'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Record id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockRecord = $this->StockRecord->find('all');

        $this->set('stockRecord', $stockRecord);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stockRecord = $this->StockRecord->newEntity();
        $this->loadModel('VapeFlavors');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $stockRecordsData = json_decode($data['jsonSubmit']);

            foreach ($stockRecordsData as $stockRecordData){
                $this->addRecord($stockRecordData);
            }
            return $this->redirect(['action' => 'index']);
        }
        $disposableVapes = $this->StockRecord->VapeFlavors->DisposableVapes->find('all')->contain('VapeFlavors');
        $this->set(compact('stockRecord', 'disposableVapes'));
    }

    public function addRecord($data = null){
        date_default_timezone_set('Australia/Melbourne');
        $date = date('d/m/Y H:i:s', time());
        $stockRecord = $this->StockRecord->newEntity();
        $stockRecord->vape_flavors_id = $data->vape_flavors_id;
        $stockRecord->stock_record_price = $data->stock_record_price;
        $stockRecord->stock_record_quantity = $data->stock_record_quantity;
        $stockRecord->stock_record_stock_current = $data->stock_record_quantity;
        $stockRecord->stock_record_time = $date;
        $stockRecord->stock_record_comment = "Stock Management";
        if ($this->StockRecord->save($stockRecord)) {
            $vapeFlavor = $this->VapeFlavors->get($data->vape_flavors_id);
            $vapeFlavor->vape_stock += $data->stock_record_quantity;
            $this->VapeFlavors->save($vapeFlavor);
            $this->Flash->success('The stock record has been saved.');
        }
        else{
            $this->Flash->error("The stock record could not be saved.");
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Stock Record id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stockRecord = $this->StockRecord->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $stockRecord = $this->StockRecord->patchEntity($stockRecord, $this->request->getData());

            if ($this->StockRecord->save($stockRecord)) {
                $this->Flash->success(__('The stock record has been saved.'));
                $vapeFlavorTable = $this->loadModel('vape_flavors');
                $vapeFlavor = $vapeFlavorTable->get($stockRecord->vape_flavors_id);
                $flavorRecords = $this->StockRecord->find('all')->where(['vape_flavors_id' => $stockRecord->vape_flavors_id]);
                $sum = 0;
                foreach ($flavorRecords as $flavorRecord){
                    $sum+=$flavorRecord->stock_record_stock_current;
                }
                $vapeFlavor->vape_stock=$sum;
                $vapeFlavorTable->save($vapeFlavor);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock record could not be saved. Please, try again.'));
        }
        $vapeFlavors = $this->StockRecord->VapeFlavors->find('all')->contain(['DisposableVapes']);
        $this->set(compact('stockRecord', 'vapeFlavors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stock Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stockRecord = $this->StockRecord->get($id);
        $this->loadModel('VapeFlavors');
        if ($this->StockRecord->delete($stockRecord)) {
            $vapeFlavor = $this->VapeFlavors->get($stockRecord->vape_flavors_id);
            $vapeFlavor->vape_stock -= $stockRecord->stock_record_quantity;
            $this->VapeFlavors->save($vapeFlavor);
            $this->Flash->success(__('The stock record has been deleted.'));
        } else {
            $this->Flash->error(__('The stock record could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function summary(){
        $connection = ConnectionManager::get('default');
        $sum = $connection->execute('select sum(stock_record.stock_record_stock_current) total, sum(stock_record_price * stock_record.stock_record_stock_current) price from stock_record')->fetchAll('assoc');
        $this->set('sums',$sum);
        $results = $connection->execute('select disposable_vape_brand brand, disposable_vape_variant variant, sum(stock_record_stock_current) as qty, sum(stock_record_stock_current*stock_record_price)/sum(stock_record_stock_current) as price, sum(stock_record_stock_current*stock_record_price) as total from stock_record join vape_flavors join disposable_vapes where stock_record.vape_flavors_id = vape_flavors.vape_flavors_id and disposable_vapes.disposable_vape_id = vape_flavors.disposable_vape_id and stock_record_stock_current != 0 group by brand, variant')->fetchAll('assoc');
        $this->set('results',$results);
    }
}
