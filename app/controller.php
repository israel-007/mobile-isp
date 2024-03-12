<?php

class provider {

    public static $prefixes = [];

    public function __construct($prefixes){

        self::$prefixes = $prefixes;

    }

    public static function check($phone_number)
    {

        $json = '';

        foreach (self::$prefixes as $country => $mtps) {

            foreach ($mtps as $mtp => $codes) {

                foreach ($codes as $code){

                    $split_number = str_split($phone_number);

                    $country_json = country::get($country);

                    if ($split_number[0] == 0) {

                        $leading_zero = true;

                    } else {

                        $leading_zero = false;

                        $code = mb_substr($code, 1);

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

}

class country
{

    public static $countries = [];

    public function __construct($countries)
    {

        self::$countries = $countries;

    }

    public static function get($country)
    {

        return json_encode(self::$countries[$country]);

    }

}


$APP_PROVIDER = new provider($prefix);

$APP_COUNTRY = new country($country);