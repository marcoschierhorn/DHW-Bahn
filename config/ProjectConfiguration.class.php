<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony-1.4/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfCryptoCaptchaPlugin');

    $this->getEventDispatcher()->connect(
            'form.validation_error',
            array('BaseForm', 'listenToValidationError')
    );

    $this->getEventDispatcher()->connect(
            'form.post_configure',
            array('BaseForm', 'listenToPostConfigure')
    );

  }
}
