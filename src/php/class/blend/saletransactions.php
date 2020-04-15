<?php
namespace blend;

use Package;
use Linetype;

class saletransactions extends incometaxtransactions
{
    public function __construct()
    {
        parent::__construct();

        $this->label = 'Sales';

        $package = Package::rget('incometax');
        $accounts = @$package->config->sale_accounts ?? ['sale'];

        $this->filters = [
            (object) [
                'field' => 'account',
                'cmp' => '=',
                'value' => $accounts,
            ],
        ];
    }
}
