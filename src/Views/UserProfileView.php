<?php
namespace App\Views;

class UserProfileView
{
    public function __construct($username)
    {
        echo "<h2>Hola " . $username . "</h2>";
    }
}

?>
