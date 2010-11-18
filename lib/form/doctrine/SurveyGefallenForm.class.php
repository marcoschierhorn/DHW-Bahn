<?php

/**
 * SurveyGefallen form.
 *
 * @package    bahn
 * @subpackage form
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
class SurveyGefallenForm extends BaseSurveyGefallenForm
{
  public function configure()
  {
    unset(
      $this['id'],
      $this['user_id']
    );
    $this->setWidgets(array(
      'preislich'     => new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(5 => null, 4 => null, 3 => null, 2 => null, 1 => null, 98 => null)), array('required' => false)),
      'spontan'       => new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(5 => null, 4 => null, 3 => null, 2 => null, 1 => null, 98 => null)), array('required' => false)),
      'gutes_angebot' => new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(5 => null, 4 => null, 3 => null, 2 => null, 1 => null, 98 => null)), array('required' => false)),
      'freunden'      => new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(5 => null, 4 => null, 3 => null, 2 => null, 1 => null, 98 => null)), array('required' => false)),
      'entfernung'    => new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(5 => null, 4 => null, 3 => null, 2 => null, 1 => null, 98 => null)), array('required' => false)),
      'junge'         => new sfWidgetFormChoice(array('expanded' => true, 'choices' => array(5 => null, 4 => null, 3 => null, 2 => null, 1 => null, 98 => null)), array('required' => false)),
    ));

    $this->widgetSchema->setFormFormatterName('BahnEmbed');


  }
}
