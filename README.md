# Moadian - سامانه مودیان مالیانی 

کد PHP برای اتصال به سامانه مودیان مالیاتی (نظام پایانه های فروشگاهی و سامانه مودیان). 

PHP code for connecting to Moadian Maliati Organization (Store Terminals and Taxpayer System).

## Disclaimer
This software is provided as is without any warranty whatsoever, including accuracy and comprehensiveness. We are not associated with Moadian Maliati Organization and we have worked with the API just as simple clients so we are limited in the amount of support and help we can give regarding the functionality of the API. We have however personally used this package and have successfully submitted tens of thousands of invoices.

## Installation

```bash
composer require snapp-market-pro/moadian
```

## Usage

1. Generate an RSA key pair according to specifications in moadian admin panel.
2. Upload the public key of that key pair and get a username.
3. Following [get-tax-org-public-key](examples/get-tax-org-public-key.php) get Tax Organization public key and key ID and store them somewhere.
4. Construct the `Moadian` class with your private key, tax org public key, tax org key ID, your username and base url of tax org api if needed.
5. Login and set the received token on `Moadian` class.
6. Send Invoices or Inquire their status by reference numbers following [send-invoices](examples/send-invoices.php) or [inquire-by-reference-numbers](examples/inquire-by-reference-numbers.php).