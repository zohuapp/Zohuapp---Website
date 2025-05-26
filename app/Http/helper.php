<?php

if (! function_exists('get_auth_user_name')) {
    /**
     * Format a number as currency.
     *
     * @param  float|int  $amount
     * @param  string|null  $currencyCode
     * @return string
     */
    function get_auth_user_name()
    {
        $auth = auth()->user()->name ?? null;
        return $auth;
    }
}
