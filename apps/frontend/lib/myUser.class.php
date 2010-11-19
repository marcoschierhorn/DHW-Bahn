<?php

class myUser extends sfGuardSecurityUser
{
  public function setUserId($user_id)
  {
    $this->getAttribute('user_id', $user_id);
  }

  public function getUserId()
  {
    return $this->getAttribute('user_id');
  }
}
