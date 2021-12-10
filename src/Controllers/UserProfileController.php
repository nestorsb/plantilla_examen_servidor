<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Views\UserProfileView;
use App\Models\Stats;
use App\Core\DataBase;

class UserProfileController extends AbstractController
{
    public function showprofile(){
        $username = $_SESSION["agentname"];
        new UserProfileView($username);
    }
}
