# Currency Converter

This converts the amount between 2 currencies.

It uses two services for now

1. Float Rates
2. Fx Exchanges Rates

`Float Rate Service` is enabled, if want to switch then turn the `active` flag on the service to `true`

Helper will use the first one it finds active
## Tests

Tests can be run from base dir `vendor/bin/phpunit tests/`
