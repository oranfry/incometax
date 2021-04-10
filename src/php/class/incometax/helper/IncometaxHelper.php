<?php
namespace incometax\helper;

use blends\helper\LinetypeHelper;
use BlendsConfig;

class IncometaxHelper
{
    public static function filter_to_incometax_transactions($blend)
    {
        $accounts = array_merge(
            @BlendsConfig::get(AUTH_TOKEN)->sale_accounts ?? ['sale'],
            @BlendsConfig::get(AUTH_TOKEN)->expense_accounts ?? ['expense']
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
        $accounts = @BlendsConfig::get(AUTH_TOKEN)->sale_accounts ?? ['sale'];

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
        $accounts = @BlendsConfig::get(AUTH_TOKEN)->expense_accounts ?? ['expense'];

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
