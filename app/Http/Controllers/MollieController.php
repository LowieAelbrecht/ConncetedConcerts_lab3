<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{
    public function  __construct() 
    {
        Mollie::api()->setApiKey('test_23Rr973jyEBcEJk9pwdmJg2qvyjrAd');
    }

    public function preparePayment(Request $request, $concerts)
    {
        $concert = \DB::table('concerts')->where('id', $concerts)->first();
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => number_format($concert->prijs, 2, '.') // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Order #12345",
            "redirectUrl" => route('payment.success'),
            "metadata" => [
                "order_id" => "12345",
                "concert_id" => $concert->id,
                "user_id" => session()->get('userId')
            ],
        ]);

        $request->session()->put('payment_id', $payment->id);
        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function paymentSuccess(Request $request) 
    {
        $payment = Mollie::api()->payments()->get(session()->get('payment_id'));
        \DB::table('userconcerts')->insert(
            ['user_id' => $payment->metadata->user_id, 
            'concert_id' => $payment->metadata->concert_id
            ]
        );

        return redirect('/user-rooms'); 
    }

}
