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

    <?php echo $form->renderHiddenFields(false) ?>

      <?php echo $form->renderGlobalErrors() ?>

      <fieldset>

        <?php echo $form['anrede']->renderRow() ?>
        <?php echo $form['vorname']->renderRow() ?>
        <?php echo $form['nachname']->renderRow() ?>
        <?php echo $form['email']->renderRow() ?>
        <?php echo $form['strasse']->renderRow() ?>
        <?php echo $form['plz']->renderRow() ?>
        <?php echo $form['wohnort']->renderRow() ?>
        <?php echo $form['standorte_id']->renderRow() ?>

     </fieldset>

      <fieldset>
        <div class="captcha">
          <?php echo captcha_image(); echo captcha_reload_button(); ?>
        </div>
        <?php echo $form['captcha']->renderRow(); ?>
      </fieldset>

      <fieldset>
        <label for="Pflichteingaben"><sup>*</sup><span class="form_field_required">Pflichteingaben</span></label><br style="clear: both;"/><br/>
        Hinweis: Das Gewinnspiel läuft bis 30. Januar 2011. Eine Barauszahlung der Gewinne ist nicht möglich. Der Rechtsweg ist ausgeschlossen. Mitarbeiter der Deutschen Bahn AG sowie deren Angehörige dürfen nicht teilnehmen. Die Gewinner werden unter allen Teilnehmern ausgelost. Die Gewinner werden per Post benachrichtigt. Das Versandrisiko wird von uns nicht übernommen. Ihre Daten werden ausschließlich für die Abwicklung des Gewinnspiels sowie für anonymisierte Marktforschungszwecke verwendet. Im Umgang mit Ihren persönlichen Daten werden selbstverständlich alle Vorgaben des <span class="texturl"><a target="_blank" href="http://www.bahn.de/p/view/home/info/schutz.shtml">Datenschutzes</a></span> beachtet.
      </fieldset>

      <fieldset>
        <div class="button-inside">
          <!-- Submit -->
          Ich bestätige die Richtigkeit meiner Angaben und erkenne die Teilnahmebedingungen an
          <span class="button-border right">
            <button type="submit" name="startbutton" class="highlight" value="1" title="Jetzt teilnehmen">
              <span>Jetzt teilnehmen</span>
            </button>
          </span>
        </div>
      </fieldset>

</form>
