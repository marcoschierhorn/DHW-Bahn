<?php

/**
 * BaseSurveyAngebotBekannt
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property Survey $SurveyAngebotBekanntModel
 * 
 * @method integer              getId()                        Returns the current record's "id" value
 * @method string               getName()                      Returns the current record's "name" value
 * @method Survey               getSurveyAngebotBekanntModel() Returns the current record's "SurveyAngebotBekanntModel" value
 * @method SurveyAngebotBekannt setId()                        Sets the current record's "id" value
 * @method SurveyAngebotBekannt setName()                      Sets the current record's "name" value
 * @method SurveyAngebotBekannt setSurveyAngebotBekanntModel() Sets the current record's "SurveyAngebotBekanntModel" value
 * 
 * @package    bahn
 * @subpackage model
 * @author     Marco Schierhorn
 * @version    SVN: $Id$
 */
abstract class BaseSurveyAngebotBekannt extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('survey_angebot_bekannt');
        $this->hasColumn('id', 'integer', 2, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 2,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Survey as SurveyAngebotBekanntModel', array(
             'local' => 'id',
             'foreign' => 'survey_angebot_bekannt_id'));
    }
}