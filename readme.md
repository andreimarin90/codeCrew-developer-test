Please improve/refactor this application.
Function signatures of:
Order::setName, Order::setItems, Order::setTotalAmount, OrderProcessor::process 
that are called from order_processing.php should not be changed

We will call order_processing.php, and we expect same output format in file "result"
Program is executed by calling "php order_processing.php"