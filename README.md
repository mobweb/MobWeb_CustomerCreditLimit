# MobWeb_CustomerCreditLimit extension for Magento

This extension blocks selected payment methods once a customer's total unpaid order totals exceed a specific amount. You can also display a notice if a customer's credit limit has been reached, that informs the customer why one (or more) payment method(s) are currently not available to them.

## Installation

Install using [colinmollenhour/modman](https://github.com/colinmollenhour/modman/).

## Configuration

You can configure the credit limit per customer and the blocked payment methods under *System -> Configuration -> (Sales) -> Customer Credit Limit*.

To display a notice on the «Select payment method» step during the checkout if a certain payment method is not available, you have to create a static block whose identifier has the following format: *payment_method_information_<identifier of the payment method>*, for example *payment_method_information_invoice* for the «Invoice» payment method. This static block will then be displayed during the checkout. An example of a notice would be:

```
<div class="notice-msg"><ul><li><span>The payment method «Invoice» is currently unavaibale because you have reached your credit limit.</span></li></ul></div>
```

## Questions? Need help?

Most of my repositories posted here are projects created for customization requests for clients, so they probably aren't very well documented and the code isn't always 100% flexible. If you have a question or are confused about how something is supposed to work, feel free to get in touch and I'll try and help: [info@mobweb.ch](mailto:info@mobweb.ch).