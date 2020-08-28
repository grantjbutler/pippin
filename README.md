# Pippin

Pippin is a library for handling [PayPal IPNs](https://developer.paypal.com/docs/api-basics/notifications/ipn/) in Laravel.

## Usage

1. Type-hint the request in your route handler to opt-in to IPN verification:
  ```php
  use Pippin\IPNRequest;
  
  class MyController extends Controller {
    
    public function ipn(IPNRequest $request) {
      // Do something.
    }
    
  }
  ```

2. Access data about the IPN to [validate the notification](https://developer.paypal.com/docs/api-basics/notifications/ipn/IPNIntro/#a-sample-ipn-message-and-response) and process it for your application.
  ```php
  use Pippin\IPNRequest;
  
  class MyController extends Controller {
    
    public function ipn(IPNRequest $request) {
      $ipn = $request->getIPN();
      // $ipn is an instance of Pippin\IPN.
      $payerEmail = $ipn->getPayerEmail();

      $transaction = $ipn->getTransactions()[0];
      $receiverEmail = $transaction->getReceiver();
    }
    
  }
  ```
