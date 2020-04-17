<?php
namespace incometax\helper;

use blends\helper\LinetypeHelper;
use Config;

class IncometaxHelper
{
    public static function filter_to_incometax_transactions($blend)
    {
        $accounts = array_merge(
            @Config::get()->sale_accounts ?? ['sale'],
            @Config::get()->expense_accounts ?? ['expense']
        );

        $blend->filters = array_merge(
            @$blend->filters ?? [],
            [
                (object) [
                    'field' => 'account',
                    'cmp' => '=',
                    'value' => $accounts,
                ],
            ]
        );
    }

    public static function filter_to_sale_transactions($blend)
    {
        $accounts = @Config::get()->sale_accounts ?? ['sale'];

        $blend->filters = array_merge(
            @$blend->filters ?? [],
            [
                (object) [
                    'field' => 'account',
                    'cmp' => '=',
                    'value' => $accounts,
                ],
            ]
        );
    }

    public static function filter_to_expense_transactions($blend)
    {
        $accounts = @Config::get()->expense_accounts ?? ['expense'];

        $blend->filters = array_merge(
            @$blend->filters ?? [],
            [
                (object) [
                    'field' => 'account',
                    'cmp' => '=',
                    'value' => $accounts,
                ],
            ]
        );
    }

    public static function change_amount_to_net($blend)
    {
        $field = filter_objects($blend->fields, 'name', 'is', 'amount')[0];

        if (!$field) {
            return;
        }

        $field->name = 'net';
    }
}
