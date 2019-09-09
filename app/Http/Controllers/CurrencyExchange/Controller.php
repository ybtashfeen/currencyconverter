<?php declare(strict_types=1);

namespace App\Http\Controllers\CurrencyExchange;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    /**
     * @param Request $request
     */
    public function get(Request $request)
    {
        $to   = $request->get('to');
        $from = $request->get('from');
        $amount = $request->get('amount');

        if ($to === null
            || $from === null
            || $amount === null) {

            throw new \RuntimeException('Required Parameters not found');
        }


    }
}
