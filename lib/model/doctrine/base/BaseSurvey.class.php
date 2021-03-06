<?php

/**
 * BaseSurvey
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $survey_angebot_bekannt_id
 * @property integer $survey_angebot_vergleichbare_reise_id
 * @property SurveyAngebotBekannt $SurveyAngebotBekannt
 * @property SurveyAngebotVergleichbareReise $SurveyAngebotVergleichbareReise
 * @property User $User
 * 
 * @method integer                         getId()                                    Returns the current record's "id" value
 * @method integer                         getSurveyAngebotBekanntId()                Returns the current record's "survey_angebot_bekannt_id" value
 * @method integer                         getSurveyAngebotVergleichbareReiseId()     Returns the current record's "survey_angebot_vergleichbare_reise_id" value
 * @method SurveyAngebotBekannt            getSurveyAngebotBekannt()                  Returns the current record's "SurveyAngebotBekannt" value
 * @method SurveyAngebotVergleichbareReise getSurveyAngebotVergleichbareReise()       Returns the current record's "SurveyAngebotVergleichbareReise" value
 * @method User                            getUser()                                  Returns the current record's "User" value
 * @method Survey                          setId()                                    Sets the current record's "id" value
 * @method Survey                          setSurveyAngebotBekanntId()                Sets the current record's "survey_angebot_bekannt_id" value
 * @method Survey                          setSurveyAngebotVergleichbareReiseId()     Sets the current record's "survey_angebot_vergleichbare_reise_id" value
 * @method Survey                          setSurveyAngebotBekannt()                  Sets the current record's "SurveyAngebotBekannt" value
 * @method Survey                          setSurveyAngebotVergleichbareReise()       Sets the current record's "SurveyAngebotVergleichbareReise" value
 * @method Survey                          setUser()                                  Sets the current record's "User" value
 * 
 * @package    bahn
 * @subpackage model
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
abstract class BaseSurvey extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('survey');
        $this->hasColumn('id', 'integer', 6, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 6,
             ));
        $this->hasColumn('survey_angebot_bekannt_id', 'integer', 2, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => 2,
             ));
        $this->hasColumn('survey_angebot_vergleichbare_reise_id', 'integer', 2, array(
             'type' => 'integer',
             'notnull' => false,
             'length' => 2,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('SurveyAngebotBekannt', array(
             'local' => 'survey_angebot_bekannt_id',
             'foreign' => 'id'));

        $this->hasOne('SurveyAngebotVergleichbareReise', array(
             'local' => 'survey_angebot_vergleichbare_reise_id',
             'foreign' => 'id'));

        $this->hasOne('User', array(
             'local' => 'id',
             'foreign' => 'survey_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}