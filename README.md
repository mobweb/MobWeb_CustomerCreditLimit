# MobWeb_CustomerCreditLimit extension for Magento

This extension blocks selected payment methods once a customer's total unpaid order totals exceed a specific amount.

**Please note** that due to some limitations in the way that Magento's payment methods are set up, this module overwrite's the abstract Mage_Payment_Model_Method_Abstract core model. Unfortunately it is not possible to extend this model since it is abstract. Because the rewrite is based on the 1.7.0.2 version of this model, it is recommended to manually upgrade this core model file (located at app/code/local/Mage/Payment/Method/Model/Abstract.php) once a newer verison of Magento CE becomes available. The changes to this model made by this module start at line 657 and continue until the end of that function.

## Installation

Install using [colinmollenhour/modman](https://github.com/colinmollenhour/modman/).

## Questions? Need help?

Most of my repositories posted here are projects created for customization requests for clients, so they probably aren't very well documented and the code isn't always 100% flexible. If you have a question or are confused about how something is supposed to work, feel free to get in touch and I'll try and help: [info@mobweb.ch](mailto:info@mobweb.ch).