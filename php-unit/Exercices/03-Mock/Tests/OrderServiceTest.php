<?php

namespace Tests;

use App\Classes\Order;
use App\Services\OrderService;
use App\Classes\Logger;
use App\Classes\Mailer;
use App\Classes\Paymentgateway;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testPlaceOrderOnSuccess(){
        //! ============ set up
        $email = "user@user.fr";
        $logger = $this->createMock(Logger::class);
        $mailer = $this->createMock(Mailer::class);
        $payment = $this->createMock(Paymentgateway::class);
        $order = new Order(101, 19999);
        
        // On attend que le mailer s'active 1 fois
        $mailer->expects($this->once())
                ->method('send')
                ->with($email, $this->stringContains($order->id))
                ->willReturn(true);
        
        $logger->expects($this->once())
            ->method("log")
            ->with($this->stringContains($order->id));

        $payment->expects(($this->once()))
            ->method("charge")
            ->with(19999 )
            ->willReturn(['status' => 'success']);

        
        //! ============ action
        $orderService = new OrderService($logger, $mailer, $payment );
        $result = $orderService->placeOrder($order, $email);

        //! ============ assert

        $this->assertSame("success", $result["payment"]["status"]);
        $this->assertSame($order->id, $result["id"]);



    }
}
