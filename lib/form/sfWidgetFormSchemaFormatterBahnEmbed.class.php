<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id$
 */
class sfWidgetFormSchemaFormatterBahnEmbed extends sfWidgetFormSchemaFormatter
{
  protected
  $rowFormat       = "<div class=\"clearfix\">\n  \n%error%\n</div>\n",
  $errorRowFormat  = "<li>\n%errors%</li>\n",
  $helpFormat      = '<div class="\help\">%help%</div>',
  $decoratorFormat = "%content%";


  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
    var_dump($field);
    die();
    return strtr($this->getRowFormat(), array(
      '%label%'         => $label,
      '%field%'         => $field,
      '%error%'         => $this->formatErrorsForRow($errors),
      '%help%'          => $this->formatHelp($help),
      '%hidden_fields%' => null === $hiddenFields ? '%hidden_fields%' : $hiddenFields,
    ));
  }

  public function generateLabel($name, $attributes = array())
  {
    return  '';
  }
}
