<?php

namespace Orders;

class OrderProcessor
{
    private $validator;
    private $orderDeliveryDetails;

    public function __construct($orderDeliveryDetails) {
        $this->orderDeliveryDetails = $orderDeliveryDetails;
        $this->validator = OrderValidator::create();
    }
    public function process($order)
    {
        ob_start();
        echo "Processing started, OrderId: {$order->order_id}\n";
        $this->validator->validate($order);
        if ($order->is_valid) {
            echo "Order is valid\n";
            $this->addDeliveryCostLargeItem($order);
            if($order->is_manual) {
                echo "Order \"" . $order->order_id . "\" NEEDS MANUAL PROCESSING\n";
            } else {
                echo "Order \"" . $order->order_id . "\" WILL BE PROCESSED AUTOMATICALLY\n";
            }
            $deliveryDetails = $this->orderDeliveryDetails->getDeliveryDetails(count($order->items));
            $order->setDeliveryDetails($deliveryDetails);
        } else {
            echo "Order is invalid\n";
        }
        $this->printToFile($order);
    }
    public function addDeliveryCostLargeItem($order)
    {
        foreach ($order->items as $item) {
            if(in_array($item, [3231, 9823])) {
                $order->totalAmount = $order->totalAmount + 10;
            }
        }
    }
    public function printToFile($order)
    {
        $result = ob_get_contents();
        ob_end_clean();

        if($order->is_valid) {
            $lines = explode("\n", $result);
            $linesWithoutDebugInfo = [];
            foreach ($lines as $line) {
                if(strpos($line, "Reason:") == false) {
                    $linesWithoutDebugInfo[] = $line;
                }
            }
        }
        file_put_contents('orderProcessLog', @file_get_contents('orderProcessLog') . implode("\n", $linesWithoutDebugInfo ?? [$result]));
        if($order->is_valid) {
            file_put_contents('result', @file_get_contents('result') . $order->order_id . '-' . implode(',', $order->items) . '-' . $order->deliveryDetails . ($order->is_manual ? 1 : 0) . '-' . $order->totalAmount . '-' . $order->name . "\n");
        }
    }
}
?>