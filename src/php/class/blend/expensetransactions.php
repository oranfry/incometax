<?php
namespace blend;

use Package;
use Linetype;

class expensetransactions extends incometaxtransactions
{
    public function __construct()
    {
        parent::__construct();

        $this->label = 'Expenses';

        $package = Package::rget('incometax');
        $accounts = @$package->config->expense_accounts ?? ['expense'];

        $this->filters = [
            (object) [
                'field' => 'account',
                'cmp' => '=',
                'value' => $accounts,
            ],
        ];
    }
}
