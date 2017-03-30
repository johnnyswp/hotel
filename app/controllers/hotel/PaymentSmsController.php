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
class PaymentsSmsController extends BaseController
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
        $plans = PlanSms::get();
        $user    = Sentry::getUser();
        $payment  = PaymentSms::where('user_id', $user->id)->first();
        return View::make('hotel.Paymentsms.plan')->with('plans', $plans)->with('payment', $payment);
    }

    public function getHistory()
    {   
        $user    = Sentry::getUser();
        $payment  = PaymentSms::where('user_id', $user->id)->first();
        $payms = UserPaymentSms::where('user_id', $user->id)->orderby('id','desc')->paginate(10);
        if($payment){
           $plan = PlanSms::find($payment->plan_id);
           $payms = UserPaymentSms::where('user_id', $user->id)->orderby('id','desc')->paginate(10);
           return View::make('hotel.Paymentsms.History')->with('plan', $plan)->with('user', $user)->with('payms', $payms)->with('payment', $payment); 
        }else{
           return View::make('hotel.Paymentsms.History')->with('user', $user)->with('payms', $payms);
        }
    }

    public function postPayment()
    {
        $plan = PlanSms::find(Input::get("plan_id"));

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName($plan->name) // item name
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
            ->setDescription('Pago de '.$plan->sms.' SMS');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('hotel.sms.payment.status'))
            ->setCancelUrl(URL::route('hotel.sms.payment.status'));
    
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
    
        return Redirect::to('/hotel/payment/sms/history')
            ->with('error', 'Unknown error occurred');
    }

    public function getPaymentStatus()
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
    
        // clear the session payment ID
        Session::forget('paypal_payment_id');
    
        if(Input::get('PayerID')=="" || Input::get('token')=="") {
            return Redirect::to('/hotel/payment/sms/history')
                ->with('error', 'Payment failed');
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
            $name = $result->transactions[0]->item_list->items[0]->name;
            $plan = PlanSms::where('name', $name)->first();
            $user_id = Sentry::getUser()->id;

            $userpayment = new UserPaymentSms;
            $userpayment->sms = $plan->sms;
            $userpayment->user_id = $user_id;
            $userpayment->plan_id = $plan->id;
            $userpayment->price = $plan->price;
            $userpayment->save();

            return Redirect::to('/hotel/payment/sms/history')->with('success', 'Payment success');
        }
        return Redirect::to('/hotel/payment/sms/history')
            ->with('error', 'Payment failed');
    }
}