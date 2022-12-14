<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaypalController extends Controller
{
   public function createPaypal()
   {
    return view('paypal_view');
   }


public function processPaypal(Request $request)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('processSuccess'),
                "cancel_url" => route('processCancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "$request->amount"
                    ],
                    "cvv" => [
                        "value" =>"$request->cvv"
                    ],
                    "card_num" => [
                        "value" => "$request->card_num"
                    ],
                    "exp_date" => [
                        "value" => "$request->exp_date"
                    ] 
                ]  
                    ]
        ]);
        

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('createPaypal')
                ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->route('createPaypal')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
}


public function processSuccess(Request $request)
{

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));                                       
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        $response = $provider->showOrderDetails($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('createPaypal')
                ->with('success', 'Transaction complete.');
        } else {
            return redirect()
                ->route('createPaypal')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }

}

 public function processCancel(Request $request)
    {
        return redirect()
            ->route('createPaypal')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

}
