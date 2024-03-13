# Mobile ISP

Mobile ISP is a PHP project that provides information about a phone number sent to the endpoint. It retrieves details such as the ISP (Internet Service Provider), country information, country dial code, and phone number in international format. Currently, the endpoint supports phone number lookups for Nigeria and Ghana.

## Installation

1. Download the project files.
2. Extract the files to your server directory.
3. Include the `autoload.php` file located inside the `app` folder in your project.

## Usage

To perform a phone number lookup, use the following syntax:

```php
<?php
require_once('app/autoload.php');

// Make a lookup
$response = Provider::get('your_phone_number_here');

// Handle the response
echo $response;
?>
```

Replace 'your_phone_number_here' with the phone number you want to lookup.

The Provider::get() method returns a JSON response with all the information needed.

## Contribution

Contributions to Mobile ISP are welcomed! Feel free to submit pull requests or open issues if you encounter any problems or have suggestions for improvement.

## Dependencies

This project does not rely on any external dependencies, making it easy to set up and use.

## License

This project is licensed under the [MIT License](LICENSE).
