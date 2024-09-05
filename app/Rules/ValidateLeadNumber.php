<?php

namespace App\Rules;

use App\Models\ManageLead;
use Illuminate\Contracts\Validation\Rule;

class ValidateLeadNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       if(empty($value)){
        return true;
       }

        $check_query = ManageLead::where('lead_no_1',$value)->orWhereRaw("lead_no_2 = ".$value)->get();

        if($check_query->isEmpty()){
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This lead phone number already exists.';
    }
}
