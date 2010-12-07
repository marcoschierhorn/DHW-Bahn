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
      $this['updated_at'],
      $this['survey_id'],
      $this['survey_anlaesse_list'],
      $this['survey_angebot_verkehrsmittel12_list'],
      $this['survey_anlaesse_list'],
      $this['survey_angebot_verkehrsmittel_allgemein_list'],
      $this['survey_gefallen_id']
    );

    $this->setWidget('captcha', new sfWidgetFormInput());
    $this->getWidget('captcha')->setLabel('Verifikationscode');
    $this->setValidator('captcha', new sfValidatorSfCryptoCaptcha(array('required' => true, 'trim' => true),
                                                   array('wrong_captcha' => 'Bitte geben Sie einen gültigen Verifikationscode ein.',
                                                         'required' => 'Bitte geben Sie den Verifikationscode ein.')));

    $this->getValidator('email')->setMessage('invalid', 'Bitte geben Sie eine gültige E-Mail Adresse ein');
    $this->getValidator('plz')->setMessage('invalid', 'Bitte geben Sie eine gültige PLZ ein');

    $this->getWidget('email')->setLabel('E-Mail-Adresse');
    $this->getWidget('strasse')->setLabel('Straße/Hausnummer');
    $this->getWidget('standorte_id')->setLabel('Mein Studienort');
    $this->getWidget('plz')->setLabel('PLZ');

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('email'))),
        new dhwValidatorNames(array('model' => 'User', 'column' => array('vorname', 'nachname'), 'throw_global_error' => true))
      ))
    );

    $this->getValidator('standorte_id')->setOption('required', true);

    $this->widgetSchema->setFormFormatterName('Bahn');

  }
}
