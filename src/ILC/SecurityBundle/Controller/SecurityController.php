<?php
namespace ILC\SecurityBundle\Controller;

use ILC\DataBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use ILC\SecurityBundle\Form\LoginTForm;

class SecurityController extends BaseController
{

	/**
	 *
	 * @param Request $request
	 *
	 * @return RedirectResponse|Response
	 */
	public function loginAction(Request $request)
	{
		if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
			return $this->redirect($this->generateUrl('fo_home'));
		}

		$session = $this->getSession();
		if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
			$request->attributes->remove(Security::AUTHENTICATION_ERROR);
			$msg = $this->translate($error->getMessage());
			$this->addFlash('err', $msg);
		} elseif ($session->has(Security::AUTHENTICATION_ERROR)) {
			$error = $session->get(Security::AUTHENTICATION_ERROR);
			$session->remove(Security::AUTHENTICATION_ERROR);
			$msg = $this->translate($error->getMessage());
			$this->addFlash('err', $msg);
		}

		$lastUsername = $session->get('_security.last_username');
		$referer = $this->getReferer();

		$loginForm = $this->createForm(LoginTForm::class);

		$loginForm->get('username')->setData($lastUsername);
		$loginForm->get('target_path')->setData($referer);
		// $loginForm->get('remember_me')->setData(true);

		$this->addTwigVar('LoginForm', $loginForm->createView());

		return $this->render('ILCSecurityBundle:Security:login.html.twig', $this->getTwigVars());
	}
}
