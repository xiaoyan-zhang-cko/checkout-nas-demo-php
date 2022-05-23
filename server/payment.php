<?php

require_once __DIR__ . DIRECTORY_SEPARATOR. '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use Checkout\CheckoutArgumentException;
use Checkout\CheckoutAuthorizationException;
use Checkout\CheckoutFourSdk;

use Checkout\Common\Address;
use Checkout\Common\Country;
use Checkout\Common\Currency;
use Checkout\Common\CustomerRequest;
use Checkout\Common\Phone;
use Checkout\Environment;
use Checkout\Payments\Four\Request\PaymentRequest;
use Checkout\Payments\Four\Request\Source\RequestTokenSource;
use Checkout\Payments\Four\Sender\Identification;
use Checkout\Payments\Four\Sender\IdentificationType;
use Checkout\Payments\Four\Sender\PaymentIndividualSender;


// API Keys
$builder = CheckoutFourSdk::staticKeys();
$builder->setPublicKey("pk_sbox_XXXXXXXXXXXXXXXXX");
$builder->setSecretKey("sk_sbox_XXXXXXXXXXXXXXXXX");
$builder->setEnvironment(Environment::sandbox()); // or Environment::production()
$api = $builder->build();

$phone = new Phone();
$phone->country_code = "+1";
$phone->number = "415 555 2671";

$address = new Address();
$address->address_line1 = "CheckoutSdk.com";
$address->address_line2 = "90 Tottenham Court Road";
$address->city = "London";
$address->state = "London";
$address->zip = "W1T 4TJ";
$address->country = Country::$GB;

$requestTokenSource = new RequestTokenSource();
$requestTokenSource->token = $_POST['cko_card_token'];


$customerRequest = new CustomerRequest();
$customerRequest->email = "email@docs.checkout.com";
$customerRequest->name = "Customer";

$identification = new Identification();
$identification->issuing_country = Country::$GT;
$identification->number = "1234";
$identification->type = IdentificationType::$drivingLicence;

$paymentIndividualSender = new PaymentIndividualSender();
$paymentIndividualSender->fist_name = "FirstName";
$paymentIndividualSender->last_name = "LastName";
$paymentIndividualSender->address = $address;
$paymentIndividualSender->identification = $identification;

$request = new PaymentRequest();
$request->source = $requestTokenSource;
$request->capture = true;
$request->reference = "Xiaoyan ZHANG Test";
$request->amount = 200;
$request->currency = Currency::$USD;
$request->customer = $customerRequest;
$request->sender = $paymentIndividualSender;

try {
    $response = $api->getPaymentsClient()->requestPayment($request);

// Print payment response to screen
    echo('<pre>'.print_r($response, true).'</pre>');

} catch (CheckoutApiException $e) {
    // API error
    $request_id = $e->request_id;
    $http_status_code = $e->http_status_code;
    $error_details = $e->error_details;
} catch (CheckoutArgumentException $e) {
    // Bad arguments
} catch (CheckoutAuthorizationException $e) {
    // Bad Invalid authorization
}
