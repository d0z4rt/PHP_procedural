<?php

namespace App\Classes;

use App\Classes\Mailer;

class Notifier {
    private $mailer;
    
    public function __construct(Mailer $mailer) 
    { 
        $this->mailer = $mailer; 
    }
    
    public function notifyAll(array $emails): void {
        foreach ($emails as $email) {
            $this->mailer->send($email, "Notification importante");
        }
    }
}
