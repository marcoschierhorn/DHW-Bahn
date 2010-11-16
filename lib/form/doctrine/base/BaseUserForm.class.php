<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    bahn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'anrede'       => new sfWidgetFormChoice(array('choices' => array('Herr' => 'Herr', 'Frau' => 'Frau'))),
      'vorname'      => new sfWidgetFormInputText(),
      'nachname'     => new sfWidgetFormInputText(),
      'email'        => new sfWidgetFormInputText(),
      'strasse'      => new sfWidgetFormInputText(),
      'plz'          => new sfWidgetFormInputText(),
      'wohnort'      => new sfWidgetFormInputText(),
      'codes_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Codes'), 'add_empty' => true)),
      'standorte_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Standorte'), 'add_empty' => true)),
      'abgemeldet'   => new sfWidgetFormInputCheckbox(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'anrede'       => new sfValidatorChoice(array('choices' => array(0 => 'Herr', 1 => 'Frau'))),
      'vorname'      => new sfValidatorString(array('max_length' => 255)),
      'nachname'     => new sfValidatorString(array('max_length' => 255)),
      'email'        => new sfValidatorEmail(array('max_length' => 255)),
      'strasse'      => new sfValidatorString(array('max_length' => 255)),
      'plz'          => new sfValidatorInteger(),
      'wohnort'      => new sfValidatorString(array('max_length' => 255)),
      'codes_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Codes'), 'required' => false)),
      'standorte_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Standorte'), 'required' => false)),
      'abgemeldet'   => new sfValidatorBoolean(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('email')))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
