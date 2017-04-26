<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sessioninscription
 * @ORM\Table(name="SessionInscription")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\SessioninscriptionRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_sessioninscription")
 */
class Sessioninscription
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="si_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var datetime $dtcrea @ORM\Column(name="si_dtcrea", type="datetime", nullable=false)
	 */
	private $dtcrea;

	/**
	 *
	 * @var boolean $convocation @ORM\Column(name="si_convocation", type="boolean", nullable=false)
	 */
	private $convocation;

	/**
	 *
	 * @var Stagiaire @ORM\ManyToOne(targetEntity="Stagiaire", inversedBy="sessionincriptions")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="s_id", referencedColumnName="s_id")
	 *      })
	 */
	private $stagiaire;

	/**
	 *
	 * @var Sessionformation @ORM\ManyToOne(targetEntity="Sessionformation", inversedBy="sessionincriptions")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="sf_id", referencedColumnName="sf_id")
	 *      })
	 */
	private $session;

	public function __construct()
	{
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
	 * Set convocation
	 *
	 * @param boolean $convocation
	 */
	public function setConvocation($convocation)
	{
		$this->convocation = $convocation;
	}

	/**
	 * Get convocation
	 *
	 * @return boolean
	 */
	public function getConvocation()
	{
		return $this->convocation;
	}

	/**
	 * Set stagiaire
	 *
	 * @param ILC\DataBundle\Entity\Stagiaire $stagiaire
	 */
	public function setStagiaire(\ILC\DataBundle\Entity\Stagiaire $stagiaire)
	{
		$this->stagiaire = $stagiaire;
	}

	/**
	 * Get stagiaire
	 *
	 * @return ILC\DataBundle\Entity\Stagiaire
	 */
	public function getStagiaire()
	{
		return $this->stagiaire;
	}

	/**
	 * Set session
	 *
	 * @param ILC\DataBundle\Entity\Sessionformation $session
	 */
	public function setSession(\ILC\DataBundle\Entity\Sessionformation $session)
	{
		$this->session = $session;
	}

	/**
	 * Get session
	 *
	 * @return ILC\DataBundle\Entity\Sessionformation
	 */
	public function getSession()
	{
		return $this->session;
	}
}
