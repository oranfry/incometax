<?php
namespace incometax\blend;

use Config;

class expensetransactions extends incometaxtransactions
{
    public function __construct()
    {
        parent::__construct();

        $this->label = 'Expenses';

        $accounts = @Config::get()->expense_accounts ?? ['expense'];

        $this->filters = [
            (object) [
                'field' => 'account',
                'cmp' => '=',
                'value' => $accounts,
            ],
        ];
    }
}
