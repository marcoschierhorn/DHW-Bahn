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
  public $formPartial = 'umfrageNormal';

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
      $this['survey_id'],
      $this['user_id'],
      $this['survey_anlaesse_list'],
      $this['survey_angebot_verkehrsmittel12_list'],
      $this['survey_angebot_verkehrsmittel_allgemein_list']
    );

    switch ((int) $this->getOption('step', 1))
    {
      case 1:

        $this->embedSurveyForm();
        unset($this['survey_angebot_vergleichbare_reise_id']);

      break;

      case 2:
       $this->formPartial = 'umfrageMatrix';
       $this->embedSurveyGefallenForm();

      break;

      case 3:

        $this->setAnlaesseBekannt();

      break;

      case 4:

        $this->embedSurveyForm();
        unset($this['survey_angebot_bekannt_id']);

      break;

      case 5:

        $this->setVerkehrsmittel12();

      break;

      case 6:

        $this->setVerkehrsmittelAllgemein();

      break;
    }

    $this->getWidgetSchema()->setLabels(array(
    	'angebotbekannt' => 'War Dir das Quer-durchs-Land-Ticket bereits vor der Aktion bekannt und wenn ja, wie vertraut bist Du mit diesem Angebot?',
    	'survey_anlaesse_list' => 'Zu welchen der folgenden Anlässe käme die Nutzung des Quer-durchs-Land-Tickets für Dich generell in Betracht?<br/>(Mehrfachantworten sind möglich)',
    	'vergleichbarereise' => 'Du hast eingangs angegeben, dass Du das Quer-durchs-Land-Ticket bereits genutzt hast. Wirst Du das Quer-durchs-Land-Ticket in Zukunft für eine vergleichbare Reise wieder nutzen?',
    	'survey_angebot_verkehrsmittel12_list' => 'Welche der folgenden Verkehrsmittel hast Du in den letzten 12 Monaten bei Deinen Reisen genutzt?<br/>(Mehrfachantworten sind möglich)',
    	'survey_angebot_verkehrsmittel_allgemein_list' => 'Und welche dieser Verkehrsmittel kommen für Dich überhaupt bei Deinen Reisen in Frage?<br/>(Mehrfachantworten sind möglich)',
    ));

    $this->widgetSchema->setFormFormatterName('Bahn');
    $this->widgetSchema->setNameFormat('user_survey[%s]');

  }

  protected function setAnlaesseBekannt()
  {
    $this->setWidgets(array(
      'survey_anlaesse_list'                         => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'SurveyAnlaesse'),
      array('onchange' => 'clearFormAndSetCheck(jQuery(this))')),
    ));

    $this->setValidators(array(
      'survey_anlaesse_list'                         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAnlaesse', 'required' => true)),
    ));

    $this->setOption('clearFormValues', array(9, 10));
  }

  protected function setVerkehrsmittel12()
  {
    $this->setWidgets(array(
      'survey_angebot_verkehrsmittel12_list'         => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittel12'),
      array('onchange' => 'clearFormAndSetCheck(jQuery(this))')),
    ));

    $this->setValidators(array(
      'survey_angebot_verkehrsmittel12_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittel12', 'required' => true)),
    ));

    $this->setOption('clearFormValues', array(7, 8));
  }

  protected function setVerkehrsmittelAllgemein()
  {
    $this->setWidgets(array(
      'survey_angebot_verkehrsmittel_allgemein_list' => new sfWidgetFormDoctrineChoice(array('expanded' => true, 'multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittelAllgemein'),
      array('onchange' => 'clearFormAndSetCheck(jQuery(this))')),
    ));

    $this->setValidators(array(
      'survey_angebot_verkehrsmittel_allgemein_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SurveyAngebotVerkehrsmittelAllgemein', 'required' => true))
    ));

    $this->setOption('clearFormValues', array(7, 8));
  }

  public function save($con = null)
  {

    $user   = Doctrine_Core::getTable('User')->find(array($this->object->getId()));
    $survey = Doctrine_Core::getTable('Survey')->find(array($user->getSurveyId()));

    $values = $this->getValues();

    if ($survey)
    {
      $user->setSurveyId($survey->getId());
      $values['survey_id'] = $survey->getId();
    }

    if ((int) $this->getOption('step', 1)==1 || (int) $this->getOption('step', 1)==4)
    {

      if (!is_null($survey))
      {

        if (!$survey instanceof Survey)
        {
          $survey = new Survey();
        }

        $survey->fromArray($values);
        $survey->save();

          $this->object->setSurveyId($survey->getId());
          $this->object->save();
        }

  	}
  	else if ((int) $this->getOption('step', 1)==2)
  	{
  	  // update user info
      if (!is_null($surveyGefallen = $this->getObject()->getSurveyGefallen()))
      {

        if ( $surveyGefallen->isNew() )
        {
          $values['user_id'] = $this->object->getId();
        }
        $surveyGefallen->fromArray($values);
        $surveyGefallen->save();
      }
  	}
  	else
  	{
  	  parent::save($con);
  	}

  	return $this->object;
  }

  protected function embedSurveyForm()
  {
    $newSurvey = new Survey();
    $form = new SurveyForm($newSurvey);
    $this->getObject()->setSurvey($newSurvey);
    $this->mergeForm($form);
  }

  protected function embedSurveyGefallenForm()
  {
    $newSurveySurveyGefallen = new SurveyGefallen();
    $newSurveySurveyGefallen->setUser($this->getObject());
    $formSurveyGefallen = new SurveyGefallenForm($newSurveySurveyGefallen);
    $this->mergeForm($formSurveyGefallen);
  }
}
