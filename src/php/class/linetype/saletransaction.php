<?php
namespace linetype;

use \Config;

class saletransaction extends incometaxtransaction
{
    public function __construct()
    {
        parent::__construct();

        $this->fields[] = (object) [
            'name' => 'invoice',
            'type' => 'file',
            'icon' => 'docpdf',
            'path' => function($line) {
                $fy = date('Y', strtotime($line->date));
                $m = intval(date('n', strtotime($line->date)));

                if ($m > 3) {
                    $fy++;
                }

                return "sales/{$fy}/{$line->id}.pdf";
            },
            'supress_header' => true,
        ];

        $this->clause = "t.account in (" . implode(',', array_map(function($a){ return "'$a'"; }, @Config::get()->sale_accounts ?? [])) . ")";
    }
}
