<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Administrator
 * @ORM\Table(name="Administrator")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\AdministratorRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_administrator")
 * @UniqueEntity(fields="username", message="administrator.username.unique")
 */
class Administrator implements UserInterface
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="a_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var text $name @Assert\NotNull
	 *      @ORM\Column(name="a_name", type="text", nullable=false)
	 */
	private $name;

	/**
	 *
	 * @var text $username @Assert\NotNull(message = "admin.username.empty")
	 *      @Assert\Length(min=3, minMessage="admin.username.minlength")
	 *      @Assert\Regex(pattern="/^([a-z]+)([a-z0-9]+)$/", message = "user.username.regex")
	 *      @ORM\Column(name="a_login", type="text", nullable=false, unique=true)
	 */
	private $username;

	/**
	 *
	 * @var text $password @Assert\NotNull
	 *      @ORM\Column(name="a_passwd", type="text", nullable=false)
	 */
	private $password;

	/**
	 *
	 * @var text $aEmail @Assert\NotNull
	 *      @Assert\Email
	 *      @ORM\Column(name="a_email", type="text", nullable=false)
	 */
	private $email;

	/**
	 *
	 * @var datetime $dtcrea @ORM\Column(name="a_dtcrea", type="datetime", nullable=false)
	 */
	private $dtcrea;

	/**
	 * @ORM\Column(name="a_salt", type="text", columnDefinition="TEXT NULL", nullable=true)
	 * @Assert\NotNull
	 *
	 * @var text $salt
	 */
	private $salt;

	public function __construct()
	{
		$this->setSalt(md5(time()));
		$this->dtcrea = new \DateTime();
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
	 * Set name
	 *
	 * @param text $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Get name
	 *
	 * @return text
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set login
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
	 * @param text $passwd
	 */
	public function setPassword($passwd)
	{
		$encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
		$this->password = $encoder->encodePassword($passwd, $this->getSalt());
	}

	/**
	 * Get password
	 * (non-PHPdoc)
	 *
	 * @see Symfony\Component\Security\Core\User.UserInterface::getPassword()
	 *
	 * @return text
	 */
	public function getPassword()
	{
		return $this->password;
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
			"ADMIN"
		);
	}
}
