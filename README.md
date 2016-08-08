# Exercise PHP & jQuery:

In this exercise you need to create a form with 4 input fields:
- Company Symbol
- Start Date (YYYY-mm-dd)
- End Date (YYYY-mm-dd)
- Email

### When the user submits the form you must do the following:
Validate the form both on client and server side and place appropriate messages
on both cases. All fields must be mandatory. Include also validation for:
- format and logic for dates
- existence for company symbol
- format for email

#### Display on screen the historical quotes for the submitted company in the given
date range in table format (Date, Open, High, Low, Close, Volume and AdjClose
values).
- Company symbols can be found here:
http://www.nasdaq.com/screening/companies-by-name.aspx (For download in excel
format: http://www.nasdaq.com/screening/companies-by-name.aspx?
&render=download)

- Data should be retrieved by using the CSV API:
http://ichart.finance.yahoo.com/table.csv by passing submitted company’s symbol as get parameter with key s i.e. http://ichart.finance.yahoo.com/table.csv?s=GOOG

#### Display a chart of the open and close prices in the given date range.

#### Send an email using the submitted company’s name as subject (i.e. Google) and the start date and end date as body (i.e. "From 2016-01-01 to 2016-02-01").


The above exercise is solved with Laravel PHP Framework.


# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
