<?php

/**
 * User form.
 *
 * @package    bahn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
    unset(
      $this['id'],
      $this['codes_id'],
      $this['created_at'],
      $this['updated_at']
    );

    $this->setWidget('captcha', new sfWidgetFormInput());
    $this->getWidget('captcha')->setLabel('Bitte geben Sie den Captcha Code ein');
    $this->setValidator('captcha', new sfValidatorSfCryptoCaptcha(array('required' => true, 'trim' => true),
                                                   array('wrong_captcha' => 'Bitte geben Sie einen gültigen Captcha Code ein.',
                                                         'required' => 'Bitte geben Sie den Captcha Code ein.')));



    $this->getWidget('standorte_id')->setLabel('Standort');

  }
}
