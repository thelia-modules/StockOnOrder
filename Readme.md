# StockOnOrder

Configure, for each payment module, how product's stock is managed when an order is created or when an order status is updated.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is StockOnOrder.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/stock-on-order-module:~1.0
```

## Usage

Once activated, click on the "Configure" button of the module. 
The payment module list appears:
- the module tells you if the stock behavior when updating an order status is modified or is still the default Thelia behavior
- you can choose if the stock has to be decreased at the creation of an order
- you can click a module name or the corresponding "Edit" button to configure stock behavior when an order status is changed
Editing a payment module behavior shows you the list of order status. For each status, you can say what has to be done on stocks when you set it to an order:
- do nothing on the stock of products of the order
- decrease stock
- increase stock (when an order is cancelled for example)
- let Thelia default behavior

**IMPORTANT THINGS YOU REALLY HAVE TO READ**
- if you choose to decrease stocks on order creation, be sure to configure behavior when updating an order status to avoid double decrease of your stock by Thelia default behavior
- when configuring actions on stock on order status update, don't mix your configuration and Thelia default behavior unless you know what you do.

## Hook

The only hook used is the ```module.configuration``` one to let you configure the module.
