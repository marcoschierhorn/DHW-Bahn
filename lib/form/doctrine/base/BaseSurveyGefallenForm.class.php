<?php

/**
 * SurveyGefallen form base class.
 *
 * @method SurveyGefallen getObject() Returns the current form's model object
 *
 * @package    bahn
 * @subpackage form
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
abstract class BaseSurveyGefallenForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'preislich'     => new sfWidgetFormChoice(array('choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1, 98 => 98))),
      'spontan'       => new sfWidgetFormChoice(array('choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1, 98 => 98))),
      'gutes_angebot' => new sfWidgetFormChoice(array('choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1, 98 => 98))),
      'freunden'      => new sfWidgetFormChoice(array('choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1, 98 => 98))),
      'entfernung'    => new sfWidgetFormChoice(array('choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1, 98 => 98))),
      'junge'         => new sfWidgetFormChoice(array('choices' => array(5 => 5, 4 => 4, 3 => 3, 2 => 2, 1 => 1, 98 => 98))),
      'user_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'preislich'     => new sfValidatorChoice(array('choices' => array(0 => 5, 1 => 4, 2 => 3, 3 => 2, 4 => 1, 5 => 98))),
      'spontan'       => new sfValidatorChoice(array('choices' => array(0 => 5, 1 => 4, 2 => 3, 3 => 2, 4 => 1, 5 => 98))),
      'gutes_angebot' => new sfValidatorChoice(array('choices' => array(0 => 5, 1 => 4, 2 => 3, 3 => 2, 4 => 1, 5 => 98))),
      'freunden'      => new sfValidatorChoice(array('choices' => array(0 => 5, 1 => 4, 2 => 3, 3 => 2, 4 => 1, 5 => 98))),
      'entfernung'    => new sfValidatorChoice(array('choices' => array(0 => 5, 1 => 4, 2 => 3, 3 => 2, 4 => 1, 5 => 98))),
      'junge'         => new sfValidatorChoice(array('choices' => array(0 => 5, 1 => 4, 2 => 3, 3 => 2, 4 => 1, 5 => 98))),
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
    ));

    $this->widgetSchema->setNameFormat('survey_gefallen[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SurveyGefallen';
  }

}
