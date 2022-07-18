<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\StockRecord;
use Cake\Database\Expression\QueryExpression;
use Cake\Database\Query;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use stdClass;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'verify']);
        return null;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($limit = null)
    {
        $this->isAllowed($this->Auth->user());
        if($limit == null){
            $orders = $this->Orders->find('all')->orderDesc('order_id')->limit(1000);
        }
        else{
            $orders = $this->Orders->find('all')->orderDesc('order_time');
        }

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->isAllowed($this->Auth->user());
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);

        $this->set('order', $order);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEntity();
        $this->loadModel("VapeFlavors");
        $vapeFlavors = $this->VapeFlavors->find('all')->contain('DisposableVapes')->order(["vape_status" => 'desc',"vape_stock + vape_sold" => 'desc', 'disposable_vape_brand', 'disposable_vape_variant', 'vape_flavors_name']);
        $this->loadModel('DisposableVapes');
        $disposableVapes = $this->VapeFlavors->find('all')->contain('DisposableVapes')->order(["sum(vape_sold)" => 'desc', "disposable_vape_brand", "disposable_vape_variant"])->distinct("disposable_vape_variant");
        $this->loadModel('StockRecord');
        date_default_timezone_set('Australia/Melbourne');
        $date = date('d/m/Y H:i:s', time());
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $jsonArray = json_decode($data['jsonOrderRecords'], false);
            $order->order_customer = "Retail";
            $order->order_time = $date;
            $order->order_is_complete = 1;
            $orderDetailArray = [];
            $stockRecordToBeSaved = [];
            $recordedIDArray = [];
            $canBeFulfilled = true;
            foreach ($jsonArray as $orderDetail) {
                $query = $this->StockRecord->find()->where(["vape_flavors_id" => $orderDetail->vape_flavors_id,
                    "stock_record_stock_current >" => 0]);
                $sum = $query->select(['sum' => $query->func()->sum('stock_record_stock_current')])->first()->sum;
                if ($sum != null && $sum >= $orderDetail->stock_record_quantity) {
                    $remainQuantity = $orderDetail->stock_record_quantity;
                    $recordArray = [];
                    while ($remainQuantity != 0) {
                        $stockRecords = $this->StockRecord->find('all')
                            ->where(["vape_flavors_id" => $orderDetail->vape_flavors_id,
                                "stock_record_stock_current >" => 0])
                            ->orderDesc('stock_record_stock_current')
                            ->order('stock_record_price');
                        $stockRecord = $this->StockRecord->newEntity();
                        foreach ($stockRecords as $item) {
                            if (!in_array($item->stock_record_id, $recordedIDArray)) {
                                $stockRecord = $item;
                                break;
                            }
                        }
                        array_push($recordedIDArray, $stockRecord->stock_record_id);
                        $recorded = new stdClass();
                        $recorded->stock_record_id = $stockRecord->stock_record_id;

                        if ($stockRecord->stock_record_stock_current - $remainQuantity < 0) {
                            $recorded->stock_record_quantity = $stockRecord->stock_record_stock_current;
                            $remainQuantity -= $stockRecord->stock_record_stock_current;
                            $stockRecord->stock_record_stock_current = 0;
                            $stockRecord->recordedValue = $stockRecord->stock_record_stock_current;
                        } else {
                            $recorded->stock_record_quantity = $remainQuantity;
                            $stockRecord->stock_record_stock_current -= $remainQuantity;
                            $stockRecord->recordedValue = $remainQuantity;
                            $remainQuantity = 0;
                        }
                        array_push($stockRecordToBeSaved, $stockRecord);
                        array_push($recordArray, $recorded);
                    }
                    $orderDetail->recordArray = json_encode($recordArray);
                    $orderProfit = number_format($orderDetail->stock_record_price - $stockRecord->stock_record_price, 2);
                    $orderDetail->order_profit = $orderProfit;
                    array_push($orderDetailArray, $orderDetail);
                    $this->Flash->success('You ordered ' . $orderDetail->vapeProductName . ' x ' . $orderDetail->stock_record_quantity . ".");

                } else {
                    $this->Flash->error($orderDetail->vapeProductName . " quantity not enough, order approval cancelled");
                    $canBeFulfilled = false;
                }
            }

            if ($canBeFulfilled) {
                foreach ($stockRecordToBeSaved as $stockRecord) {
                    $this->StockRecord->save($stockRecord);
                    $vapeFlavor = $this->VapeFlavors->get($stockRecord->vape_flavors_id);
                    $query = $this->StockRecord->find()->where(["vape_flavors_id" => $stockRecord->vape_flavors_id,
                        "stock_record_stock_current >" => 0]);
                    $sum = $query->select(['sum' => $query->func()->sum('stock_record_stock_current')])->first()->sum;
                    $vapeFlavor->vape_stock = $sum;
                    $vapeFlavor->vape_sold += $stockRecord->recordedValue;
                    $this->VapeFlavors->save($vapeFlavor);
                }
                $order->order_detail = json_encode($orderDetailArray);
                $order->order_is_complete = 1;
                $this->Orders->save($order);
                return $this->redirect(['action' => 'add']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
                return $this->redirect(['action' => 'add']);
            }
        }
        $this->set(compact('order', 'vapeFlavors', 'disposableVapes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->isAllowed($this->Auth->user());
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->isAllowed($this->Auth->user());
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($order->order_is_complete == 1) {
            $this->loadModel("VapeFlavors");
            $this->loadModel("StockRecord");
            $orderDetails = json_decode($order->order_detail, false);
            foreach ($orderDetails as $orderDetail) {
                $vapeFlavor = $this->VapeFlavors->get($orderDetail->vape_flavors_id);
                $vapeFlavor->vape_stock += $orderDetail->stock_record_quantity;
                if ($order->order_customer == "Retail") {
                    $vapeFlavor->vape_sold -= $orderDetail->stock_record_quantity;
                }
                $this->VapeFlavors->save($vapeFlavor);
                $stockRecordArray = json_decode($orderDetail->recordArray);
                foreach ($stockRecordArray as $stockRecord) {
                    $stockRecordData = $this->StockRecord->get($stockRecord->stock_record_id);
                    $stockRecordData->stock_record_stock_current += $stockRecord->stock_record_quantity;
                    $this->StockRecord->save($stockRecordData);
                }
            }
            if ($this->Orders->delete($order)) {
                $this->Flash->success(__('The order has been deleted.'));
            } else {
                $this->Flash->error(__('The order could not be deleted. Please, try again.'));
            }
        }
        else{
            if ($this->Orders->delete($order)) {
                $this->Flash->success(__('The order has been deleted.'));
            } else {
                $this->Flash->error(__('The order could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    public function report()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if($data['type']==='retail'){
                $conn = ConnectionManager::get('default');
                $stmt = $conn->execute("select * from orders where STR_TO_DATE(order_time, '%d/%m/%Y') BETWEEN STR_TO_DATE('" . $data['datepicker1'] . "' , '%d/%m/%Y') AND STR_TO_DATE('" . $data['datepicker2'] . "', '%d/%m/%Y') AND order_customer = 'retail'");
            }
            else if($data['type']==='wholesale'){
                $conn = ConnectionManager::get('default');
                $stmt = $conn->execute("select * from orders where STR_TO_DATE(order_time, '%d/%m/%Y') BETWEEN STR_TO_DATE('" . $data['datepicker1'] . "' , '%d/%m/%Y') AND STR_TO_DATE('" . $data['datepicker2'] . "', '%d/%m/%Y') AND order_customer != 'retail'");
            }
            $orders = $stmt->fetchAll('obj');


            $orderDetailArray = [];
            foreach ($orders as $order) {
                $orderDetails = json_decode($order->order_detail);
                foreach ($orderDetails as $orderDetail) {
                    $orderDetailObj = new stdClass();
                    $orderDetailObj->vapeProductName = $orderDetail->vapeProductName;
                    $orderDetailObj->stock_record_quantity = $orderDetail->stock_record_quantity;
                    $orderDetailObj->order_profit = $orderDetail->order_profit;
                    $orderDetailObj->stock_record_price = $orderDetail->stock_record_price;
                    array_push($orderDetailArray, $orderDetailObj);
                }
            }
            $orderDetailArray = json_encode($orderDetailArray);
            $this->set(compact('orderDetailArray'));
        }
    }

    public function create()
    {
        $order = $this->Orders->newEntity();
        $this->loadModel("VapeFlavors");
        $vapeFlavors = $this->VapeFlavors->find('all')->contain('DisposableVapes')->where(['disposable_vape_wholesale_price <>' => 0])->order(['disposable_vape_brand', 'disposable_vape_variant', 'vape_flavors_name']);
        $this->loadModel('DisposableVapes');
        $disposableVapes = $this->VapeFlavors->find('all')->contain('DisposableVapes')->where(['disposable_vape_wholesale_price <>' => 0])->distinct("disposable_vape_variant")->order(["disposable_vape_brand", "disposable_vape_variant"]);
        $this->loadModel('StockRecord');
        date_default_timezone_set('Australia/Melbourne');
        $date = date('d/m/Y H:i:s', time());
        if ($this->request->is('post')) {

            $data = $this->request->getData();
            $order->order_customer = $this->Auth->user('username');
            $order->order_time = $date;
            $order->order_is_complete = 0;

            $order->order_detail = $data['jsonOrderRecords'];
            $orderDetail = json_decode($data['jsonOrderRecords'], false);
            foreach ($orderDetail as $item) {
                $this->Flash->success('You ordered ' . $item->vapeProductName . ' x ' . $item->stock_record_quantity . ".");
            }
            if ($this->Orders->save($order)) {
                return $this->redirect(['action' => 'create']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('order', 'vapeFlavors', 'disposableVapes'));
    }

    public function processOrder($orderID)
    {
        $this->isAllowed($this->Auth->user());
        $order = $this->Orders->get($orderID);
        $orderDetailArray = json_decode($order->order_detail, false);
        $this->loadModel('StockRecord');
        $this->loadModel('VapeFlavors');
        $stockRecordToBeSaved = [];
        $recordedIDArray = [];
        $canBeFulfilled = true;
        foreach ($orderDetailArray as $orderDetail) {
            $query = $this->StockRecord->find()->where(["vape_flavors_id" => $orderDetail->vape_flavors_id,
                "stock_record_stock_current >" => 0]);
            $sum = $query->select(['sum' => $query->func()->sum('stock_record_stock_current')])->first()->sum;
            if ($sum != null && $sum >= $orderDetail->stock_record_quantity) {
                $remainQuantity = $orderDetail->stock_record_quantity;
                $recordArray = [];
                while ($remainQuantity != 0) {
                    $stockRecords = $this->StockRecord->find('all')
                        ->where(["vape_flavors_id" => $orderDetail->vape_flavors_id,
                            "stock_record_stock_current >" => 0])
                        ->order(['stock_record_price' => 'desc']);
                    $stockRecord = $this->StockRecord->newEntity();
                    foreach ($stockRecords as $item) {
                        if (!in_array($item->stock_record_id, $recordedIDArray)) {
                            $stockRecord = $item;
                            break;
                        }
                    }
                    array_push($recordedIDArray, $stockRecord->stock_record_id);
                    $recorded = new stdClass();
                    $recorded->stock_record_id = $stockRecord->stock_record_id;
                    if ($stockRecord->stock_record_stock_current - $remainQuantity < 0) {
                        $recorded->stock_record_quantity = $stockRecord->stock_record_stock_current;
                        $remainQuantity -= $stockRecord->stock_record_stock_current;
                        $stockRecord->stock_record_stock_current = 0;
                    } else {
                        $recorded->stock_record_quantity = $remainQuantity;
                        $stockRecord->stock_record_stock_current -= $remainQuantity;
                        $remainQuantity = 0;
                    }
                    array_push($stockRecordToBeSaved, $stockRecord);
                    array_push($recordArray, $recorded);
                }
                $orderDetail->recordArray = json_encode($recordArray);
                $orderProfit = number_format($orderDetail->stock_record_price - $stockRecord->stock_record_price, 2);
                $orderDetail->order_profit = $orderProfit;
            } else {
                $this->Flash->error($orderDetail->vapeProductName . " quantity not enough, order approval cancelled");
                $canBeFulfilled = false;
            }
        }
        if ($canBeFulfilled) {
            foreach ($stockRecordToBeSaved as $stockRecord) {
                $this->StockRecord->save($stockRecord);
                $vapeFlavor = $this->VapeFlavors->get($stockRecord->vape_flavors_id);
                $query = $this->StockRecord->find()->where(["vape_flavors_id" => $stockRecord->vape_flavors_id,
                    "stock_record_stock_current >" => 0]);
                $sum = $query->select(['sum' => $query->func()->sum('stock_record_stock_current')])->first()->sum;
                $vapeFlavor->vape_stock = $sum;
                $this->VapeFlavors->save($vapeFlavor);
            }
            $order->order_detail = json_encode($orderDetailArray);
            $order->order_is_complete = 1;
            $this->Orders->save($order);
            $this->Flash->success(__('The order is saved.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }

    }

    public function verify(){
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $pwd = $data['password'];
            if($pwd=="admin2011"){
                $this->response->body("1");
                return $this->response;
            }
            else{
                return null;
            }
        }
        return null;
    }

}
