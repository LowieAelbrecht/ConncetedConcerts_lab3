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

    public function preparePayment(Request $request)
    {
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => "10.00" // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Order #12345",
            "redirectUrl" => route('payment.success'),
            "metadata" => [
                "order_id" => "12345",
            ],
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function paymentSuccess(Request $request) 
    {
        echo "payment succes";
    }

}
