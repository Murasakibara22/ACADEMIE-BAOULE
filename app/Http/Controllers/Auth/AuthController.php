<?php

namespace App\Http\Controllers\Auth;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAdress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dial_code' => 'required|max:6',
            'phone_number' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ],[
            'first_name.required' => 'Le champ Nom est obligatoire.',
            'first_name.string' => 'Le champ Nom  doit être une chaine de caractères.',
            'fisrt_name.max' => 'Le champ Nom ne doit pas dépasser 255 caractères.',
            'last_name.required' => 'Le champ Prénom est obligatoire.',
            'last_name.string' => 'Le champ Prénom doit être une chaine de caractères.',
            'last_name.max' => 'Le champ Prénom ne doit pas dépasser 255 caractères.',
            'dial_code.required' => 'Le champ Code téléphonique est obligatoire.',
            'dial_code.numeric' => 'Le champ Code téléphonique doit être un nombre.',
            'dial_code.max' => 'Le champ Code téléphonique ne doit pas dépasser 6 chiffres.',
            'phone_number.required' => 'Le champ N° de téléphone est obligatoire.',
            'phone_number.numeric' => 'Le champ N° de téléphone doit être un nombre.',
            'phone_number.max' => 'Le champ N° de téléphone ne doit pas dépasser 10 chiffres.',
            'email.required' => 'Le champ Email est obligatoire.',
            'email.string' => 'Le champ Email doit être une chaine de caractères.',
            'email.max' => 'Le champ Email ne doit pas dépasser 255 caractères.',
            'email.email' => 'Le champ Email doit être une adresse email valide.',
            'email.unique' => 'Cet Email est déjà utilisé.',
            'password.required' => 'Le champ Mot de passe est obligatoire.',
            'password.string' => 'Le champ Mot de passe doit être une chaine de caractères.',
            'password.min' => 'Le champ Mot de passe doit contenir au moins 8 caractères.',
        ]);

        $customer_phone_exist = Customer::where('dial_code', $request->dial_code)->where('phone_number', $request->phone_number)->first();
        if($customer_phone_exist){
            return $this->responseError("Ce numéro de téléphone est déjà enregistré");
        }

        $firstName = ucfirst(strtolower($request->get("first_name")));
        $lastName = ucfirst(strtolower($request->get("last_name")));
        $email = $request->get("email");
        $dialCode = $request->get("dial_code");
        $phoneNumber = $request->get("phone_number");
        $name = $firstName . ' ' . $lastName;
        $phone = $dialCode . $phoneNumber;

        $customer = Customer::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'dial_code' => $dialCode,
            'phone_number' => $phoneNumber,
            'email' => $email,
            'name' => $name,
            'phone' => $phone,
            'gender' => $request->get("gender"),
            'password' => Hash::make($request->password),
            'photo_url' => $request->photo_url,
            'facebook_id' => $request->get("facebook_id"),
            'google_id' => $request->get("google_id"),
            'slug' => generateSlug('Customer',$name),
        ]);

        if($request->adresse_domicile){
            $this->saveAdresserCustomer($request->adresse_domicile,$customer->id);
        }

        return response()->json([
            'access_token' => auth('api')->login($customer),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);

    }

    function RegisterOrLoginBySociale(Request $request){

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'social_id'=>'required',
            'social' => 'required',
        ],[
            'first_name.required' => 'Le champ Nom est obligatoire.',
            'first_name.string' => 'Le champ Nom  doit être une chaine de caractères.',
            'fisrt_name.max' => 'Le champ Nom ne doit pas dépasser 255 caractères.',
            'last_name.required' => 'Le champ Prénom est obligatoire.',
            'last_name.string' => 'Le champ Prénom doit être une chaine de caractères.',
            'last_name.max' => 'Le champ Prénom ne doit pas dépasser 255 caractères.',
            'dial_code.required' => 'Le champ Code téléphonique est obligatoire.',
            'dial_code.numeric' => 'Le champ Code téléphonique doit être un nombre.',
            'dial_code.max' => 'Le champ Code téléphonique ne doit pas dépasser 6 chiffres.',
            'phone_number.required' => 'Le champ N° de téléphone est obligatoire.',
            'phone_number.numeric' => 'Le champ N° de téléphone doit être un nombre.',
            'phone_number.max' => 'Le champ N° de téléphone ne doit pas dépasser 10 chiffres.',
            'email.required' => 'Le champ Email est obligatoire.',
            'email.string' => 'Le champ Email doit être une chaine de caractères.',
            'email.max' => 'Le champ Email ne doit pas dépasser 255 caractères.',
            'email.email' => 'Le champ Email doit être une adresse email valide.',
            'email.unique' => 'Cet Email est déjà utilisé.',
            'password.required' => 'Le champ Mot de passe est obligatoire.',
            'password.string' => 'Le champ Mot de passe doit être une chaine de caractères.',
            'password.min' => 'Le champ Mot de passe doit contenir au moins 8 caractères.',
            'social.required' => 'Le champ  social est obligatoire.',
            'social_id.required' => 'Le champ  social_id est obligatoire.',

        ]);

        $first_name = ucfirst(strtolower($request->get("first_name")));
        $last_name = ucfirst(strtolower($request->get("last_name")));
        $email = strtolower($request->get('email'));
        $social = $request->get('social');
        $social_id = $request->get('social_id');
        $photo_url = $request->get('photo_url');
        $name = $first_name . " " . $last_name;

        $customer_exist;
        if ($social == "facebook") {
            $customer_exist =  Customer::where(['facebook_id' => $social_id])->first();
        }

        if ($social == "google") {
            $customer_exist = Customer::where(['google_id' => $social_id])->first();
        }

        // Login Customer
        if ($customer_exist) {
            return $this->respondWithToken(auth('api')->login($customer_exist));
        }

        // Register new customer
        $customer = Customer::create([
            'photo_url' => $photo_url ?? null,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "name" => $name,
            "email" => $email,
            "gender" => $request->get('gender') ?? null,
            "dial_code" => $request->get('dial_code') ?? null,
            "phone_number" => $request->get('phone_number') ?? null,
            "phone" => $request->get('dial_code') && $request->get('phone_number') ? $request->get('dial_code') . $request->get('phone_number') : null,
            "password" => null,
            'facebook_id' => $social == 'facebook' ? $social_id : null,
            'google_id' => $social == 'google' ? $social_id : null,
            'slug' => generateSlug('Customer',$name),
        ]);

        if($request->adresse_domicile){
            $this->saveAdresserCustomer($request->adresse_domicile, $customer->id);
        }

        return response()->json([
            'access_token' => auth('api')->login($customer),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function loginByPhone()
    {
        request()->validate([
            'dial_code' => 'required|numeric',
            'phone_number' => 'required|numeric',
        ],[
            'dial_code.required' => 'Le champ dial_code est obligatoire.',
            'dial_code.numeric' => 'Le champ dial_code doit être un nombre.',
            'dial_code.max' => 'Le champ dial_code ne doit pas dépasser 6 chiffres.',
            'phone_number.required' => 'Le champ N° de téléphone est obligatoire.',
            'phone_number.numeric' => 'Le champ N° de téléphone doit être un nombre.',
            'phone_number.max' => 'Le champ N° de téléphone ne doit pas dépasser 10 chiffres.',
        ]);

        $credentials = request(['dial_code', 'phone_number']);

        $customer = Customer::where($credentials)->first();
        if (empty($customer)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$token = auth('api')->login($customer)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function verifyCustomer(Request $request)
    {
        if (empty($request->get("dial_code"))) {
            return $this->responseError("Préfixe téléphonique requis");
        }

        if (empty($request->get("phone_number"))) {
            return $this->responseError("Numéro teléphone requis");
        }

        $credentials = request(['dial_code', 'phone_number']);

        $customer = Customer::where($credentials)->first();

        if (empty($customer)) {
            return $this->responseError("Utilisateur introuvable.", 404);
        }

        return $this->responseSuccess($customer);
    }

    public function me()
    {
        return $this->responseSuccess(auth('api')->user());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        auth('api')->logout();
        return response()->json(['message' => 'Déconnection effectuée avec succès']);
    }




    private function saveAdresserCustomer($domicile_point,$newCustomer_id) {
        $domicile = CustomerAdress::create([
            'customer_id' => $newCustomer_id,
            'name' => 'Domicile',
            'address_name' => $domicile_point['name'],
            'latitude' => $domicile_point['latitude'],
            'longitude' => $domicile_point['longitude']
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
