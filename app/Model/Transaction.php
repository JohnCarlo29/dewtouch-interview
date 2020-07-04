<?php
class Transaction extends AppModel
{
    public $belongsTo = ['Member'];
    public $hasMany = ['TransactionItem'];
}
