<?php

namespace App\Http\Controllers\CurrencyExchange;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Providers\CurrencyExchangeService\FloatRatesService;

class Controller extends BaseController
{

    /**
     * @param Request           $request
     * @param FloatRatesService $service
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(Request $request, FloatRatesService $service): void
    {
        $to     = $request->get('to');
        $from   = $request->get('from');
        $amount = $request->get('amount');

        if ($to === null
            || $from === null
            || $amount === null) {

            throw new \RuntimeException('Required Parameters not found');
        }

        try {

            echo $service::convert($to, $from, $amount);
        } catch (\RuntimeException $exception) {
            echo $exception->getMessage();
        }
    }
}
