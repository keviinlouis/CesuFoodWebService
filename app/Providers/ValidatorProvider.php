<?php

namespace App\Providers;

use App\Entities\Composto;
use Illuminate\Support\ServiceProvider;
use Validator;

class ValidatorProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $min_field = explode('.', $parameters[0]);
            $data = $validator->getData();

            foreach($min_field as $field){
                if(!isset($data[$field])){
                    return true;
                }
                $data = $data[$field];
            }
            return $value > $data;
        });

        Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        Validator::extend('lower_than_field', function($attribute, $value, $parameters, $validator) {
            $min_field = explode('.', $parameters[0]);
            $data = $validator->getData();

            foreach($min_field as $field){
                if(!isset($data[$field])){
                    return true;
                }
                $data = $data[$field];
            }
            return $value < $data;
        });

        Validator::replacer('lower_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });

        Validator::extend('not_equals', function($attribute, $value, $parameters, $validator) {
            $min_field = explode('.', $parameters[0]);
            $data = $validator->getData();

            foreach($min_field as $field){
                if(!isset($data[$field])){
                    return true;
                }
                $data = $data[$field];
            }
            return $value != $data;
        });

        Validator::replacer('not_equals', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
