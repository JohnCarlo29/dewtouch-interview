<div class="row-fluid">
    <div class="alert alert-info">
        <span>Import Data</span><br>
        <span>Note: Please convert excel to csv first before uploading :)</span>
    </div>
    <?php
        echo $this->Form->create('Migrate', array('type' => 'file', 'url' => '/migration/migrate'));
        echo $this->Form->input('file', array('label' => 'Excel File', 'type' => 'file'));
        echo $this->Form->end('Upload');
    ?>
</div>