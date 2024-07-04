<?php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

if (!function_exists('generateSlug')) {
    function generateSlug($model, $title) {
        $modelCible = "App\Models"."\\".$model;
        do {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@&%-*';
            $slug = substr(str_shuffle($permitted_chars), 0, 43);
            $exists = $modelCible::where(['slug' => $slug])->first();
        } while ($exists);
        return $slug;
    }
}




if (!function_exists('getListDialCode')) {
    function getListDialCode()  {
            try{
                $response = Http::timeout(5)->get('https://restcountries.com/v3.1/all');
                $countries = json_decode($response->getBody()->getContents(), true);

                $dialCodes = collect($countries)->map(function ($country) {
                    $dialCode = null;

                    if (isset($country['idd']['root']) && !empty($country['idd']['suffixes']) && is_array($country['idd']['suffixes'])) {
                        $dialCode = $country['idd']['root'] . $country['idd']['suffixes'][0];
                    }

                    return [
                        'name' => $country['name']['common'] ?? 'Unknown',
                        'dial_code' => $dialCode,
                        'country_code' => strtolower($country['cca2'] ?? ''), // Code du pays en minuscule
                    ];
                });

                return $dialCodes->sortBy('name')->toArray();

        } catch (\Throwable $th) {
            return [
                [
                    'name' => 'Côte d’Ivoire',
                    'dial_code' => "+225",
                    'country_code' => 'ci',
                ]
            ];
        }
    }
}

if (!function_exists('generatePasswordAleatoire')) {
    function generatePasswordAleatoire()  {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
