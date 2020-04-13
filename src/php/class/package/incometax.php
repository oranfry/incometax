<?php
namespace package;

class incometax extends \Package
{
    public $label = 'Income Tax';
    public $blends = [
        'expensetransactions',
        'saletransactions',
    ];
}
