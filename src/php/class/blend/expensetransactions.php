<?php
namespace blend;

class expensetransactions extends \Blend
{
    public function __construct()
    {
        $this->label = 'Income Tax: Expenses';
        $this->linetypes = ['expensetransaction',];
        $this->past = false;
        $this->cum = true;
        $this->groupby = 'date';
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
                'name' => 'amount',
                'type' => 'number',
                'dp' => 2,
                'summary' => 'sum',
            ],
            (object) [
                'name' => 'invoice',
                'type' => 'file',
                'icon' => 'docpdf',
                'default' => '',
                'path' => function($line) {
                    $fy = date('Y', strtotime($line->date));
                    $m = intval(date('n', strtotime($line->date)));

                    if ($m > 3) {
                        $fy++;
                    }

                    return "expenses/{$fy}/{$line->id}.pdf";
                },
                'supress_header' => true,
            ],
            (object) [
                'name' => 'broken',
                'type' => 'class',
                'default' => '',
            ],
        ];
    }
}
