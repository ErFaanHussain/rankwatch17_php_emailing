# rankwatch17_php_emailing
PHP script that accepts email address, Subject and Message. Sends the Message and Subject to email address using SMTP (through Mandrill API) services of mandrill/mailchimp.

### Requirement
* `Composer` 
* `Mandrill API library`

### Method
Created an account on mailchip/mandrill, got `api_key` and `secret` from the mandrill to be used for authentication in making API requests. Taking `name`, `subject` and `message` contents from the user through a form, and passing them to `mandrill` and making a request using its API. The `mandrill` API library dependency is resolved using `composer`. result from the mandrill is checked and if successfull an alert to popped to the user, if error, user is popped.

> Since I have a personal domain `erfaanhussain.co` , configured it with the Mandrill and can send emails to users from `me@erfaanhussain.co` with a personalised `from_name`. 

![Mail](https://github.com/ErFaanHussain/rankwatch17_php_emailing/blob/master/mail.png)

Screenshot of the input page
