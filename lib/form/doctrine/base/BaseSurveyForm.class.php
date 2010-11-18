<?php

/**
 * Survey form base class.
 *
 * @method Survey getObject() Returns the current form's model object
 *
 * @package    bahn
 * @subpackage form
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
abstract class BaseSurveyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                    => new sfWidgetFormInputHidden(),
      'survey_angebot_bekannt_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SurveyAngebotBekannt'), 'add_empty' => true)),
      'survey_angebot_vergleichbare_reise_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SurveyAngebotVergleichbareReise'), 'add_empty' => true)),
      'created_at'                            => new sfWidgetFormDateTime(),
      'updated_at'                            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'survey_angebot_bekannt_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SurveyAngebotBekannt'), 'required' => false)),
      'survey_angebot_vergleichbare_reise_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SurveyAngebotVergleichbareReise'), 'required' => false)),
      'created_at'                            => new sfValidatorDateTime(),
      'updated_at'                            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('survey[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Survey';
  }

}
