<?php
namespace ILC\FrontOfficeBundle\Controller;

use ILC\DataBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController
{

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function indexAction(Request $request)
	{
		$user = $this->getSecurityTokenStorage()->getToken()->getUser();

		// $em = $this->getEntityManager();
		$this->addTwigVar('pagetitle', 'Mes modules');
		$this->addTwigVar('user', $user);
		$this->addTwigVar('connected', true);
		return $this->render('ILCFrontOfficeBundle:Default:index.html.twig', $this->getTwigVars());
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function updtsesAction(Request $request)
	{
		$stagiaire = $this->getSecurityTokenStorage()->getToken()->getUser();

		$em = $this->getEntityManager();
		$datas = $request->request->all();
		$hassession = false;
		$sessions = array();
		foreach ($datas as $data) {
			if (strpos($data, 'mod') == 0) {
				$val = $data;
				$session = $em->getRepository('ILCDataBundle:Sessionformation')->findOneById($val);
				if (null != $session) {
					$hassession = true;
					$currmodule = $session->getModuleformation();
					$sessionislocked = false;
					// $samesession = false;
					$sessions[] = $session;
					if (count($session->getStagiaires()) >= $session->getMaxparticipants() || $session->getVerouillage()) {
						$sessionislocked = true;
					}
					if (!$sessionislocked) {
						$oldsess = null;
						foreach ($stagiaire->getSessions() as $ses) {
							if ($ses->getModuleformation()->getId() == $currmodule->getId()) {
								$oldsess = $ses;
							}
						}
						if (null != $oldsess) {
							if ($oldsess->getId() != $session->getId()) {
								$oldsess->removeStagiaire($stagiaire);
								$session->addStagiaire($stagiaire);
								$em->persist($oldsess);
								$em->persist($session);
								$em->flush();
							}
						} else {
							$session->addStagiaire($stagiaire);
							$em->persist($session);
							$em->flush();
						}
					}
				}
			}
		}

		if ($hassession) {
			$mvars = array();
			$mvars['stagiaire'] = $stagiaire;
			$mvars['sessions'] = $sessions;
			$message = \Swift_Message::newInstance()->setFrom('formation@ilcfrance.com', 'ILCFrance')->setTo($stagiaire->getEmail(), $stagiaire->getNom() . ' ' . $stagiaire->getPrenom())->setSubject('Confirmation d\'inscription')->setBody($this->renderView('ILCFrontOfficeBundle:Mail:params.html.twig', $mvars), 'text/html');
			$this->sendmail($message);
			$this->addFlash('info', "Un email de confirmation d'inscription vous a été envoyé");
		}

		return $this->redirect($this->generateUrl('fo_home'));
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function preambuleAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$this->addTwigVar('connected', true);
		} else {
			$this->addTwigVar('connected', false);
		}
		$this->addTwigVar('pagetitle', 'Préambule');
		return $this->render('ILCFrontOfficeBundle:Default:preambule.html.twig', $this->getTwigVars());
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function reservationAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$this->addTwigVar('connected', true);
		} else {
			$this->addTwigVar('connected', false);
		}
		$this->addTwigVar('pagetitle', 'Procédure de réservation');
		return $this->render('ILCFrontOfficeBundle:Default:reservation.html.twig', $this->getTwigVars());
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function conditionsAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$this->addTwigVar('connected', true);
		} else {
			$this->addTwigVar('connected', false);
		}
		$this->addTwigVar('pagetitle', 'Conditions d\'ouverture d\'un stage');
		return $this->render('ILCFrontOfficeBundle:Default:conditions.html.twig', $this->getTwigVars());
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function glossaireAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$this->addTwigVar('connected', true);
		} else {
			$this->addTwigVar('connected', false);
		}
		$this->addTwigVar('pagetitle', 'Glossaire');
		return $this->render('ILCFrontOfficeBundle:Default:glossaire.html.twig', $this->getTwigVars());
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function faqAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$this->addTwigVar('connected', true);
		} else {
			$this->addTwigVar('connected', false);
		}
		$this->addTwigVar('pagetitle', 'FAQ');
		return $this->render('ILCFrontOfficeBundle:Default:faq.html.twig', $this->getTwigVars());
	}

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function annuaireAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			$this->addTwigVar('connected', true);
		} else {
			$this->addTwigVar('connected', false);
		}
		$this->addTwigVar('pagetitle', 'Annuaire');
		return $this->render('ILCFrontOfficeBundle:Default:annuaire.html.twig', $this->getTwigVars());
	}
}
