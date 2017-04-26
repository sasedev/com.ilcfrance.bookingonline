<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Stagiaire
 * @ORM\Table(name="Stagiaire")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\StagiaireRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_stagiaire")
 * @UniqueEntity(fields="username", message="stagiaire.username.unique")
 */
class Stagiaire implements UserInterface
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="s_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var text $username @ORM\Column(name="s_code", type="text", nullable=false)
	 */
	private $username;

	/**
	 *
	 * @var text $password @ORM\Column(name="s_password", type="text", nullable=false)
	 */
	private $password;

	/**
	 *
	 * @var text $clearpassword @ORM\Column(name="s_clearpassword", type="text", nullable=false)
	 */
	private $clearpassword;

	/**
	 *
	 * @var text $email @ORM\Column(name="s_email", type="text", nullable=false)
	 */
	private $email;

	/**
	 *
	 * @var text $login @ORM\Column(name="s_nom", type="text", nullable=false)
	 */
	private $nom;

	/**
	 *
	 * @var text $prenom @ORM\Column(name="s_prenom", type="text", nullable=false)
	 */
	private $prenom;

	/**
	 *
	 * @var boolean $active @ORM\Column(name="s_active", type="boolean", nullable=false)
	 */
	private $active;

	/**
	 *
	 * @var boolean $infosent @ORM\Column(name="s_infosent", type="boolean", nullable=false)
	 */
	private $infosent;

	/**
	 *
	 * @var datetime $dtcrea @ORM\Column(name="s_dtajout", type="datetime", nullable=false)
	 */
	private $dtajout;

	/**
	 *
	 * @var datetime $dtcrea @ORM\Column(name="s_dtcrea", type="datetime", nullable=false)
	 */
	private $dtcrea;

	/**
	 *
	 * @var text $tel @ORM\Column(name="s_tel", type="text", nullable=true)
	 */
	private $tel;

	/**
	 *
	 * @var text $nomcontact @ORM\Column(name="s_nomcontact", type="text", nullable=true)
	 */
	private $nomcontact;

	/**
	 *
	 * @var text $emailcontact @ORM\Column(name="s_emailcontact", type="text", nullable=true)
	 */
	private $emailcontact;

	/**
	 *
	 * @var ArrayCollection $modules @ORM\ManyToMany(targetEntity="Moduleformation", mappedBy="stagiaires")
	 *      @ORM\JoinTable(
	 *      name="ModulePreinscription",
	 *      joinColumns={@ORM\JoinColumn(name="s_id", referencedColumnName="s_id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="mf_id", referencedColumnName="mf_id")}
	 *      )
	 */
	private $modules;

	/**
	 *
	 * @var ArrayCollection $modules @ORM\ManyToMany(targetEntity="Sessionformation", mappedBy="stagiaires")
	 *      @ORM\JoinTable(
	 *      name="SessionInscription",
	 *      joinColumns={@ORM\JoinColumn(name="s_id", referencedColumnName="s_id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="sf_id", referencedColumnName="sf_id")}
	 *      )
	 */
	private $sessions;

	/**
	 *
	 * @var \Doctrine\Common\Collections\ArrayCollection $sessionincriptions @ORM\OneToMany(targetEntity="Sessioninscription", mappedBy="stagiaire")
	 */
	private $sessionincriptions;

	/**
	 * @ORM\Column(name="s_salt", type="text", columnDefinition="TEXT NULL", nullable=true)
	 *
	 * @var text $salt
	 */
	private $salt;

	public function __construct()
	{
		$this->setSalt(md5(time()));
		$date = new \DateTime();
		$date->modify("+12 day");

		$this->dtajout = new \DateTime();

		$this->dtcrea = new \DateTime($date->format("Y-m-d H:i:s"));

		$this->generatePass(12);
		$this->setActive(true);
		$this->setInfosent(false);
		$this->modules = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set username
	 *
	 * @param text $login
	 */
	public function setUsername($login)
	{
		$this->username = $login;
	}

	/**
	 * Get username
	 * (non-PHPdoc)
	 *
	 * @see Symfony\Component\Security\Core\User.UserInterface::getUsername()
	 *
	 * @return text
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * Set password
	 *
	 * @param text $password
	 */
	public function setPassword($password)
	{
		$this->clearpassword = $password;
		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$this->password = $encoder->encodePassword($password, $this->getSalt());
		$this->modulesfomration = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get password
	 *
	 * @return text
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Get password
	 *
	 * @return text
	 */
	public function getClearpassword()
	{
		return $this->clearpassword;
	}

	/**
	 * Set nom
	 *
	 * @param text $login
	 */
	public function setNom($login)
	{
		$this->nom = $login;
	}

	/**
	 * Get nom
	 *
	 * @return text
	 */
	public function getNom()
	{
		return $this->nom;
	}

	/**
	 * Set prenom
	 *
	 * @param text $login
	 */
	public function setPrenom($login)
	{
		$this->prenom = $login;
	}

	/**
	 * Get prenom
	 *
	 * @return text
	 */
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	 * Set active
	 *
	 * @param boolean $active
	 */
	public function setActive($active)
	{
		$this->active = $active;
	}

	/**
	 * Get active
	 *
	 * @return boolean
	 */
	public function getActive()
	{
		return $this->active;
	}

	/**
	 * Set infosent
	 *
	 * @param boolean $infosent
	 */
	public function setInfosent($infosent)
	{
		$this->infosent = $infosent;
	}

	/**
	 * Get infosent
	 *
	 * @return boolean
	 */
	public function getInfosent()
	{
		return $this->infosent;
	}

	/**
	 * Set email
	 *
	 * @param text $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * Get email
	 *
	 * @return text
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set dtajout
	 *
	 * @param datetime $dtcrea
	 */
	public function setDtajout($dtajout)
	{
		$this->dtajout = $dtajout;
	}

	/**
	 * Get dtajout
	 *
	 * @return datetime
	 */
	public function getDtajout()
	{
		return $this->dtajout;
	}

	/**
	 * Set dtcrea
	 *
	 * @param datetime $dtcrea
	 */
	public function setDtcrea($dtcrea)
	{
		$this->dtcrea = $dtcrea;
	}

	/**
	 * Get dtcrea
	 *
	 * @return datetime
	 */
	public function getDtcrea()
	{
		return $this->dtcrea;
	}

	/**
	 * Set tel
	 *
	 * @param text $tel
	 */
	public function setTel($tel)
	{
		$this->tel = $tel;
	}

	/**
	 * Get tel
	 *
	 * @return text
	 */
	public function getTel()
	{
		return $this->tel;
	}

	/**
	 * Set nomcontact
	 *
	 * @param text $nomcontact
	 */
	public function setNomcontact($nomcontact)
	{
		$this->nomcontact = $nomcontact;
	}

	/**
	 * Get nomcontact
	 *
	 * @return text
	 */
	public function getNomcontact()
	{
		return $this->nomcontact;
	}

	/**
	 * Set emailcontact
	 *
	 * @param text $emailcontact
	 */
	public function setEmailcontact($emailcontact)
	{
		$this->emailcontact = $emailcontact;
	}

	/**
	 * Get emailcontact
	 *
	 * @return text
	 */
	public function getEmailcontact()
	{
		return $this->emailcontact;
	}

	/**
	 * Add modulesformation
	 *
	 * @param ILC\DataBundle\Entity\Moduleformation $modulesfomration
	 */
	public function addModule(\ILC\DataBundle\Entity\Moduleformation $module)
	{
		if (!$this->modules->contains($module)) {
			$this->modules->add($module);
		}
	}

	/**
	 * Get modulesfomration
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getModules()
	{
		return $this->modules;
	}

	/**
	 * Empty module list
	 */
	public function emptyModules()
	{
		$this->modules = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function removeModule(\ILC\DataBundle\Entity\Moduleformation $module)
	{
		return $this->modules->removeElement($module);
	}

	/**
	 * Add sessionsformation
	 *
	 * @param ILC\DataBundle\Entity\Sessionformation $modulesfomration
	 */
	public function addSession(\ILC\DataBundle\Entity\Sessionformation $session)
	{
		if (!$this->sessions->contains($session)) {
			$this->sessions->add($session);
		}
	}

	/**
	 * Get sessionsfomration
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getSessions()
	{
		return $this->sessions;
	}

	public function removeSession(\ILC\DataBundle\Entity\Sessionformation $session)
	{
		return $this->sessions->removeElement($session);
	}

	/**
	 * Get salt
	 * (non-PHPdoc)
	 *
	 * @see Symfony\Component\Security\Core\User.UserInterface::getSalt()
	 *
	 * @return text
	 */
	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * Set salt
	 *
	 * @param text $salt
	 */
	public function setSalt($salt)
	{
		$this->salt = $salt;
	}

	/**
	 * Erases the user credentials.
	 * (non-PHPdoc)
	 *
	 * @see Symfony\Component\Security\Core\User.UserInterface::eraseCredentials()
	 */
	public function eraseCredentials()
	{
	}

	/**
	 * Compares this user to another to determine if they are the same.
	 * (non-PHPdoc)
	 *
	 * @see Symfony\Component\Security\Core\User.UserInterface::equals()
	 *
	 * @param UserInterface $user
	 *        	The user
	 * @return boolean True if equal, false othwerwise.
	 */
	public function equals(UserInterface $user)
	{
		return md5($this->getUsername()) == md5($user->getUsername());
	}

	public function getRoles()
	{
		return array(
			"USER"
		);
	}

	private function generatePass($p_size)
	{
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array();
		$alphaLength = strlen($alphabet) - 1; // put the length -1 in cache
		for ($i = 0; $i < $p_size; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$this->setPassword(implode($pass));
	}

	/**
	 * Add sessions
	 *
	 * @param ILC\DataBundle\Entity\Sessionformation $sessions
	 */
	public function addSessionincriptions(\ILC\DataBundle\Entity\Sessioninscription $sessions)
	{
		$this->sessionincriptions[] = $sessions;
	}

	/**
	 * Get sessions
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getSessionincriptions()
	{
		return $this->sessionincriptions;
	}
}
