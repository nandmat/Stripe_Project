<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        if(auth()->user()->subscribed('default'))
        {
            return redirect()->route('subscriptions.premium');
        }
        return view('subscriptions.index',[
            'intent' => auth()->user()->createSetupIntent(),
            'plan' => session('plan')
        ]);
    }

    public function store(Request $request)
    {
        $plan = session('plan');
        $request->user()
                ->newSubscription('default', $plan->stripe_id)
                ->create($request->token);

                return redirect()->route('subscriptions.premium');
    }

    public function premium()
    {
        return view('subscriptions.premium');
    }

    public function account()
    {
        $user = auth()->user();

        $invoices = $user->invoices();

        $subscription = $user->subscription('default');

        return view('subscriptions.account', [
            'invoices' => $invoices,
            'user' => $user,
            'subscription' => $subscription
        ]);
    }

    public function invoiceDownload($invoiceId)
    {
        return auth()->user()
                    ->downloadInvoice($invoiceId, [
                        'vendor' => config('app.name'),
                        'product' => 'Assinatura VIP'
                    ]);
    }

    public function cancel()
    {
        auth()->user()->subscription('default')->cancel();

        return redirect()->route('subscriptions.account');
    }

    public function resume()
    {
        auth()->user()->subscription('default')->resume();

        return redirect()->route('subscriptions.account');
    }
}
