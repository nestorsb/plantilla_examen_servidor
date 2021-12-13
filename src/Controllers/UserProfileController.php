<?php

namespace App\Controllers;

use App\Views\UserProfileView;
use App\Models\Profile;
use App\Core\DataBase;

class UserProfileController
{
    public function showprofile(){
        session_start();
        $username = $_SESSION["agentname"];
        $Profile = new Profile(new DataBase);
        new UserProfileView($username);

        if(isset($_POST['upload'])){
            $Profile->validateStats($_POST['textarea']);
        }
    }
}
