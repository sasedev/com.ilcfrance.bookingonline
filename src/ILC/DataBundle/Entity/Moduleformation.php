<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Moduleformation
 * @ORM\Table(name="ModuleFormation")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\ModuleformationRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_moduleformation")
 * @UniqueEntity(fields="code", message="moduleformation.code.unique")
 */
class Moduleformation
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="mf_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var text $code @Assert\NotNull
	 *      @ORM\Column(name="mf_code", type="text", nullable=false)
	 */
	private $code;

	/**
	 *
	 * @var text $intitule @Assert\NotNull
	 *      @ORM\Column(name="mf_intitule", type="text", nullable=false)
	 */
	private $intitule;

	/**
	 *
	 * @var text $description @Assert\NotNull
	 *      @ORM\Column(name="mf_description", type="text", nullable=false)
	 */
	private $description;

	/**
	 *
	 * @var Groupmodule @ORM\ManyToOne(targetEntity="Groupmodule", inversedBy="modules")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="gm_id", referencedColumnName="gm_id")
	 *      })
	 */
	private $groupmodule;

	/**
	 *
	 * @var \Doctrine\Common\Collections\ArrayCollection $sessions @ORM\OneToMany(targetEntity="Sessionformation", mappedBy="moduleformation")
	 *      @ORM\OrderBy({"datedebut" = "ASC"})
	 */
	private $sessions;

	/**
	 *
	 * @var ArrayCollection $stagiaires @ORM\ManyToMany(targetEntity="Stagiaire", inversedBy="modules")
	 *      @ORM\JoinTable(
	 *      name="ModulePreinscription",
	 *      joinColumns={@ORM\JoinColumn(name="mf_id", referencedColumnName="mf_id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="s_id", referencedColumnName="s_id")}
	 *      )
	 */
	private $stagiaires;

	public function __construct()
	{
		$this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
		$this->stagiaires = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function __toString()
	{
		return $this->getCode() . ' ' . $this->getIntitule();
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
	 * Set description
	 *
	 * @param text $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * Get description
	 *
	 * @return text
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set groupmodule
	 *
	 * @param ILC\DataBundle\Entity\Groupmodule $groupmodule
	 */
	public function setGroupmodule(\ILC\DataBundle\Entity\Groupmodule $groupmodule)
	{
		$this->groupmodule = $groupmodule;
	}

	/**
	 * Get groupmodule
	 *
	 * @return ILC\DataBundle\Entity\Groupmodule
	 */
	public function getGroupmodule()
	{
		return $this->groupmodule;
	}

	/**
	 * Add sessions
	 *
	 * @param ILC\DataBundle\Entity\Sessionformation $sessions
	 */
	public function addSessionformation(\ILC\DataBundle\Entity\Sessionformation $sessions)
	{
		$this->sessions[] = $sessions;
	}

	/**
	 * Get sessions
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getSessions()
	{
		return $this->sessions;
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
}
