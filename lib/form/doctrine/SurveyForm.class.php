<?php

/**
 * Survey form.
 *
 * @package    bahn
 * @subpackage form
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
class SurveyForm extends BaseSurveyForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['id']
    );

    $this->setWidgets(array(
      'survey_angebot_bekannt_id'             => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'model' => $this->getRelatedModelName('SurveyAngebotBekannt'), 'add_empty' => false)),
      'survey_angebot_vergleichbare_reise_id' => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'model' => $this->getRelatedModelName('SurveyAngebotVergleichbareReise'), 'add_empty' => false)),
    ));

    $this->getWidgetSchema()->setLabels(array(
    	'survey_angebot_bekannt_id' => 'War Dir das Quer-durchs-Land-Ticket bereits vor der Aktion bekannt und wenn ja, wie vertraut bist Du mit diesem Angebot?',
    	'survey_angebot_vergleichbare_reise_id' => 'Du hast eingangs angegeben, dass Du das Quer-durchs-Land-Ticket bereits genutzt hast.Wirst Du das Quer-durchs-Land-Ticket in Zukunft für eine vergleichbare Reise wieder nutzen?',
    ));

    $this->widgetSchema->setFormFormatterName('BahnEmbed');
  }
}
