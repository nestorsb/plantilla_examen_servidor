<?php

namespace App\Controllers;

use App\Views\UserProfileView;
use App\Models\Stats;
use App\Core\DataBase;

class UserProfileController
{
    public function showprofile(){
        session_start();
        $username = $_SESSION["agentname"];
        new UserProfileView($username);
    }
}
