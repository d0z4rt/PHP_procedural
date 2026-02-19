<?php


Namespace App\Services;

use App\Classes\Logger;
use App\Classes\Mailer;
use App\Classes\PaymentGateway;
use App\Classes\Order;

class OrderService
{
    // private $logger;
    // private $mailer;
    // private $paymentGateway;

    // public function __construct(Logger $logger, Mailer $mailer, PaymentGateway $paymentGateway)
    // {
    //     $this->logger = $logger;
    //     $this->mailer = $mailer;
    //     $this->paymentGateway = $paymentGateway;
    // }
    // private $logger;
    // private $mailer;
    // private $paymentGateway;

    public function __construct(
        private Logger $logger,
        private Mailer $mailer,
        private PaymentGateway $paymentGateway)
    {
        // $this->logger = $logger;
        // $this->mailer = $mailer;
        // $this->paymentGateway = $paymentGateway;
    }

    public function placeOrder(Order $order, $userMail):array
    {
        
        $this->logger->log("Commande n° ". $order->id ." confirmé pour en montant de ". $order->amount ."euro");

        $paymentResult = $this->paymentGateway->charge($order->amount);

        if($paymentResult === ["status" => "success"]){

            $this->mailer->send($userMail, "Votre commande n°". $order->id ." est confirmé");
        }

        return [
            "id" => $order->id,
            "payment" => $paymentResult
        ];
    }

}
