<p>
  <?php if (isset($user) && is_object($user) && $user->getAnrede()=='Herr'): ?>
  Lieber Gewinnspielteilnehmer,
  <?php else: ?>
  Liebe Gewinnspielteilnehmerin,
  <?php endif;?>
  <br/><br/>
  vielen Dank für Deine Teilnahme an unserem „Wohin-Du-willst“-Gewinnspiel.
  <br/><br/>
  Wir drücken Dir die Daumen, dass Du eines von 11 iPads oder 111 Quer-durchs-Land-Tickets gewinnst.
  <br/><br/>
  Gleich erhältst Du per E-Mail Deine Teilnahmebestätigung am Gewinnspiel sowie Deinen persönlichen eCoupon-Code im Wert von 6 €, den Du bis 30.12.2011 für den Online-Kauf eines Quer-durchs-Land-Tickets einsetzen kannst.
  <br/><br/>
  Wir würden uns freuen, wenn Du uns nachfolgend noch ein paar kurze Fragen beantworten könntest. Du hilfst uns damit, unser Angebot und unseren Service weiter zu verbessern.
  <br/><br/>
  Das Ausfüllen des Fragebogens ist freiwillig. Deine Angaben werden nicht personenbezogen erfasst und zur Beantwortung der 5 bis 6 Fragen benötigst Du nur ca. 5 Minuten.
  <br/><br/>
  Die anonymisierte Auswertung erfolgt ausschließlich zu Marktforschungszwecken und selbstverständlich unter Einhaltung der gesetzlichen Vorschriften des Datenschutzes und der <span class="texturl"><a target="_blank" href="http://www.bahn.de/p/view/home/info/schutz.shtml">Datenschutzgrundsätze</a></span> der Deutschen Bahn.
  <br/><br/>
  Für Deine Zeit und Mühe bedanken wir uns schon jetzt recht herzlich,
  <br/><br/>
  Dein bahn.de-Team
  <br/><br/>
  <div class="button-inside">
    <!-- Submit -->
    <span class="button-border right">
      <button type="submit" name="startbutton" class="highlight" value="1" title="Hier geht's zur Umfrage" onclick="location.href='<?php echo url_for('gewinnspiel/umfrage?id='.$user->getId().'&step=1', true)?>'">
        <span>Hier geht's zur Umfrage</span>
      </button>
    </span>
  </div>
</p>
<?php /*?>
<form class="dankeUmfrage" action="<?php echo url_for('gewinnspiel/danke'.(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>

      <?php echo $form->renderHiddenFields(false) ?>
      <?php echo $form->renderGlobalErrors() ?>

      <fieldset>
        <?php echo $form['survey_angebot_bekannt_id']->renderRow();?>
        <div classs="clearfix">
          <label>2.   Wir würden gern wissen, wie gut Dir das Quer-durchs-Land-Ticket gefällt. Bitte gib zu jeder der folgenden Aussagen an, inwieweit diese Deiner Einschätzung nach auf das Angebot zutrifft, oder nicht. Du hast hierzu eine Skala von 5= 'trifft voll und ganz zu’ bis 1 = 'trifft überhaupt nicht zu' zur Verfügung. Mit den Werten dazwischen kannst Du Deine Beurteilung abstufen. Das Quer-durchs-Land-Ticket …</label>
        </div>

        <div class="clearfix matrix">
          <?php include_partial('matrixheader')?>
          <label>ist ein preislich attraktives Angebot</label><?php echo $form['preislich']->render();?>
        </div>
        <div class="clearfix matrix">
          <?php include_partial('matrixheader')?>
          <label>ist eine gute Alternative für spontane</label><?php echo $form['spontan']->render();?>
        </div>

        <div class="clearfix matrix">
          <?php include_partial('matrixheader')?>
          <label>ist insgesamt ein sehr gutes Angebot</label><?php echo $form['gutes_angebot']->render();?>
        </div>

        <div class="clearfix matrix">
          <?php include_partial('matrixheader')?>
          <label>ist das ideale Angebot für Reisen mit Freunden</label><?php echo $form['freunden']->render();?>
        </div>

        <div class="clearfix matrix">
          <?php include_partial('matrixheader')?>
          <label>ist besonders für weite Entfernungen geeignet</label><?php echo $form['entfernung']->render();?>
        </div>

        <div class="clearfix matrix">
          <?php include_partial('matrixheader')?>
          <label>ist ein tolles Angebot für junge Leute</label><?php echo $form['junge']->render();?>
        </div>

        <?php echo $form['survey_anlaesse_list']->renderRow();?>
        <div style="display: none;" id="vergleichbarereise">
          <?php echo $form['survey_angebot_vergleichbare_reise_id']->renderRow();?>
        </div>
        <?php echo $form['survey_angebot_verkehrsmittel12_list']->renderRow();?>
        <?php echo $form['survey_angebot_verkehrsmittel_allgemein_list']->renderRow();?>

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
*/ ?>
