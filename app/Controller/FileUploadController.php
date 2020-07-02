<?php

class FileUploadController extends AppController {
	public function index() {
        $this->set('title', __('File Upload Answer'));
        
        if(isset($this->request->data['FileUpload']['file'])) {
            $file = $this->request->data['FileUpload']['file'];

            if ($this->hasValidExtension($file['type'])){
                $this->FileUpload->saveAll($this->getFileContent($file));
            } else {
                $this->setFlash("Oops, Invalid File!");
            }

        }

		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));
    }
    
    private function hasValidExtension($type) {
        $validExtensions = [
            'text/csv',
            'text/plain',
            'application/csv',
            'text/comma-separated-values',
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.msexcel',
            'text/anytext',
            'application/octet-stream',
            'application/txt'
        ];
        return in_array($type, $validExtensions);
    }

    private function getFileContent($file) {
        ini_set('auto_detect_line_endings',TRUE);

        $contents = []; 
        $handle = fopen($file['tmp_name'], 'r'); 
        $index = 0;
        while(($row = fgetcsv($handle, 0, ",")) !== false) {
            if ($index !== 0) {
                $contents[] = array(
                    'name' => $row[0],
                    'email' => $row[1]
                );
            }
            $index ++;
        }
        fclose($handle); 

        return $contents;
    }
}