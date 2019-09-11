<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencyExchangeHelper;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param CurrencyExchangeHelper $helper
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(CurrencyExchangeHelper $helper)
    {
        $currencies = $helper->getAllCurrencies();
        return view('welcome')->with('currencies', $currencies);
    }
}
