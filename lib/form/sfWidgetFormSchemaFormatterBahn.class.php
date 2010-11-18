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
class sfWidgetFormSchemaFormatterBahn extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<div class=\"clearfix\">\n  %label%\n  %field%%help%%hidden_fields%\n%error%\n</div>\n",
    $errorRowFormat  = "<li>\n%errors%</li>\n",
    $helpFormat      = '<div class="\help\">%help%</div>',
    $decoratorFormat = "<fieldset>\n  %content%</fieldset>";
}
