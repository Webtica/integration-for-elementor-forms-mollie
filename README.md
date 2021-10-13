# Integration for Elementor forms - Mollie

Easily create payments for Mollie after an elementor form submission.
Keeping performance in mind this integration doesn't add any additional scripts on page load. 
Feel free to post any feature requests and possible issues.

What you can expect in the future: 
* A database where you can see al orders that are made. 
* Subscriptions.
* Calculate the payment value via one or more fields in the form.
* Set payment settings via form fields. 

## Installation

### Minimum Requirements

* WordPress 5.0 or greater
* PHP version 5.4 or greater
* MySQL version 5.0 or greater
* [Elementor Pro](https://elementor.com) 3 or greater

### We recommend your host supports:

* PHP version 7.0 or greater
* MySQL version 5.6 or greater
* WordPress Memory limit of 64 MB or greater (128 MB or higher is preferred)


## Installation

1. Install using the WordPress built-in Plugin installer, or Extract the zip file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Pages > Add New
4. Press the 'Edit with Elementor' button.
5. Drag and drop the form widget of Elementor Pro from the left panel onto the content area, and find the Mollie action in the "Actions after submit" dropdown.
6. Fill your Mollie data and you are all set.


## Frequently Asked Questions

**Why is Elementor Pro required?**

Because this integration works with the Form Widget, which is a Elementor Pro unique feature not available in the free plugin.

**Can I still use other integrations if I install this integration?**

Yes, all the other form widget integrations will be available.

## Changelog

### 1.0.0 - 13-10-2021
* Initial Release