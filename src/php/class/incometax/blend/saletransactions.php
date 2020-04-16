<?php
namespace incometax\blend;

use Config;

class saletransactions extends incometaxtransactions
{
    public function __construct()
    {
        parent::__construct();

        $this->label = 'Sales';

        $accounts = @Config::get()->sale_accounts ?? ['sale'];

        $this->filters = [
            (object) [
                'field' => 'account',
                'cmp' => '=',
                'value' => $accounts,
            ],
        ];
    }
}
