<?php
namespace incometax\blend;

use Config;
use Linetype;

class incometaxtransactions extends \Blend
{
    public function __construct()
    {
        $this->label = 'All';

        $accounts = array_merge(
            @Config::get()->expense_accounts ?? ['expense'],
            @Config::get()->sale_accounts ?? ['sale']
        );

        $this->filters = [
            (object) [
                'field' => 'account',
                'cmp' => '=',
                'value' => $accounts,
            ],
        ];

        $linetype = Linetype::load('transaction');
        $amountfield = count(filter_objects($linetype->fields, 'name', 'is', 'net')) ? 'net' : 'amount';

        $this->linetypes = ['transaction',];
        $this->past = false;
        $this->cum = true;
        $this->groupby = 'date';
        $this->showass = ['list', 'calendar', 'graph'];
        $this->fields = [
            (object) [
                'name' => 'icon',
                'type' => 'icon',
            ],
            (object) [
                'name' => 'date',
                'type' => 'date',
                'main' => true,
            ],
            (object) [
                'name' => 'account',
                'type' => 'text',
            ],
            (object) [
                'name' => 'description',
                'type' => 'text',
            ],
            (object) [
                'name' => $amountfield,
                'type' => 'number',
                'dp' => 2,
                'summary' => 'sum',
            ],
        ];
    }
}
