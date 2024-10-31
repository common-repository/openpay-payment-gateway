=== Openpay Payment Gateway ===
Contributors: opyintegrations
Donate link:
Tags: Openpay, Opy, BNPL, Buy Now Pay Smarter, Payment Gateway, Woocommerce
Requires at least: 4.5
Tested up to: 6.1
Stable tag: 1.2.3
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/

Openpay is a flexible payment solution provider that gives customers more time to pay. Offer Openpay as an alternative payment method at checkout.

== Overview ==

We are more than a buy now, pay later provider. 

Offering plans from 2-24 months up to $20,000 across a range of verticals, your customers can get the financing they want, for the things they need. With no interest. None.  

With the official Openpay plugin for Woocommerce, you can easily offer your customers the smarter way to pay. 
 
Openpay provides your business with the chance to:  

- increase your AOV
- improve your sales
- achieve greater brand loyalty, and
- offer a no interest ever solution for your customers. 

As customers pay a deposit, there is a reduced likelihood of customer returns. 

The Openpay plugin lets you easily add Openpay as an alternative payment method at checkout. It’s been designed to support a seamless shopping experience for your customers and give you the tools you need to manage that. In addition, as a merchant, you can easily issue partial or full refunds from within the Store Admin, as well as set qualifying customer purchase limits for using Openpay. With support for sandbox mode, our plugin also allows you to validate and test the integration for peace of mind before going live.

== Description ==

Openpay is a flexible payment solution provider that gives customers more time to pay.

## Get started by:
1.	Download and Install the Openpay payment plugin on your Woocommerce store.
2.	Activate the plugin by adding an Openpay auth token, obtained by signing up [here](https://www.opy.com/au/business/).
3.	Start offering Openpay and enjoy bigger baskets and happy customers.

## Key Features:
* It's free to install and configure
* Place orders with Openpay
* Easy to refund an order fully / partially
* Determine the purchase limits for an Openpay transaction (2-24 months, purchases up to $20,000, with no interest. None.)
* Supports sandbox mode

== Installation ==

This section outlines the steps to install the Openpay Payment Gateway plugin.

> Please note If you are upgrading to a newer version of the Openpay plugin, please consider to take backup of your website including the database before commencing the installation. 
Openpay recommends the plugin updates to be tested in a staging environment before deploying to production.

1. Login to your WordPress admin.
2. Navigate to “Plugins > Add New”.
3. Type “Openpay Payment Gateway” into the Keyword search box and press the Enter key.
4. Find the “Openpay Payment Gateway” plugin.
5. Click the “Install Now” then “Activate” button.
6. Navigate to “WooCommerce > Settings > Payments”.
7. In the settings, configure the plugin by adding an Openpay auth token, obtained by signing up [here](https://www.opy.com/au/business/):

== FAQ ==

= Need help? =

Please refer to the [User guide](https://developer.openpay.com.au/docs/wordpress-payment-plugin) to setup the plugin to your store.

== Video ==

https://www.youtube.com/watch?v=X_lMAKhxTWA

== Changelog ==

= 1.2.3 =
* Updated the plugin to process the refund for `completed` and custom order status

= 1.2.2 =
* Updated the plugin to use the Handover URL from API response

= 1.2.1 =
* Updated the plugin to receive the customer's residential and delivery address in all cases to ensure customer transacts with Openpay successfully

= 1.2.0 =
* Integrated Guzzle as a standalone package to avoid conflicts with third party plugins

= 1.1.0 =
* Place orders in Openpay
* Refund an order fully / partially
* Determine the purchase limits for an Openpay transaction
* Fixed the plugin to avoid duplicate orders being created in merchant store