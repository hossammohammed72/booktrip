<?php 
namespace App\Rules;

use App\Models\Ticket;
use Illuminate\Contracts\Validation\ImplicitRule;

class CancellableSpots implements ImplicitRule{
      /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value <= Ticket::findOrFail(request()->get('ticket_id'))->number_of_spots;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'spot numbers more than what the ticket booked';
    } 
}
?>