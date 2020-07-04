<?php
class OrderReportController extends AppController
{

    public function index()
    {

        $this->setFlash('Multidimensional Array.');

        $this->loadModel('Order');
        $orders = $this->Order->find('all', array('conditions' => array('Order.valid' => 1), 'recursive' => 2));
        // debug($orders);exit;

        $this->loadModel('Portion');
        $portions = $this->Portion->find('all', array('conditions' => array('Portion.valid' => 1), 'recursive' => 2));
        // debug($portions);exit;


        // To Do - write your own array in this format
        // $order_reports = array('Order 1' => array(
        // 							'Ingredient A' => 1,
        // 							'Ingredient B' => 12,
        // 							'Ingredient C' => 3,
        // 							'Ingredient G' => 5,
        // 							'Ingredient H' => 24,
        // 							'Ingredient J' => 22,
        // 							'Ingredient F' => 9,
        // 						),
        // 					  'Order 2' => array(
        // 					  		'Ingredient A' => 13,
        // 					  		'Ingredient B' => 2,
        // 					  		'Ingredient G' => 14,
        // 					  		'Ingredient I' => 2,
        // 					  		'Ingredient D' => 6,
        // 					  	),
        // 					);

        // ...

        // construction details of portion
        $itemDetail = array();
        $itemKeys = array();
        foreach ($portions as $portion) {
            $item = $portion['Item'];
            if (!in_array($item['id'], $itemKeys)) {
                $itemKeys[] = $item['id'];
                $itemDetail[$item['id']] = array(
                    'name' => $item['name'],
                    'parts' => []
                );
            }
            foreach ($portion['PortionDetail'] as $portionDetail) {
                $itemDetail[$item['id']]['parts'][] = array(
                    'value'    => $portionDetail['value'],
                    'detail' => $portionDetail['Part']
                );
            }
        }

        // fixing the ingredients value
        $order_reports = array();
        foreach ($orders as $order) {
            $orderDetail = $order['OrderDetail'];
            $order_reports[$order['Order']['name']] = array();
            foreach ($orderDetail as $detail) {
                $quantity = intval($detail['quantity']);
                $item_id = intval($detail['item_id']);
                foreach ($itemDetail[$item_id]['parts'] as $portion) {
                    if (isset($order_reports[$order['Order']['name']][$portion['detail']['name']])) {
                        $order_reports[$order['Order']['name']][$portion['detail']['name']] += $quantity * $portion['value'];
                    } else {
                        $order_reports[$order['Order']['name']][$portion['detail']['name']] = $quantity * $portion['value'];
                    }
                }
            }
        }

        $this->set('order_reports', $order_reports);

        $this->set('title', __('Orders Report'));
    }

    public function Question()
    {

        $this->setFlash('Multidimensional Array.');

        $this->loadModel('Order');
        $orders = $this->Order->find('all', array('conditions' => array('Order.valid' => 1), 'recursive' => 2));

        // debug($orders);exit;

        $this->set('orders', $orders);

        $this->loadModel('Portion');
        $portions = $this->Portion->find('all', array('conditions' => array('Portion.valid' => 1), 'recursive' => 2));

        // debug($portions);exit;

        $this->set('portions', $portions);

        $this->set('title', __('Question - Orders Report'));
    }
}
