<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php
// in the head of your template, call the helper
use_helper('sfCryptoCaptcha');

//the helper functions
captcha_image();
captcha_reload_button();
?>


<form action="<?php echo url_for('gewinnspiel/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['anrede']->renderLabel() ?></th>
        <td>
          <?php echo $form['anrede']->renderError() ?>
          <?php echo $form['anrede'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['vorname']->renderLabel() ?></th>
        <td>
          <?php echo $form['vorname']->renderError() ?>
          <?php echo $form['vorname'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['nachname']->renderLabel() ?></th>
        <td>
          <?php echo $form['nachname']->renderError() ?>
          <?php echo $form['nachname'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['email']->renderLabel() ?></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['strasse']->renderLabel() ?></th>
        <td>
          <?php echo $form['strasse']->renderError() ?>
          <?php echo $form['strasse'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['plz']->renderLabel() ?></th>
        <td>
          <?php echo $form['plz']->renderError() ?>
          <?php echo $form['plz'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['wohnort']->renderLabel() ?></th>
        <td>
          <?php echo $form['wohnort']->renderError() ?>
          <?php echo $form['wohnort'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['standorte_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['standorte_id']->renderError() ?>
          <?php echo $form['standorte_id'] ?>
        </td>
      </tr>
      <tr>
      <th><?php echo $form['captcha']->renderLabel(); ?></th>
      <td>
        <?php echo $form['captcha']->renderError(); ?>
        <?php echo captcha_image(); echo captcha_reload_button(); ?><br/>
        <?php echo $form['captcha']->render(); ?>
      </td>
    </tr>
    </tbody>
  </table>
</form>
