<?php
namespace package;

class incometax extends \Package
{
    public $label = 'Income';
    public $blends = [
        'incometaxtransactions',
        'expensetransactions',
        'saletransactions',
    ];
}
