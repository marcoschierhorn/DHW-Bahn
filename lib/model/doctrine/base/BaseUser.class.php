<?php

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $anrede
 * @property string $vorname
 * @property string $nachname
 * @property string $email
 * @property string $strasse
 * @property integer $plz
 * @property string $wohnort
 * @property integer $codes_id
 * @property integer $standorte_id
 * @property boolean $abgemeldet
 * @property Codes $Codes
 * @property Standorte $Standorte
 * 
 * @method integer   getId()           Returns the current record's "id" value
 * @method enum      getAnrede()       Returns the current record's "anrede" value
 * @method string    getVorname()      Returns the current record's "vorname" value
 * @method string    getNachname()     Returns the current record's "nachname" value
 * @method string    getEmail()        Returns the current record's "email" value
 * @method string    getStrasse()      Returns the current record's "strasse" value
 * @method integer   getPlz()          Returns the current record's "plz" value
 * @method string    getWohnort()      Returns the current record's "wohnort" value
 * @method integer   getCodesId()      Returns the current record's "codes_id" value
 * @method integer   getStandorteId()  Returns the current record's "standorte_id" value
 * @method boolean   getAbgemeldet()   Returns the current record's "abgemeldet" value
 * @method Codes     getCodes()        Returns the current record's "Codes" value
 * @method Standorte getStandorte()    Returns the current record's "Standorte" value
 * @method User      setId()           Sets the current record's "id" value
 * @method User      setAnrede()       Sets the current record's "anrede" value
 * @method User      setVorname()      Sets the current record's "vorname" value
 * @method User      setNachname()     Sets the current record's "nachname" value
 * @method User      setEmail()        Sets the current record's "email" value
 * @method User      setStrasse()      Sets the current record's "strasse" value
 * @method User      setPlz()          Sets the current record's "plz" value
 * @method User      setWohnort()      Sets the current record's "wohnort" value
 * @method User      setCodesId()      Sets the current record's "codes_id" value
 * @method User      setStandorteId()  Sets the current record's "standorte_id" value
 * @method User      setAbgemeldet()   Sets the current record's "abgemeldet" value
 * @method User      setCodes()        Sets the current record's "Codes" value
 * @method User      setStandorte()    Sets the current record's "Standorte" value
 * 
 * @package    bahn
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id$
 */
abstract class BaseUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', 6, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 6,
             ));
        $this->hasColumn('anrede', 'enum', null, array(
             'type' => 'enum',
             'notnull' => true,
             'values' => 
             array(
              0 => 'Herr',
              1 => 'Frau',
             ),
             ));
        $this->hasColumn('vorname', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('nachname', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'email' => true,
             'length' => 255,
             ));
        $this->hasColumn('strasse', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('plz', 'integer', 5, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 5,
             ));
        $this->hasColumn('wohnort', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('codes_id', 'integer', 6, array(
             'type' => 'integer',
             'length' => 6,
             ));
        $this->hasColumn('standorte_id', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             ));
        $this->hasColumn('abgemeldet', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('email_index', array(
             'fields' => 
             array(
              'email' => 
              array(
              'sorting' => 'ASC',
              'length' => 10,
              ),
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Codes', array(
             'local' => 'codes_id',
             'foreign' => 'id'));

        $this->hasOne('Standorte', array(
             'local' => 'standorte_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}