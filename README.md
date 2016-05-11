# Pippin

Pippin is a library for handling [PayPal IPNs](https://developer.paypal.com/docs/classic/products/instant-payment-notification/) in Laravel.

## Usage

1. Register `PayPalIPNServiceProvider` in `app/config.php`:
  ```php
  'providers' => [
      // Other providers.
      
      Pippin\PayPalIPNServerProvider::class,
  ],
  ```
2. Type-hint the request in your route handler to opt-in to IPN verification:
  ```php
  use Pippin\IPNRequest;
  
  class MyController extends Controller {
    
    public function ipn(IPNRequest $request) {
      // Do something.
    }
    
  }
  ```
3. Access data about the IPN to [validate the notification](https://developer.paypal.com/docs/classic/ipn/ht_ipn/#learn-more) and process it for your application.
  ```php
  use Pippin\IPNRequest;
  
  class MyController extends Controller {
    
    public function ipn(IPNRequest $request) {
      $ipn = $request->getIPN();
      // $ipn is an instance of Pippin\IPN.
      $payerEmail = $ipn->getPayerEmail();
      $receiverEmail = $ipn->getReceiverEmail();
    }
    
  }
  ```
