<?php
class MigrationController extends AppController
{

    public function q1()
    {

        $this->setFlash('Question: Migration of data to multiple DB table');
        // 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
    }

    public function q1_instruction()
    {

        $this->setFlash('Question: Migration of data to multiple DB table');
        // 			$this->set('title',__('Question: Please change Pop Up to mouse over (soft click)'));
    }

    public function migrate()
    {
        $this->autoRender = false;

        $this->loadModel('Member');
        $this->loadModel('Transaction');
        $this->loadModel('TransactionItem');

        if (isset($this->request->data['Migrate'])) {
            $file = $this->request->data['Migrate']['file'];

            if ($this->isValidFileType($file['type'])) {
                $this->Member->saveAll($this->getFileContents($file), ['deep' => true]);
                $message = 'Data successfully imported!';
            } else {
                $message = 'Oops, Invalid File!';
            }
        } else {
            $message = 'No Attached File!';
        }

        $this->flash($message, '/migration/q1');
    }

    private function isValidFileType($fileType)
    {

        $validExtensions = [
            'application/excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'application/octet-stream',
        ];

        return in_array($fileType, $validExtensions);
    }

    private function getFileContents($file)
    {
        ini_set('auto_detect_line_endings', true);
        $contents = [];
        $handle = fopen($file['tmp_name'], 'r');

        $rowIndex = 0;
        while (($row = fgetcsv($handle, 0, ",")) !== false) {
            if ($rowIndex > 1) {
                $memberNo = explode(' ', $row[3]);
                $contents[] = [
                    'Member' => [
                        'type' => $memberNo[0],
                        'no' => $memberNo[1],
                        'name' => $row[2],
                        'company' => $row[5],
                    ],
                    'Transaction' => [
                        'member_name' => $row[2],
                        'member_paytype' => $row[4],
                        'member_company' => $row[5],
                        'date' => date('Y-m-d H:i:s', strtotime($row[0])),
                        'year' => date('Y', strtotime($row[0])),
                        'month' => date('m', strtotime($row[0])),
                        'ref_no' => $row[1],
                        'receipt_no' => $row[8],
                        'payment_method' => $row[6],
                        'batch_no' => $row[7],
                        'cheque_no' => $row[9],
                        'payment_type' => $row[10],
                        'renewal_year' => $row[11],
                        'subtotal' => $row[12],
                        'tax' => $row[13],
                        'total' => $row[14],
                        'TransactionItem' => [
                            [
                                'description' => 'Being Payment for : '. $row[10] .' : '. date('Y', strtotime($row[0])),
                                'quantity' => 1,
                                'unit_price' => $row[12],
                                'sum' => $row[12],
                                'table' => 'Member',
                                'table_id' => $rowIndex
                            ]
                        ]
                    ]
                ];
            }
            $rowIndex++;
        }
        fclose($handle);

        return $contents;
    }
}
