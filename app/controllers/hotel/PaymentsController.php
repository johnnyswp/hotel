<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment as pay;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Carbon\Carbon;

class PaymentsController extends BaseController
{
    private $_api_context;

    public function __construct()
    {
        // setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function getPlans()
    {
        if(Sentry::getUser()->type_user!=3){ return View::make('404');}
        return View::make('hotel.Payment.plan');
    }

    public function gethotelHistory()
    {
       if(Sentry::getUser()->type_user!=3){ return View::make('404');}
        $user    = Sentry::getUser();
        $payment  = Payment::where('user_id', $user->id)->first();

        return View::make('hotel.Payment.History')->with('payment', $payment);
    }

    public function getChange()
    {
         if(Sentry::getUser()->type_user!=3){ return View::make('404');}
        $user    = Sentry::getUser();
        $payment  = Payment::where('user_id', $user->id)->first();
        return View::make('hotel.Payment.cambiar-payment')->with('payment', $payment);
    }
    
    public function postChancePayment()
    {
        $plan = Plan::find(Input::get("plan_id"));
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Update-'.$plan->name) // item name
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice(Payment::chancePayment($plan->price)); // unit price
    
        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item));
    
        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal(Payment::chancePayment($plan->price));
    
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription(trans('main.tusespecialistas.com paying memberships'));
    
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))
            ->setCancelUrl(URL::route('payment.status'));
    
        $payment = new pay();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
    

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }
    
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
    
        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
    
        if(isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }
    
        return Redirect::to('/hotel/payment/history')
            ->with('error', 'Unknown error occurred');
    }

    public function postPayment()
    {
        $plan = Plan::find(Input::get("plan_id"));
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('New-'.$plan->name) // item name
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($plan->price); // unit price
    
        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item));
    
        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($plan->price);
    
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription(trans('main.easyroomservices.com paying memberships'));
    
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))
            ->setCancelUrl(URL::route('payment.status'));
    
        $payment = new pay();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
    

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else {
                die('Some error occur, sorry for inconvenient');
            }
        }
    
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
    
        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
    
        if(isset($redirect_url)) {
            // redirect to paypal
            return Redirect::away($redirect_url);
        }
    
        return Redirect::to('/hotel/payment/history')
            ->with('error', 'Unknown error occurred');
    }

    public function getPaymentStatus()
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
    
        // clear the session payment ID
        Session::forget('paypal_payment_id');
    
        if (Input::get('PayerID')=="" || Input::get('token')=="") {
            return Redirect::to('/hotel/payment/history')
                ->with('error', trans('main.payment failed'));
        }
    
        $payment = pay::get($payment_id, $this->_api_context);
    
        // PaymentExecution object includes information necessary 
        // to execute a PayPal account payment. 
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
    
        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') { // payment made
            $name = explode('-', $result->transactions[0]->item_list->items[0]->name)[1];
            $plan = Plan::where('name', $name)->first();

            $user_id    = Sentry::getUser()->id;
            $payment = Payment::where('user_id', $user_id)->first();
            $time = $plan->time;
            
            if(explode('-', $result->transactions[0]->item_list->items[0]->name)[0] == 'Update'){
                $create =  Carbon::parse($payment->updated_at);
                $caducidad = $create->addDays($payment->time);
                $dt = Carbon::now();
                $time = $dt->diffInDays($caducidad)+1;
            }

            if(explode('-', $result->transactions[0]->item_list->items[0]->name)[0] != 'Update'){
                $create =  Carbon::parse($payment->updated_at);
                $caducidad = $create->addDays($payment->time);
                $dt = Carbon::now();
                $dif = $dt->diffInDays($caducidad);
                if($dif > 0){
                   $time = $dif+$plan->time;
                }
            }

            $payment->time = $time;
            $payment->paid = 1;
            $payment->plan_id = $plan->id;
            $payment->price  = round($result->transactions[0]->item_list->items[0]->price, 2);
            $payment->save();

            $userpayment = new Userpayment;
            $userpayment->user_id = $user_id;
            $userpayment->plan_id = $plan->id;
            $userpayment->paid = 1;
            $userpayment->price = round($result->transactions[0]->item_list->items[0]->price, 2);
            $userpayment->time = $time;
            $userpayment->save();


            return Redirect::to('/hotel/payment/history')->with('success', trans('main.payment success'));
        }
        return Redirect::to('/hotel/payment/history')
            ->with('error', trans('main.payment failed'));
    }
}