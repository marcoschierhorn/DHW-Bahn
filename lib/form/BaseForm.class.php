<?php

/**
 * Base project form.
 *
 * @package    bahn
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseForm extends sfFormSymfony
{
  public function setup()
  {
    $this->widgetSchema->setFormFormatterName('Bahn');
  }

  public static function listenToValidationError($event)
  {
    foreach ($event['error'] as $key => $error)
    {
      self::getEventDispatcher()->notify(new sfEvent(
        $event->getSubject(),
        'application.log',
        array (
          'priority' => sfLogger::NOTICE,
          sprintf('Validation Error: %s: %s', $key, (string) $error)
        )
      ));
    }
  }

  public static function listenToPostConfigure($event)
  {
    $form            = $event->getSubject();
    $widgetSchema    = $form->getWidgetSchema();
    $validatorSchema = $form->getValidatorSchema();

    $fields = $form->getFormFieldSchema()->getWidget()->getFields();
    foreach ($fields as $key => $object)
    {
      $label = $form->getFormFieldSchema()->offsetGet($key)->renderLabelName();

      if (isset($validatorSchema[$key]) and $validatorSchema[$key]->getOption('required') == true)
      {
        $title  = $key . '_field_is_required';
        $label  = '<span class="form_field_required">'.$label.'</span>';
        $label .= '<sup>*</sup>';
      }
      $widgetSchema->setLabel($key, $label);
    }
  }

  protected function getI18N()
  {
    return sfContext::getInstance()->getI18N();

  }

  protected function __($string, $args = array(), $catalogue = 'messages')
  {
    return $this->getI18N()->__($string, $args, $catalogue);

  }
}
