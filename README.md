# README #

This describes the requirements and how to get started with this test app.

## Requirements ##

* PHP 8.0+
* [Composer](https://getcomposer.org/)

## How to get started ##

Firstly, install the dependencies:
```bash
$ composer install
```

Now run the server locally:
```bash
$ php -S localhost:8080 -t public
```

You can test the server is working by running this CURL command:
```bash
$ curl localhost:8081/ping
pong
```

Or run the unit tests:
```bash
$ ./bin/phpunit tests/
```

## Technical test ##

### Requirements ###

Sign up for an account at https://www.weatherapi.com/ (this is free)
and generate an API Key. Update this in `Playfinder\Router`.

### Deliverables ###

You must, using the Weather API provided create API endpoints to provide the following:

An API endpoint which returns the forecast for a given city (e.g. London), in a simple format
such as "Sunny", "Rain", "Showers" etc. This response should be less than 1KB in size.

These should be at `/<city>/forecast` for a one-day forecast and at `/<city>/3-day` for a 3-day forecast.

Look at the `Router` and `Ping` files for examples on how to create new routes. See the
[Slim Documentation](https://www.slimframework.com/) for examples and other documentation.

**Please bear in mind:**
* Invalid city locations
* Potential issues with the API
* Other invalid endpoints

### Further optional contributions ###

* Write Unit tests to cover the classes you created
* Allow clients to request a simple image depending on the `Accept` HTTP header
* Provide or generate Swagger (OpenAPI) documentation for your endpoints

### I'm having difficulties! ###

Email [Nathan](mailto:nathan@playfinder.com) with a description of your problem,
and he will be happy to help.
