<?php

namespace App\Views;


class RegisterView
{
  public function __construct()
  {
    echo ('<h3>RESGISTER</h3><form method="post" action="" name="signup-form">
    <div class="form-element">
        <label>Username</label>
        <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
    </div>
    <div class="form-element">
    <label>Password</label>
    <input type="password" name="password" required />
    </div>
    <div class="form-element">
    <label>Faction</label>
      <select name="faction">
      <option value="R">Resistance</option>
      <option value="E">Enlightened</option>
      </select>
    </div>
    <button type="submit" name="register" value="register">Register</button><br>
    <a href="/">Volver</a>
</form>');
  }
}