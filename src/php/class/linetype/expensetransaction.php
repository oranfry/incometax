<?php
namespace linetype;

use Config;
use Package;

class expensetransaction extends incometaxtransaction
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

                return "expenses/{$fy}/{$line->id}.pdf";
            },
            'supress_header' => true,
        ];

        $this->fields[] = (object) [
            'name' => 'broken',
            'type' => 'text',
            'fuse' => 'NULL',
            'calc' => function($line) { return !in_array($line->account, ['bankfees']) && !$line->invoice ? 'broken' : ''; },
        ];

        $package = Package::rget(PACKAGE_NAME);
        $accounts = @$package->config->expense_accounts ?? ['expense'];

        $this->clause = "t.account in (" . implode(',', array_map(function($a){ return "'$a'"; }, $accounts)) . ")";
    }
}
