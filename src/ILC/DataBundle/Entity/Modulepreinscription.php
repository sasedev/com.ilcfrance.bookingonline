<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modulepreinscription
 * @ORM\Table(name="ModulePreinscription")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\ModulepreinscriptionRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_modulepreinscription")
 */
class Modulepreinscription
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="mpi_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var datetime $dtcrea @ORM\Column(name="mpi_dtcrea", type="datetime", nullable=false)
	 */
	private $dtcrea;

	/**
	 *
	 * @var Stagiaire @ORM\ManyToOne(targetEntity="Stagiaire")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="s_id", referencedColumnName="s_id")
	 *      })
	 */
	private $stagiaire;

	/**
	 *
	 * @var Moduleformation @ORM\ManyToOne(targetEntity="Moduleformation")
	 *      @ORM\JoinColumns({
	 *      @ORM\JoinColumn(name="mf_id", referencedColumnName="mf_id")
	 *      })
	 */
	private $module;

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
	 * Set module
	 *
	 * @param ILC\DataBundle\Entity\Moduleformation $module
	 */
	public function setModule(\ILC\DataBundle\Entity\Moduleformation $module)
	{
		$this->module = $module;
	}

	/**
	 * Get module
	 *
	 * @return ILC\DataBundle\Entity\Moduleformation
	 */
	public function getModule()
	{
		return $this->module;
	}
}
