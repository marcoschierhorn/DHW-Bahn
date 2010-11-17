<?php

/**
 * Survey form.
 *
 * @package    bahn
 * @subpackage form
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
class UserSurveyForm extends BaseUserForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['id'],
      $this['anrede'],
      $this['vorname'],
      $this['nachname'],
      $this['email'],
      $this['strasse'],
      $this['plz'],
      $this['wohnort'],
      $this['codes_id'],
      $this['standorte_id'],
      $this['abgemeldet'],
      $this['survey_id']
    );

    $this->widgetSchema->setNameFormat('user_survey[%s]');

    $this->setWidgets(array(
      'survey_anlaesse_list'                         => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'SurveyAnlaesse')),
      'survey_angebot_verkehrsmittel12_list'         => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittel12')),
      'survey_angebot_verkehrsmittel_allgemein_list' => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittelAllgemein')),
    ));

    $this->setValidators(array(
      'survey_anlaesse_list'                         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAnlaesse', 'required' => false)),
      'survey_angebot_verkehrsmittel12_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittel12', 'required' => false)),
      'survey_angebot_verkehrsmittel_allgemein_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittelAllgemein', 'required' => false)),
    ));

    $this->getWidgetSchema()->setLabels(array(
    	'angebotbekannt' => 'War Dir das Quer-durchs-Land-Ticket bereits vor der Aktion bekannt und wenn ja, wie vertraut bist Du mit diesem Angebot?',
    	'survey_anlaesse_list' => 'Zu welchen der folgenden Anlässe käme die Nutzung des Quer-durchs-Land-Tickets für Dich generell in Betracht?',
    	'vergleichbarereise' => 'Du hast eingangs angegeben, dass Du das Quer-durchs-Land-Ticket bereits genutzt hast.Wirst Du das Quer-durchs-Land-Ticket in Zukunft für eine vergleichbare Reise wieder nutzen?',
    	'survey_angebot_verkehrsmittel12_list' => 'Welche der folgenden Verkehrsmittel hast Du in den letzten 12 Monaten bei Deinen Reisen genutzt?<br/>Mehrfachantworten sind möglich',
    	'survey_angebot_verkehrsmittel_allgemein_list' => 'Und welche dieser Verkehrsmittel kommen für Dich überhaupt bei Deinen Reisen in Frage?<br/>Mehrfachantworten sind möglich',
    ));

    $this->widgetSchema->setFormFormatterName('Bahn');

    $newSurvey = new Survey();
    $newSurvey->setUser($this->getObject());
    $form = new SurveyForm($newSurvey);
    $this->embedForm('', $form);

  }
}
