# Prerequisite

Make sure you already install PHP in your local machine. If not yet you can go to this reference link to install them.

- http://php.net/manual/en/install.macosx.php
- http://php.net/manual/en/install.unix.php

# You have to know

This is the rule for our tax.

- 0 - 50.0000.000 IDR             = 5%
- 50.0000.000 - 250.0000.000 IDR  = 15%
- 250.0000.000 - 500.0000.000 IDR = 25%
- 500.0000.00 - above             = 30%

# PPH-21

This is PHP code that contains the calculation to count PHP 21 In Indonesia

Following files as described like below

- Abstract Request. An abstaction class to fetch the request for PPH 21
- Tax Exception. An exception class to handle the error for tax within the main class
- Tax Request. Actual class to fetch the request to be used together with main tax class
- Index. How we use our tax class


# Sample usage of PPH-21 Class

Just pass the parameter to the function inside index.php class which indicates the annual income you may receive

```php
countPHP21(75000000);
```

# Running file on machine

Type this command inside your terminal

```php
cd ~/your-local-project
php -S localhost:3000
```

Found the issue please go to this [link](https://github.com/frayhan32/PPH-21/issues)






