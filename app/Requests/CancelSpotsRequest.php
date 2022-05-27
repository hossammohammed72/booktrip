<?php 
namespace App\Requests;

use App\Models\Ticket;
class CancelSpotsRequest{
    
    public function __construct(
    public int $numberOfSeats,
    public Ticket $ticket,
    )
    {}
}
?>