<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form class="dankeUmfrage" action="<?php echo url_for('gewinnspiel/danke'.(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

  <fieldset>
  <?php if (isset($user) && is_object($user) && $user->getAnrede()=='Herr'): ?>
  Lieber Gewinnspielteilnehmer,
  <?php else: ?>
  Liebe Gewinnspielteilnehmerin,
  <?php endif;?>
  <br/><br/>
  vielen Dank für Deine Teilnahme an unserem „Wohin-Du-willst“-Gewinnspiel.
  <br/><br/>
  Wir drücken Dir die Daumen, dass Du eines von 11 iPads oder 111 Quer-durchs-Land-Tickets gewinnst.
  Gleich erhältst Du per E-Mail Deine Teilnahmebestätigung am Gewinnspiel sowie Deinen eCoupon-Code im Wert von 6 €, den Du bis 30.04. für den Online-Kauf eines Quer-durchs-Land-Tickets einsetzen kannst.
  <br/><br/>
  Wir würden uns freuen, wenn Du uns nachfolgend noch ein paar kurze Fragen beantworten könntest. Du hilfst uns damit, unser Angebot und unseren Service weiter zu verbessern.
  <br/><br/>
  Das Ausfüllen des Fragebogens ist freiwillig. Deine Angaben werden nicht personenbezogen erfasst und zur Beantwortung der 5 bis 6 Fragen benötigst Du nur ca. 5 Minuten.
  <br/><br/>
  Die anonymisierte Auswertung erfolgt ausschließlich zu Marktforschungszwecken und selbstverständlich unter Einhaltung der gesetzlichen Vorschriften des Datenschutzes und der Datenschutzgrundsätze der Deutschen Bahn.
  <br/><br/>
  Für Deine Zeit und Mühe bedanken wir uns schon jetzt recht herzlich,
  <br/><br/>
  Dein bahn.de-Team
  <br/><br/>
  „Hier geht´s zur Umfrage“ :
  </fieldset>

    <?php echo $form->renderHiddenFields(false) ?>

      <?php echo $form->renderGlobalErrors() ?>
      <fieldset>
        <?php echo $form;?>
      </fieldset>
      <fieldset>
        <div class="button-inside">
          <!-- Submit -->
          <span class="button-border right">
            <button type="submit" name="startbutton" class="highlight" value="1" title="Jetzt teilnehmen">
              <span>Umfrage abschicken</span>
            </button>
          </span>
        </div>
      </fieldset>
      <fieldset>
        Vielen Dank für Deine Teilnahme an unserer Umfrage!
        Wir wünschen Dir einen schönen Tag und nochmals viel Glück bei unserem Gewinnspiel!
      </fieldset>
</form>
