<?php
namespace App\Views;

class UserProfileView
{
    public function __construct($username)
    {
        echo "<h2>Hola " . $username . "</h2>";
        echo "<form action='' method='post'><label for='textarea'>Introduzca aquí las estadisticas: 
            <br> 
            <textarea name='textarea' rows='10' cols='50'></textarea></label>
            <br>
            <button type='submit' name='upload' value='upload'>Subir</button><br></form>";
    }
}


