<?php
namespace incometax\helper;

use blends\helper\LinetypeHelper;
use BlendsConfig;
use Blend;
use Linetype;

class IncometaxHelper
{
    static $sale_accounts;
    static $expense_accounts;

    public static function saleAccounts($token)
    {
        if (!isset(static::$sale_accounts)) {
            $saleAccounts = @Blend::load($token, 'lists')->search($token, [(object)['field' => 'name', 'cmp' => '=', 'value' => 'saleaccounts']])[0];

            if (!$saleAccounts) {
                return static::$sale_accounts = ['sale'];
            }

            Linetype::load($token, 'list')->load_children($token, $saleAccounts);

            static::$sale_accounts = map_objects($saleAccounts->listitems, 'item');
        }

        return static::$sale_accounts;
    }

    public static function expenseAccounts($token)
    {
        if (!isset(static::$expense_accounts)) {
            $expenseAccounts = @Blend::load($token, 'lists')->search($token, [(object)['field' => 'name', 'cmp' => '=', 'value' => 'expenseaccounts']])[0];

            if (!$expenseAccounts) {
                return static::$expense_accounts = ['expense'];
            }

            Linetype::load($token, 'list')->load_children($token, $expenseAccounts);

            static::$expense_accounts = map_objects($expenseAccounts->listitems, 'item');
        }

        return static::$expense_accounts;
    }

    public static function filter_to_incometax_transactions($token, $blend)
    {
        $accounts = array_merge(
            static::saleAccounts($token),
            static::expenseAccounts($token)
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

    public static function filter_to_sale_transactions($token, $blend)
    {
        $blend->filters = array_merge(
            @$blend->filters ?? [],
            [
                (object) [
                    'field' => 'account',
                    'cmp' => '=',
                    'value' => static::saleAccounts($token),
                ],
            ]
        );
    }

    public static function filter_to_expense_transactions($token, $blend)
    {
        $blend->filters = array_merge(
            @$blend->filters ?? [],
            [
                (object) [
                    'field' => 'account',
                    'cmp' => '=',
                    'value' => static::expenseAccounts($token),
                ],
            ]
        );
    }

    public static function change_amount_to_net($blend)
    {
        $field = @filter_objects($blend->fields, 'name', 'is', 'amount')[0];

        if (!$field) {
            return;
        }

        $field->name = 'net';
    }
}
