<?php

/**
 * gewinnspiel actions.
 *
 * @package    bahn
 * @subpackage gewinnspiel
 * @author     Marco Schierhorn <marco.schierhorn@gmail.com>
 * @version    SVN: $Id$
 */
class gewinnspielActions extends sfActions
{
  public function preExecute()
  {
    header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
    $this->getResponse()->setHttpHeader('P3P', 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
  }

  public function executeIndex(sfWebRequest $request)
  {
    if (!$request->isMethod('post'))
    {
      session_destroy();
      session_start();
    }
    $this->form = new UserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new UserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('index');
  }

  public function executeDankeUmfrage(sfWebRequest $request)
  {

  }

  public function executeDanke(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($this->getUser()->getAttribute('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      // Get a random eCoupon Code and store it in the Users Table
      $q = Doctrine::getTable('Codes')
      ->createQuery('c')
      ->orderBy('RAND()')
      ->where('c.used != 1')
      ->limit(1);

      $code = $q->fetchOne();
      $user = $form->save();

      $user->setCodes($code);
      $user->save();

      $code->setUsed(true);
      $code->save();

      $this->sendCouponEmail($user);

      $this->getUser()->setAttribute('user_id', $user->getId());
      $this->getUser()->setAttribute('show4', false);
      $this->redirect('gewinnspiel/danke#dankeGewinnspiel');
    }
  }

  public function executeUmfrage(sfWebRequest $request)
  {
    $this->getUser()->setAttribute('lastStep', null);

    if (!$this->getUser()->hasAttribute('user_id') || (int) $this->getUser()->getAttribute('user_id') <= 0)
    {
      $this->redirect('gewinnspiel/index');
    }

    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($this->getUser()->getAttribute('user_id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));

    if ($this->getUser()->hasAttribute('lastStep'))
    {
      $addStep = 1;
      if ($this->getUser()->getAttribute('show4')==false && (int) $request->getParameter('step', 1) == 5)
      {
        $addStep = 2;
      }

      if ((int) $this->getUser()->getAttribute('lastStep') + $addStep < (int) $request->getParameter('step', 1))
      {
        $this->redirect('gewinnspiel/umfrage?step='.intval($this->getUser()->getAttribute('lastStep')));
      }
    }

    $this->nextStep = $request->getParameter('step', 1);

    $this->form = new UserSurveyForm($this->user, array('step' => $request->getParameter('step', 1)));

    $this->formPartial = $this->form->formPartial;

    $this->uncheckValues = $this->form->getOption('clearFormValues', array());

    $this->processUmfrageForm($request, $this->form, $this->oldForm, $this->user);
  }

  protected function processUmfrageForm(sfWebRequest $request, sfForm $form, $oldForm = null, User $user)
  {
    if ($form!=null && $request->isMethod('post'))
    {
      $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

      if ($form->isValid())
      {
        $form->save();
        $this->getUser()->setAttribute('lastStep', (int) $form->getOption('step'));

        if ((int) $form->getOption('step') == 1 && (int) $form->getValue('survey_angebot_bekannt_id')==4)
        {
          $this->getUser()->setAttribute('show4', true);
        }

        if (intval($form->getOption('step')+1)>6)
        {
          $this->getUser()->setAttribute('user_id', false);
          $this->redirect('gewinnspiel/dankeUmfrage?id='.$this->user->getId());
        }

        if (intval($form->getOption('step'))==3 && $this->getUser()->getAttribute('show4')==false)
        {
          $this->redirect('gewinnspiel/umfrage?step=5');
        }

        $this->redirect('gewinnspiel/umfrage?step='.intval($form->getOption('step')+1));
      }
    }
  }

  public function executeAbmelden(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine_Core::getTable('User')->find(array($request->getParameter('id'))), sprintf('Object user does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($this->user->getUserSecCode()==$request->getParameter('sec'));

    $this->user->setAbgemeldet(true);
    $this->user->save();
  }

  function sendCouponEmail(User $user)
  {
    $abmeldenUrl = $this->getController()->genUrl('gewinnspiel/abmelden?id='.$user->getId().'&sec='.$user->getUserSecCode(), true);

    $username   = $user->getFullName();
    $couponCode = $user->getCodes()->getName();

    if (sfConfig::get('sf_environment')=='dev')
      $recipientEmail = 'marco.schierhorn@gmail.com';
    else
      $recipientEmail = $user->getEmail();

    $message = $this->getMailer()->compose(
      array('wohin-du-willst@deutschebahn.com' => 'Quer-durchs-Land'),
      $user->getEmail(),
      'Teilnahmebestätigung und Rabatt-Coupon für ein Quer-durchs-Land-Ticket!',
      'wohin-du-willst@bahn.unispezial.de',
      <<<EOF
Hallo $username,

vielen Dank für Deine Teilnahme an unserem „Wohin-Du-willst“-Gewinnspiel.

Wir drücken Dir die Daumen, dass Du zu den glücklichen Gewinnern von einem der 11 iPads oder 111 Quer-durchs-Land-Tickets gehörst.

Für Dein Interesse am Quer-durchs-Land-Ticket bedanken wir uns außerdem mit einem persönlichen eCoupon*, mit dem Du 6 Euro Rabatt auf ein Quer-durchs-Land-Ticket bekommst.

Dein persönlicher eCoupon*: $couponCode

Also: Bis 31.04.2011 online ein Quer-durchs-Land-Ticket buchen, 6 Euro sparen, die Flatrate für ganz Deutschland testen und so weit, so oft und wohin Du willst fahren!

Mit besten Grüßen

Dein bahn.de-Team

* Der eCoupon ist vom 13.12.2010 bis 31.04.2011 gültig. Nur ein Coupon pro Ticket. Der Coupon gilt ausschließlich für den angegebenen Zeitraum. Umtausch, Erstattung und Barauszahlung sind grundsätzlich ausgeschlossen. Einlösung nur unter www.bahn.de bei Online-Buchung eines Quer-durchs-Land-Tickets zum Selbstausdrucken. Weitere Infos unter www.bahn.de/wohin-du-willst

Du hast diese E-Mail erhalten, weil Du an unserem „Wohin-Du-willst“-Gewinnspiel (www.bahn.de/wohin-du-willst) teilgenommen hast. Solltest Du Dich nicht selbst angemeldet haben oder Dich vom Gewinnspiel wieder abmelden wollen, klicke bitte hier $abmeldenUrl, um alle Deine Daten zu löschen.
EOF
    );
    $this->getMailer()->send($message);
  }
}
