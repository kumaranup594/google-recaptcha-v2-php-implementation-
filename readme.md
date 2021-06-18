# Setup Google Recaptcha V2
This project will help you to setup google recaptcha in any PHP website.

## Client side implementation
Here are the steps:

- Generate your keys
- Copy site key 
- Paste in your form
e.g 
```html
<div class="g-recaptcha" data-sitekey="-----"></div>
``` 
- It will enable recaptcha in your form
- We are done here - let's validate on server side.
- example in given at contact-form.php

## Server Side Implementation
Copy the logic of server-side.php
and follow the steps
- replace the secret
```php
$formData = [
    'secret' => '---', // here
    'response' => $_REQUEST['g-recaptcha-response'],
    'remoteip' => getIP()
];
```
- step 2. we are hitting curl to validate server to server.
```php
$res = pushCURL('https://www.google.com/recaptcha/api/siteverify', $formData, true);
```
- Step 3. decoding the response and checking success is coming or not
```php
$res = json_decode($res, true);
if (!isset($res['success'])) {
    $_REQUEST['err_msg'] = "Invalid Captacha";
} else if ($res['success'] == false) {
    $_REQUEST['err_msg'] = "Invalid Captacha, or expired, please try again";
}
```
Now you can implement what do you want to do with this logic.