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
            'description' => 'Connected Concerts payment',
            "redirectUrl" => route('payment.success'),
            'webhookUrl'   => route('webhooks.mollie'),
            "metadata" => [
                "concert_id" => $concert->id,
                "user_id" => session()->get('userId')
            ],
        ]);

        $payment = Mollie::api()->payments->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    
    public function paymentSuccess(Request $request) 
    {
        echo "we received your payment";
        return redirect('/user-rooms'); 
    }
    

    public function handleRequest(Request $request)
    {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid()) {
            \DB::table('userconcerts')->insert(
                ['user_id' => $payment->metadata->user_id, 
                'concert_id' => $payment->metadata->concert_id
                ]
            );

            \DB::table('concerts')->where('id', $payment->metadata->concert_id)
            ->update([
            'tickets_sold'=> \DB::raw('tickets_sold+1')
            ]);
        }      
    }


}
