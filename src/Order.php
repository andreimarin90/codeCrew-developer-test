<?php

namespace Orders;

class Order
{
    public $order_id;
    public $is_manual = false;
    public $name;
    public $items;
    public $totalAmount;
    public $deliveryDetails;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }

    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    public $is_valid;

    public function setDeliveryDetails($deliveryDetails)
    {
        $this->deliveryDetails = $deliveryDetails;
    }

} ?>