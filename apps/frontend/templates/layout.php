<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <!--[if IE 7]>
    	<link rel="stylesheet" type="text/css" href="/css/ie7.css" />
  	<![endif]-->
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="content">
      <div class="sidebar-left">
        <div class="box">
          <div class="section clearfix">
            <div class="col first">
              <?php if ($sf_request->getParameter('action')=='index' || $sf_request->getParameter('action')=='create'):?>
                <h1>Mit dem Quer-durchs-Land-Ticket gewinnen!</h1>
              <?php elseif ($sf_request->getParameter('action')=='danke'):?>
              	<h1>Deine Eingaben wurden erfolgreich übertragen!</h1>
              <?php elseif ($sf_request->getParameter('action')=='abmelden'):?>
              	<h1>Abmeldung vom Quer-durchs-Land-Gewinnspiel</h1>
              <?php else: ?>
                <h1>Vielen Dank für deine Teilnahme an unserer Umfrage!</h1>
              <?php endif;?>
            </div>
          </div>
          <div class="section clearfix">
          <div class="col first">
              <img width="704" height="176" class="teaser-with-text" alt="Quer-durchs-Land-Ticket - Zug" src="/images/MDB83384-quer_durchs_land_ticket_4_1_704x176.jpg" />
          </div>
          </div>
          <?php echo $sf_content ?>
        </div>
      </div>
    </div>
  </body>
</html>
