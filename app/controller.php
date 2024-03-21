<?php

class provider {

    public static $prefixes = [];

    public static $countries = [];

    public function __construct(array $prefixes, array $countries){

        self::$prefixes = $prefixes;

        self::$countries = $countries;

    }

    private static function country(string $country)
    {

        return json_encode(self::$countries[$country]);

    }

    public static function check(string $phone_number)
    {

        $json = '';

        $phone_number = str_replace(' ', '', $phone_number);

        foreach (self::$prefixes as $country => $mtps) {

            foreach ($mtps as $mtp => $codes) {

                foreach ($codes as $code){

                    $split_number = str_split($phone_number);

                    $country_json = provider::country($country);

                    if ($split_number[0] == 0) {

                        $leading_zero = true;

                    } else {

                        $leading_zero = false;

                        // $code = mb_substr($code, 1);

                    }

                    $pos = strpos($phone_number, $code);

                    $international_format = ($leading_zero) ? json_decode($country_json, true)['dail_code'] . mb_substr($phone_number, 1) : json_decode($country_json, true)['dail_code'] . $phone_number;

                    $data['response'] = array(
                        'status' => 'success',
                        'mtp' => $mtp,
                        'international_format' => $international_format,
                        'country' => json_decode( $country_json )
                    );
                    
                    if ($pos === 0) {

                        $json = json_encode($data);

                    }

                }

            }
        }

        if($json){

            return $json;

        }else{

            $data['response'] = array(
                'status' => 'error',
                'number' => $phone_number,
                'error_message' => 'Phone number could not be processed'
            );

            return json_encode($data);

        }



    }

    public static function get(string $country, string $phone_number){

        (empty ($country) || empty ($phone_number)) ? $error[] = 'Country and phone number cannot be empty' : 'Country and phone number found';

        if(isset($error)){

            return 'Error found';

        }

        $country_info = provider::country(strtolower($country));

        $phone_number = str_replace(' ', '', $phone_number);

        if(!empty($country_info)){

            foreach (self::$prefixes[$country] as $mtp => $codes) {

                foreach ($codes as $code) {

                    $split_number = str_split($phone_number);

                    // $country_json = $country_info;

                    if ($split_number[0] == 0) {

                        $leading_zero = true;

                    } else {

                        $leading_zero = false;

                        // $code = mb_substr($code, 1);

                    }

                    $pos = strpos($phone_number, $code);

                    $international_format = ($leading_zero) ? json_decode($country_info, true)['dail_code'] . mb_substr($phone_number, 1) : json_decode($country_info, true)['dail_code'] . $phone_number;

                    $data['response'] = array(
                        'status' => 'success',
                        'mtp' => $mtp,
                        'international_format' => $international_format,
                        'country' => json_decode($country_info)
                    );

                    if ($pos === 0) {

                        $json = json_encode($data);

                    }

                }

            }

            if (isset($json)) {

                return $json;

            } else {

                $data['response'] = array(
                    'status' => 'error',
                    'number' => $phone_number,
                    'error_message' => 'Phone number could not be processed'
                );

                return json_encode($data);

            }

        }else{

            $data = array(
                'status' => 'error',
                'number' => $phone_number,
                'error_message' => 'Country provided could not be found'
            );

            return json_encode($data);

        }

    }



}



$APP_PROVIDER = new provider($prefixes, $countries);

// $APP_COUNTRY = new country($country);