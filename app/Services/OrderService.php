<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Tracking;
use App\Services\MailService;

class OrderService
{
    public function updateOrderStatus($orderId, $newStatus, $note, $externalOrderId, $customerEmail = null)
    {

        $orderModel = new Order();
        $orderModel->updateStatus($orderId, $newStatus);
        $trackingModel = new Tracking();
        $trackingModel->addHistory($orderId, $newStatus, $note);

        if ($customerEmail) {
            $mailService = new MailService();
            $mailService->sendStatusUpdate($customerEmail, $externalOrderId, $newStatus, $note);
        }
        return true;
    }
}
