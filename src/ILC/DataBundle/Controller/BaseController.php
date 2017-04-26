<?php
namespace ILC\DataBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\DelegatingEngine;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class BaseController extends Controller
{

	/**
	 *
	 * @var array $twigVars
	 */
	private $twigVars = array();

	/**
	 *
	 * @var array $htmlHeadMetas
	 */
	private $htmlHeadMetas = array();

	/**
	 *
	 * @var array $htmlHeadLinks
	 */
	private $htmlHeadLinks = array();

	/**
	 *
	 * @var array $htmlHeadScripts
	 */
	private $htmlHeadScripts = array();

	/**
	 *
	 * @var string $htmlHeadPageTitle
	 */
	private $htmlHeadPageTitle;

	/**
	 *
	 * @var array $htmlBodyScripts
	 */
	private $htmlBodyScripts = array();

	/**
	 * Get Monolog Logger
	 *
	 * @return Logger
	 */
	public function getLogger()
	{
		return $this->get('logger');
	}

	/**
	 * Get Swiftmail Mailer
	 *
	 * @return Swift_Mailer
	 */
	public function getMailer()
	{
		return $this->get('mailer');
	}

	/**
	 * Get symfony router
	 *
	 * @return Router
	 */
	public function getRouter()
	{
		return $this->get('router');
	}

	/**
	 * Get Request
	 *
	 * @return Request
	 *
	 * @deprecated
	 *
	 */
	public function getRequest()
	{
		return $this->get('request_stack')->getCurrentRequest();
	}

	/**
	 * Get Session
	 *
	 * @return Session
	 */
	public function getSession()
	{
		return $this->get('session');
	}

	/**
	 * Get the translator service
	 *
	 * @return Translator
	 */
	public function getTranslator()
	{
		return $this->get('translator');
	}

	/**
	 * Get security context
	 *
	 * @return TokenStorage
	 */
	public function getSecurityTokenStorage()
	{
		return $this->get('security.token_storage');
	}

	/**
	 * Get security context
	 *
	 * @return AuthorizationChecker
	 */
	public function getSecurityAuthorizationChecker()
	{
		return $this->get('security.authorization_checker');
	}

	/**
	 * Get Form Factory
	 *
	 * @return FormFactory
	 */
	public function getFormFactory()
	{
		return $this->get('form.factory');
	}

	/**
	 * Get validator service
	 *
	 * @return RecursiveValidator
	 */
	public function getValidator()
	{
		return $this->get('validator');
	}

	/**
	 * Get templating service
	 *
	 * @return DelegatingEngine
	 */
	public function getTemplating()
	{
		return $this->get('templating');
	}

	/**
	 * Get referer
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	public function getReferer(Request $request = null)
	{
		if (null == $request) {
			$request = $this->getRequest();
		}
		return $request->headers->get('referer');
	}

	/**
	 * Get Doctrine Entity Manager
	 *
	 * @return ObjectManager
	 */
	public function getEntityManager($name = null)
	{
		$entityManager = $this->getDoctrine()->getManager($name);
		if (!$entityManager->isOpen()) {
			$entityManager = $entityManager->create($entityManager->getConnection(), $entityManager->getConfiguration());
		}

		return $entityManager;
	}

	/**
	 * Translates the given message.
	 *
	 * @param string $id
	 * @param array $parameters
	 * @param string $domain
	 * @param string $locale
	 *
	 * @return string
	 */
	public function translate($id, $parameters = array(), $domain = 'messages', $locale = null)
	{
		return $this->getTranslator()->trans($id, $parameters, $domain, $locale);
	}

	/**
	 * Create a Form
	 *
	 * @param string|int $name
	 *        	The name of the form
	 * @param string|FormInterface $type
	 * @param string $data
	 * @param array $options
	 *
	 * @return FormInterface
	 */
	public function createNamedForm($name, $type, $data = null, $options = array())
	{
		return $this->container->get('form.factory')->createNamed($name, $type, $data, $options);
	}

	/**
	 * Creates and returns a form builder instance.
	 *
	 * @param string|int $name
	 *        	The name of the form
	 * @param mixed $data
	 *        	The initial data for the form
	 * @param array $options
	 *        	Options for the form
	 * @return FormBuilder
	 */
	protected function createNamedFormBuilder($name, $data = null, array $options = array())
	{
		return $this->container->get('form.factory')->createNamedBuilder($name, FormType::class, $data, $options);
	}

