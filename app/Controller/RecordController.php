<?php
class RecordController extends AppController
{

    public function index()
    {
        ini_set('memory_limit', '256M');
        set_time_limit(0);

        $this->setFlash('Listing Record page too slow, try to optimize it.');
        $this->set('title', __('List Record'));
    }

    public function listing()
    {
        $this->autoRender = false;

        $sort_by = 'id';
        $order = 'ASC';
        $search = $this->request->query['sSearch'];;
        $aColumns = array('id', 'name');

        if (isset($this->request->query['iSortCol_0'])) {
            for ($i = 0; $i < intval($this->request->query['iSortingCols']); $i++) {
                if ($this->request->query['bSortable_' . intval($this->request->query['iSortCol_' . $i])] == "true") {
                    $sort_by = $aColumns[intval($this->request->query['iSortCol_' . $i])];
                    $order = $this->request->query['sSortDir_' . $i];
                }
            }
        }

        $params = array(
            'offset' => (int) $this->request->query['iDisplayStart'],
            'order' => array("{$sort_by} {$order}"),
            'limit' => (int) $this->request->query['iDisplayLength']
        );

        if ($search !== '') {
            $params['conditions'] = array(
                'name LIKE' => '%' . $search . '%'
            );
        }

        $records = $this->Record->find('all', $params);

        $results = [
            "sEcho" => (isset($this->request->query['sEcho'])) ? $this->request->query['sEcho'] : 1,
            "iTotalRecords" => $this->Record->find('count'),
            "iTotalDisplayRecords" => $this->Record->find('count', array(
                'conditions' => array(
                    'name LIKE' => '%' . $search . '%'
                )
            )),
            "aaData" => array_map(function ($record) {
                return [
                    $record['Record']['id'],
                    $record['Record']['name']
                ];
            }, $records)
        ];

        return json_encode($results);
    }


    // 		public function update(){
    // 			ini_set('memory_limit','256M');

    // 			$records = array();
    // 			for($i=1; $i<= 1000; $i++){
    // 				$record = array(
    // 					'Record'=>array(
    // 						'name'=>"Record $i"
    // 					)			
    // 				);

    // 				for($j=1;$j<=rand(4,8);$j++){
    // 					@$record['RecordItem'][] = array(
    // 						'name'=>"Record Item $j"		
    // 					);
    // 				}

    // 				$this->Record->saveAssociated($record);
    // 			}



    // 		}
}
