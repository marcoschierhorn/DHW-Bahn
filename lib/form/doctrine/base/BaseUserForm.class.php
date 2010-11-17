<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    bahn
 * @subpackage form
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                           => new sfWidgetFormInputHidden(),
      'anrede'                                       => new sfWidgetFormChoice(array('choices' => array('Herr' => 'Herr', 'Frau' => 'Frau'))),
      'vorname'                                      => new sfWidgetFormInputText(),
      'nachname'                                     => new sfWidgetFormInputText(),
      'email'                                        => new sfWidgetFormInputText(),
      'strasse'                                      => new sfWidgetFormInputText(),
      'plz'                                          => new sfWidgetFormInputText(),
      'wohnort'                                      => new sfWidgetFormInputText(),
      'codes_id'                                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Codes'), 'add_empty' => true)),
      'standorte_id'                                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Standorte'), 'add_empty' => true)),
      'abgemeldet'                                   => new sfWidgetFormInputCheckbox(),
      'survey_id'                                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Survey'), 'add_empty' => true)),
      'created_at'                                   => new sfWidgetFormDateTime(),
      'updated_at'                                   => new sfWidgetFormDateTime(),
      'survey_anlaesse_list'                         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAnlaesse')),
      'survey_angebot_verkehrsmittel12_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittel12')),
      'survey_angebot_verkehrsmittel_allgemein_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittelAllgemein')),
    ));

    $this->setValidators(array(
      'id'                                           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'anrede'                                       => new sfValidatorChoice(array('choices' => array(0 => 'Herr', 1 => 'Frau'))),
      'vorname'                                      => new sfValidatorString(array('max_length' => 255)),
      'nachname'                                     => new sfValidatorString(array('max_length' => 255)),
      'email'                                        => new sfValidatorEmail(array('max_length' => 255)),
      'strasse'                                      => new sfValidatorString(array('max_length' => 255)),
      'plz'                                          => new sfValidatorInteger(),
      'wohnort'                                      => new sfValidatorString(array('max_length' => 255)),
      'codes_id'                                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Codes'), 'required' => false)),
      'standorte_id'                                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Standorte'), 'required' => false)),
      'abgemeldet'                                   => new sfValidatorBoolean(array('required' => false)),
      'survey_id'                                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Survey'), 'required' => false)),
      'created_at'                                   => new sfValidatorDateTime(),
      'updated_at'                                   => new sfValidatorDateTime(),
      'survey_anlaesse_list'                         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAnlaesse', 'required' => false)),
      'survey_angebot_verkehrsmittel12_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittel12', 'required' => false)),
      'survey_angebot_verkehrsmittel_allgemein_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittelAllgemein', 'required' => false)),
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

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['survey_anlaesse_list']))
    {
      $this->setDefault('survey_anlaesse_list', $this->object->SurveyAnlaesse->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['survey_angebot_verkehrsmittel12_list']))
    {
      $this->setDefault('survey_angebot_verkehrsmittel12_list', $this->object->SurveyAngebotVerkehrsmittel12->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['survey_angebot_verkehrsmittel_allgemein_list']))
    {
      $this->setDefault('survey_angebot_verkehrsmittel_allgemein_list', $this->object->SurveyAngebotVerkehrsmittelAllgemein->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSurveyAnlaesseList($con);
    $this->saveSurveyAngebotVerkehrsmittel12List($con);
    $this->saveSurveyAngebotVerkehrsmittelAllgemeinList($con);

    parent::doSave($con);
  }

  public function saveSurveyAnlaesseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['survey_anlaesse_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SurveyAnlaesse->getPrimaryKeys();
    $values = $this->getValue('survey_anlaesse_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SurveyAnlaesse', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SurveyAnlaesse', array_values($link));
    }
  }

  public function saveSurveyAngebotVerkehrsmittel12List($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['survey_angebot_verkehrsmittel12_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SurveyAngebotVerkehrsmittel12->getPrimaryKeys();
    $values = $this->getValue('survey_angebot_verkehrsmittel12_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SurveyAngebotVerkehrsmittel12', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SurveyAngebotVerkehrsmittel12', array_values($link));
    }
  }

  public function saveSurveyAngebotVerkehrsmittelAllgemeinList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['survey_angebot_verkehrsmittel_allgemein_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SurveyAngebotVerkehrsmittelAllgemein->getPrimaryKeys();
    $values = $this->getValue('survey_angebot_verkehrsmittel_allgemein_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SurveyAngebotVerkehrsmittelAllgemein', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SurveyAngebotVerkehrsmittelAllgemein', array_values($link));
    }
  }

}
