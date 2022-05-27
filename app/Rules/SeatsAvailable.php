<?php 
namespace App\Rules;
use App\Models\Trip;
use Illuminate\Contracts\Validation\ImplicitRule;

class SeatsAvailable implements ImplicitRule{
      /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value <= Trip::find(request()->get('trip_id'))->remaining_seats;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The trip doesn\'t have enough seats';
    } 
}
?>