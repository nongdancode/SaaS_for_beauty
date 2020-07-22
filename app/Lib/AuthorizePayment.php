<?php
/**
 * Created by IntelliJ IDEA.
 * User: letua
 * Date: 2/18/2020
 * Time: 12:14 PM
 */

namespace App\Lib;
use net\authorize\api\contract\v1 as AnetAPI;
use App\Model\Vendor;
use net\authorize\api\controller as AnetController;
class AuthorizePayment
{

    protected $Vendor;
    public function handleonlinepay($md_login_id,$md_transaction_key,$card_name,$card_number,$duedate,$csv,$amount){

        $this->Vendor = new Vendor();
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($md_login_id);
        $merchantAuthentication->setTransactionKey($md_transaction_key);


        $creditCard = new AnetAPI\CreditCardType();

        $creditCard->setCardNumber($card_number);
        $creditCard->setExpirationDate($duedate);
        $creditCard->setCardCode($csv);
        $refId = 'ref' . time();

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($paymentOne);


        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);



        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        $response->getRefId();


//
//        return  $response->getMessages();

        return $response;
    }

    public function refundTransaction($refTransId,$amount,$md_login_id,$md_transaction_key){
        $this->Vendor = new Vendor();
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($md_login_id);
        $merchantAuthentication->setTransactionKey($md_transaction_key);


        $creditCard = new AnetAPI\CreditCardType();


        $refId = 'ref' . time();

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setRefTransId($refTransId);


        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);



        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        $response->getMessages();
    }

    public function voidTransaction($refTransId,$amount,$md_login_id,$md_transaction_key){

        $this->Vendor = new Vendor();
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($md_login_id);
        $merchantAuthentication->setTransactionKey($md_transaction_key);


        $creditCard = new AnetAPI\CreditCardType();


        $refId = 'ref' . time();

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("voidTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setRefTransId($refTransId);


        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);



        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        $response->getMessages();
}

public function getStatusTransation($refTransId,$md_login_id,$md_transaction_key){
    $this->Vendor = new Vendor();
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName($md_login_id);
    $merchantAuthentication->setTransactionKey($md_transaction_key);


    // Set the transaction's refId
    // The refId is a Merchant-assigned reference ID for the request.
    // If included in the request, this value is included in the response.
    // This feature might be especially useful for multi-threaded applications.
    $refId = 'ref' . time();

    $request = new AnetAPI\GetTransactionDetailsRequest();
    $request->setMerchantAuthentication($merchantAuthentication);
    $request->setTransId($refTransId);

    $controller = new AnetController\GetTransactionDetailsController($request);

    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

    $response->getTransaction();

}


}
