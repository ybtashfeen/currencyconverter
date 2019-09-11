<?php

namespace App\Http\Controllers\CurrencyExchange;

use App\Helpers\CurrencyExchangeHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param Request                $request
     *
     * @param CurrencyExchangeHelper $helper
     *
     * @return array
     */
    public function get(Request $request, CurrencyExchangeHelper $helper): array
    {
        $to     = $request->get('to_currency');
        $from   = $request->get('from_currency');
        $amount = $request->get('amount');

        if ($to === null
            || $from === null
            || $amount === null) {


            $response['type']    = 'error';
            $response['message'] = 'Required Parameters not found';
            return $response;
        }

        if ($to === $from) {
            $response['type']    = 'error';
            $response['message'] = 'Please choose different currency';
            return $response;
        }

        try {

            $response['type']    = 'success';
            $response['message'] = $helper->convert($to, $from, $amount);

        } catch (\RuntimeException $exception) {
            $response['type']    = 'error';
            $response['message'] = $exception->getMessage();
        }

        return $response;
    }
}
