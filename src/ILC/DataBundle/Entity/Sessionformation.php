<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sessionformation
 * @ORM\Table(name="SessionFormation")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\SessionformationRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_sessionformation")
 * @UniqueEntity(fields="code", message="sessionformation.code.unique")
 */
class Sessionformation
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="sf_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var text $code @Assert\NotNull
	 *      @ORM\Column(name="sf_code", type="text", nullable=false)
	 */
	private $code;

	/**
	 *
	 * @var text $intitule @Assert\NotNull
	 *      @ORM\Column(name="sf_intitule", type="text", nullable=false)
	 */
	private $intitule;

	/**
	 *
	 * @var date $datedebut @Assert\NotNull
	 *      @ORM\Column(name="sf_datedebut", type="date", nullable=false)
	 */
	private $datedebut;

	/**
	 *
	 * @var time $heuredebut @Assert\NotNull
	 *      @ORM\Column(name="sf_heuredebut", type="time", nullable=false)
	 */
	private $heuredebut;

	/**
	 *
	 * @var date $datefin @Assert\NotNull
	 *      @ORM\Column(name="sf_datefin", type="date", nullable=false)
	 */
	private $datefin;

	/**
	 *
	 * @var time $heurefin @Assert\NotNull
	 *      @ORM\Column(name="sf_heurefin", type="time", nullable=false)
	 */
	private $heurefin;

	/**
	 *
	 * @var text $lieu @Assert\NotNull
	 *      @ORM\Column(name="sf_lieu", type="text", nullable=false)
	 */
	private $lieu;

	/**
	 *
	 * @var text $numcontactcentre @Assert\NotNull
	 *      @ORM\Column(name="sf_numcontactcentre", type="text", nullable=false)
	 */
	private $numcontactcentre;

	/**
	 *
	 * @var text $cnditionsreport @Assert\NotNull
	 *      @ORM\Column(name="sf_conditionsreport", type="text", nullable=false)
	 */
	private $conditionsreport;

	/**
	 *
	 * @var text $dateinfo @Assert\NotNull
	 *      @ORM\Column(name="sf_dateinfo", type="text", nullable=false)
	 */
	private $dateinfo;

	/**
	 *
	 * @var text $otherinfo @Assert\NotNull
	 *      @ORM\Column(name="sf_otherinfo", type="text", nullable=false)
	 */
	private $otherinfo;

	/**
	 *
	 * @var integer $maxparticipants @Assert\NotNull
	 *      @Assert\Type(type="integer")
	 *      @Assert\GreaterThanOrEqual(value=1)
	 *      @ORM\Column(name="sf_maxparticipants", type="integer", nullable=false)
	 */
	private $maxparticipants;

	/**
	 *
	 * @var boolean $sfVerouillage @Assert\NotNull
	 *      @ORM\Column(name="sf_verouillage", type="boolean", nullable=false)
	 */
	private $verouillage;

	/**
	 *
	 * @var Moduleformation @ORM\ManyToOne(targetEntity="Moduleformation", inversedBy="sessions")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="mf_id", referencedColumnName="mf_id")
	 *      })
	 */
	private $moduleformation;

	/**
	 *
	 * @var datetime $dtcrea @ORM\Column(name="sf_dtcrea", type="datetime", nullable=false)
	 */
	private $dtcrea;

	/**
	 *
	 * @var ArrayCollection $stagiaires @ORM\ManyToMany(targetEntity="Stagiaire", inversedBy="sessions")
	 *      @ORM\JoinTable(
	 *      name="SessionInscription",
	 *      joinColumns={@ORM\JoinColumn(name="sf_id", referencedColumnName="sf_id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="s_id", referencedColumnName="s_id")}
	 *      )
	 */
	private $stagiaires;

	/**
	 *
	 * @var \Doctrine\Common\Collections\ArrayCollection $sessionincriptions @ORM\OneToMany(targetEntity="Sessioninscription", mappedBy="session")
	 */
	private $sessionincriptions;

	public function __construct()
	{
		$this->dtcrea = new \DateTime();
		$this->verouillage = false;
		$this->stagiaires = new \Doctrine\Common\Collections\ArrayCollection();
		$this->sessionincriptions = new \Doctrine\Common\Collections\ArrayCollection();
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
	 * Set code
	 *
	 * @param text $code
	 */
	public function setCode($code)
	{
		$this->code = $code;
	}

	/**
	 * Get code
	 *
	 * @return text
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Set intitule
	 *
	 * @param text $intitule
	 */
	public function setIntitule($intitule)
	{
		$this->intitule = $intitule;
	}

	/**
	 * Get intitule
	 *
	 * @return text
	 */
	public function getIntitule()
	{
		return $this->intitule;
	}

	/**
	 * Set datedebut
	 *
	 * @param date $datedebut
	 */
	public function setDatedebut($datedebut)
	{
		$this->datedebut = $datedebut;
	}

	/**
	 * Get datedebut
	 *
	 * @return date
	 */
	public function getDatedebut()
	{
		return $this->datedebut;
	}

	/**
	 * Set heuredebut
	 *
	 * @param time $heuredebut
	 */
	public function setHeuredebut($heuredebut)
	{
		$this->heuredebut = $heuredebut;
	}

	/**
	 * Get heuredebut
	 *
	 * @return time
	 */
	public function getHeuredebut()
	{
		return $this->heuredebut;
	}

	/**
	 * Set datefin
	 *
	 * @param date $datefin
	 */
	public function setDatefin($datefin)
	{
		$this->datefin = $datefin;
	}

	/**
	 * Get datefin
	 *
	 * @return date
	 */
	public function getDatefin()
	{
		return $this->datefin;
	}

	/**
	 * Set heurefin
	 *
	 * @param time $heurefin
	 */
	public function setHeurefin($heurefin)
	{
		$this->heurefin = $heurefin;
	}

	/**
	 * Get heurefin
	 *
	 * @return time
	 */
	public function getHeurefin()
	{
		return $this->heurefin;
	}

	/**
	 * Set lieu
	 *
	 * @param text $lieu
	 */
	public function setLieu($lieu)
	{
		$this->lieu = $lieu;
	}

	/**
	 * Get lieu
	 *
	 * @return text
	 */
	public function getLieu()
	{
		return $this->lieu;
	}

	/**
	 * Set numcontactcentre
	 *
	 * @param text $numcontactcentre
	 */
	public function setNumcontactcentre($numcontactcentre)
	{
		$this->numcontactcentre = $numcontactcentre;
	}

	/**
	 * Get numcontactcentre
	 *
	 * @return text
	 */
	public function getNumcontactcentre()
	{
		return $this->numcontactcentre;
	}

	/**
	 * Set conditionsreport
	 *
	 * @param text $conditionsreport
	 */
	public function setConditionsreport($conditionsreport)
	{
		$this->conditionsreport = $conditionsreport;
	}

	/**
	 * Get conditionsreport
	 *
	 * @return text
	 */
	public function getConditionsreport()
	{
		return $this->conditionsreport;
	}

	/**
	 * Set dateinfo
	 *
	 * @param text $dateinfo
	 */
	public function setDateinfo($dateinfo)
	{
		$this->dateinfo = $dateinfo;
	}

	/**
	 * Get dateinfo
	 *
	 * @return text
	 */
	public function getDateinfo()
	{
		return $this->dateinfo;
	}

	/**
	 * Set otherinfo
	 *
	 * @param text $otherinfo
	 */
	public function setOtherinfo($otherinfo)
	{
		$this->otherinfo = $otherinfo;
	}

	/**
	 * Get otherinfo
	 *
	 * @return text
	 */
	public function getOtherinfo()
	{
		return $this->otherinfo;
	}

	/**
	 * Set maxparticipants
	 *
	 * @param integer $maxparticipants
	 */
	public function setMaxparticipants($maxparticipants)
	{
		$this->maxparticipants = $maxparticipants;
	}

	/**
	 * Get maxparticipants
	 *
	 * @return integer
	 */
	public function getMaxparticipants()
	{
		return $this->maxparticipants;
	}

	/**
	 * Set verouillage
	 *
	 * @param boolean $verouillage
	 */
	public function setVerouillage($verouillage)
	{
		$this->verouillage = $verouillage;
	}

	/**
	 * Get verouillage
	 *
	 * @return boolean
	 */
	public function getVerouillage()
	{
		return $this->verouillage;
	}

	/**
	 * Set moduleformation
	 *
	 * @param ILC\DataBundle\Entity\Moduleformation $moduleformation
	 */
	public function setModuleformation(\ILC\DataBundle\Entity\Moduleformation $moduleformation)
	{
		$this->moduleformation = $moduleformation;
	}

	/**
	 * Get moduleformation
	 *
	 * @return ILC\DataBundle\Entity\Moduleformation
	 */
	public function getModuleformation()
	{
		return $this->moduleformation;
	}

	/**
	 * Add stagiaires
	 *
	 * @param ILC\DataBundle\Entity\Stagiaire $stagiaires
	 */
	public function addStagiaire(\ILC\DataBundle\Entity\Stagiaire $stagiaire)
	{
		if (!$this->stagiaires->contains($stagiaire))
			$this->stagiaires->add($stagiaire);
	}

	/**
	 * Get stagiaires
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getStagiaires()
	{
		return $this->stagiaires;
	}

	public function removeStagiaire(\ILC\DataBundle\Entity\Stagiaire $stagiaire)
	{
		return $this->stagiaires->removeElement($stagiaire);
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
