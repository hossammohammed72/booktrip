<?php 
namespace App\Requests;

class UserRequest{
    
    public function __construct(
        public string $name,
        public string $email,
    )
    {}
}
?>