	/**
	 * Send a message by mail
	 * The return value is the number of recipients who were accepted for
	 * delivery.
	 *
	 * @param Swift_Mime_Message $message
	 *
	 * @return integer
	 */
	public function sendmail($message)
	{
		return $this->getMailer()->send($message);
	}

	/**
	 * Check if a string starts with a prefix
	 *
	 * @param string $string
	 * @param string $prefix
	 *
	 * @return boolean
	 */
	public function startswith($string, $prefix)
	{
		return \strpos($string, $prefix) === 0;
	}

	/**
	 * Check if a string ends with a suffix
	 *
	 * @param string $string
	 * @param string $suffix
	 *
	 * @return boolean
	 */
	public function endswith($string, $suffix)
	{
		$strlen = \strlen($string);
		$testlen = \strlen($suffix);
		if ($testlen > $strlen) {
			return false;
		}

		return \substr_compare($string, $suffix, -$testlen) === 0;
	}

	/**
	 *
	 * @param string $email
	 *
	 * @return boolean
	 */
	public function check_email_address($email)
	{
		$email = strtolower($email);
		$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
		// Run the preg_match() function on regex against the email address
		if (preg_match($regex, $email)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Normalize a string
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public function normalize($string)
	{
		$table = array(
			'Š' => 'S',
			'š' => 's',
			'Ð' => 'Dj',
			'Ž' => 'Z',
			'ž' => 'z',
			'C' => 'C',
			'c' => 'c',
			'C' => 'C',
			'c' => 'c',
			'À' => 'A',
			'Á' => 'A',
			'Â' => 'A',
			'Ã' => 'A',
			'Ä' => 'A',
			'Å' => 'A',
			'Æ' => 'A',
			'Ç' => 'C',
			'È' => 'E',
			'É' => 'E',
			'Ê' => 'E',
			'Ë' => 'E',
			'Ì' => 'I',
			'Í' => 'I',
			'Î' => 'I',
			'Ï' => 'I',
			'Ñ' => 'N',
			'Ò' => 'O',
			'Ó' => 'O',
			'Ô' => 'O',
			'Õ' => 'O',
			'Ö' => 'O',
			'Ø' => 'O',
			'Ù' => 'U',
			'Ú' => 'U',
			'Û' => 'U',
			'Ü' => 'U',
			'Ý' => 'Y',
			'Þ' => 'B',
			'ß' => 'Ss',
			'à' => 'a',
			'á' => 'a',
			'â' => 'a',
			'ã' => 'a',
			'ä' => 'a',
			'å' => 'a',
			'æ' => 'a',
			'ç' => 'c',
			'è' => 'e',
			'é' => 'e',
			'ê' => 'e',
			'ë' => 'e',
			'ì' => 'i',
			'í' => 'i',
			'î' => 'i',
			'ï' => 'i',
			'ð' => 'o',
			'ñ' => 'n',
			'ò' => 'o',
			'ó' => 'o',
			'ô' => 'o',
			'õ' => 'o',
			'ö' => 'o',
			'ø' => 'o',
			'ù' => 'u',
			'ú' => 'u',
			'û' => 'u',
			'ý' => 'y',
			'ý' => 'y',
			'þ' => 'b',
			'ÿ' => 'y',
			'R' => 'R',
			'r' => 'r'
		);

		return \strtr($string, $table);
	}

	/**
	 * Get $twigVars
	 *
	 * @return array
	 */
	public function getTwigVars()
	{
		return $this->twigVars;
	}

	/**
	 * Set $twigVars;
	 *
	 * @param array $twigVars
	 *
	 * @return BaseController $this
	 */
	public function setTwigVars($twigVars)
	{
		$this->twigVars = $twigVars;

		return $this;
	}

	/**
	 * Add $twigVar;
	 *
	 * @param string $name
	 *
	 * @param mixed $value
	 *
	 * @return BaseController $this
	 */
	public function addTwigVar($name, $value = null)
	{
		$this->twigVars[$name] = $value;

		return $this;
	}

	/**
	 * Get $htmlHeadMetas
	 *
	 * @return array
	 */
	public function getHtmlHeadMetas()
	{
		return $this->htmlHeadMetas;
	}

	/**
	 * Set $htmlHeadMetas
	 *
	 * @param array $htmlHeadMetas
	 *
	 * @return BaseController $this
	 */
	public function setHtmlHeadMetas($htmlHeadMetas)
	{
		$this->htmlHeadMetas = $htmlHeadMetas;

		$this->twigVars['htmlHeadMetas'] = $this->htmlHeadMetas;

		return $this;
	}

	/**
	 * Add $htmlHeadMeta;
	 *
	 * @param mixed $htmlHeadMeta
	 *
	 * @return BaseController $this
	 */
	public function addHtmlHeadMeta($htmlHeadMeta)
	{
		$this->htmlHeadMetas[] = $htmlHeadMeta;

		$this->twigVars['htmlHeadMetas'] = $this->htmlHeadMetas;

		return $this;
	}

	/**
	 * Get $htmlHeadLinks
	 *
	 * @return array
	 */
	public function getHtmlHeadLinks()
	{
		return $this->htmlHeadLinks;
	}

	/**
	 * Set $htmlHeadLinks
	 *
	 * @param array $htmlHeadLinks
	 *
	 * @return BaseController $this
	 */
	public function setHtmlHeadLinks($htmlHeadLinks)
	{
		$this->htmlHeadLinks = $htmlHeadLinks;

		$this->twigVars['htmlHeadLinks'] = $this->htmlHeadLinks;

		return $this;
	}

	/**
	 * Add $htmlHeadLink;
	 *
	 * @param mixed $htmlHeadLink
	 *
	 * @return BaseController $this
	 */
	public function addHtmlHeadLink($htmlHeadLink)
	{
		$this->htmlHeadLinks[] = $htmlHeadLink;

		$this->twigVars['htmlHeadLinks'] = $this->htmlHeadLinks;

		return $this;
	}

	/**
	 * Get $htmlHeadScripts
	 *
	 * @return array
	 */
	public function getHeadScripts()
	{
		return $this->htmlHeadScripts;
	}

	/**
	 * Set $htmlHeadScripts
	 *
	 * @param array $htmlHeadScripts
	 *
	 * @return BaseController $this
	 */
	public function setHeadScripts($htmlHeadScripts)
	{
		$this->htmlHeadScripts = $htmlHeadScripts;

		$this->twigVars['htmlHeadScripts'] = $this->htmlHeadScripts;

		return $this;
	}

	/**
	 * Add $htmlHeadScript;
	 *
	 * @param mixed $htmlHeadScript
	 *
	 * @return BaseController $this
	 */
	public function addHeadScript($htmlHeadScript)
	{
		$this->htmlHeadScripts[] = $htmlHeadScript;

		$this->twigVars['htmlHeadScripts'] = $this->htmlHeadScripts;

		return $this;
	}

	/**
	 *
	 * @return string
	 */
	public function getHtmlHeadPageTitle()
	{
		return $this->htmlHeadPageTitle;
	}

	/**
	 *
	 * @param string $htmlHeadPageTitle
	 */
	public function setHtmlHeadPageTitle($htmlHeadPageTitle)
	{
		$this->htmlHeadPageTitle = $htmlHeadPageTitle;

		$this->twigVars['htmlHeadPageTitle'] = $this->htmlHeadPageTitle;

		return $this;
	}

	/**
	 * Get $htmlBodyScripts
	 *
	 * @return array
	 */
	public function getHtmlBodyScripts()
	{
		return $this->htmlBodyScripts;
	}

	/**
	 * Set $htmlBodyScripts
	 *
	 * @param array $htmlBodyScripts
	 *
	 * @return BaseController $this
	 */
	public function setHtmlBodyScripts($htmlBodyScripts)
	{
		$this->htmlBodyScripts = $htmlBodyScripts;

		$this->twigVars['htmlBodyScripts'] = $this->htmlBodyScripts;

		return $this;
	}

	/**
	 * Add $htmlBodyScripts;
	 *
	 * @param mixed $htmlBodyScripts
	 *
	 * @return BaseController $this
	 */
	public function addHtmlBodyScript($htmlBodyScripts)
	{
		$this->htmlBodyScripts[] = $htmlBodyScripts;

		$this->twigVars['htmlBodyScripts'] = $this->htmlBodyScripts;

		return $this;
	}
}
