=== Conditional Fields in Elementor Form===
Contributors: rajkakadiya, rvadhel
Tags: elementor form, conditional fields in elementor forms
Requires PHP: 7.4
Requires at least: 6.3
Tested up to: 6.6
Requires Plugins: elementor, elementor-pro
Stable tag: 1.0.0
Elementor tested up to: 3.24.0
Elementor Pro tested up to: 3.24.0
License: GPLv2 or later

Conditional Fields in Elementor Form helps you to show or hide fields based on input values from other fields using conditional logic.

== Description ==

Conditional Fields for Elementor Form is an addon for Elementor that helps you apply conditional logic to Elementor form fields. You can hide or show fields based on the input values from other form fields.

* Basically, it utilizes “If condition” logic. For example, if condition A is true, then field XYZ will be visible; otherwise, it remains hidden within the Elementor form.

**Elementor Pro does not support conditional logic inside its form widget fields, so we created Conditional Field addon. It provides you with the option to enable conditions on Elementor form fields, allowing you to hide or show a form field based on the inputs from other fields.**

**NOTE:** This addon is only compatible with the Elementor Pro version because the form widget is not available in the free version of Elementor.

PLUGIN FEATURES

* **Show / Hide Fields Conditionally**
 Easily add conditional logic to show or hide any field within an Elementor form based on values from other fields. Currently, you can add conditions to these fields: text, textarea, email, telephone, URL, radio, select, file upload, HTML, number, and checkbox.

* **If / Else Logic Without Code**
 Apply if/else logic to form fields without coding. Simply add the ID of the field through which you want to apply a condition. For example, if the “Query Type” field ID is “query_type,” you can set it to show the “Enter Order ID” field if “query_type == check-order-status” and hide it otherwise.

* **Conditions Triggers / Compare Operators**
 Compare field values using various operators such as is equal (==), not equal (!=), greater than (>), less than (<), greater than or equal to (>=), less than or equal to (<=), contains, does not contain, starts with, and ends with, as well as is empty and not empty.

* **Apply Multiple Conditions (AND / OR Logic)**
 Apply multiple conditions to form fields using AND/OR logic. This means actions are triggered if ANY or ALL conditions are met.

* **Conditionally Redirect After Submission**
 Conditionally redirect your Elementor form to a specific URL after submission based on met conditions, such as redirecting to URL-1 if condition-1 is true, otherwise to URL-2.

* **Send Email Conditionally**
 Send different emails to various user types based on their inputs in the Elementor form. Design two to three types of emails and send them to users based on conditions matching their inputs.

* **No Validation Errors**
 You will not encounter validation errors if a required field is hidden due to a condition.

== Screenshots ==

1. Conditionally show or hide Elementor form fields
2. How to add conditional logic to an Elementor form
3. Trigger conditions using multiple comparison operators
4. Conditionally redirect the form based on user input
5. Conditionally send email based on user input

== Changelog ==

= 1.0.0 =
 Initial release