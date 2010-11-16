<?php

/**
 * User filter form base class.
 *
 * @package    bahn
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'anrede'       => new sfWidgetFormChoice(array('choices' => array('' => '', 'Herr' => 'Herr', 'Frau' => 'Frau'))),
      'vorname'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nachname'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'strasse'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'plz'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'wohnort'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'codes_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Codes'), 'add_empty' => true)),
      'standorte_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Standorte'), 'add_empty' => true)),
      'abgemeldet'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'anrede'       => new sfValidatorChoice(array('required' => false, 'choices' => array('Herr' => 'Herr', 'Frau' => 'Frau'))),
      'vorname'      => new sfValidatorPass(array('required' => false)),
      'nachname'     => new sfValidatorPass(array('required' => false)),
      'email'        => new sfValidatorPass(array('required' => false)),
      'strasse'      => new sfValidatorPass(array('required' => false)),
      'plz'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'wohnort'      => new sfValidatorPass(array('required' => false)),
      'codes_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Codes'), 'column' => 'id')),
      'standorte_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Standorte'), 'column' => 'id')),
      'abgemeldet'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'anrede'       => 'Enum',
      'vorname'      => 'Text',
      'nachname'     => 'Text',
      'email'        => 'Text',
      'strasse'      => 'Text',
      'plz'          => 'Number',
      'wohnort'      => 'Text',
      'codes_id'     => 'ForeignKey',
      'standorte_id' => 'ForeignKey',
      'abgemeldet'   => 'Boolean',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
    );
  }
}
