<?php
namespace ILC\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Groupmodule
 * @ORM\Table(name="GroupModule")
 * @ORM\Entity(repositoryClass="ILC\DataBundle\Repository\GroupmoduleRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE", region="region_groupmodule")
 */
class Groupmodule
{

	/**
	 *
	 * @var integer $id @ORM\Column(name="gm_id", type="integer", nullable=false)
	 *      @ORM\Id
	 *      @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 *
	 * @var text $name @Assert\NotNull
	 *      @ORM\Column(name="gm_name", type="text", nullable=false)
	 */
	private $name;

	/**
	 *
	 * @var \Doctrine\Common\Collections\ArrayCollection $modules @ORM\OneToMany(targetEntity="Moduleformation", mappedBy="groupmodule")
	 *      @ORM\OrderBy({"code" = "ASC"})
	 */
	private $modules;

	public function __construct()
	{
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
	 * Add modules
	 *
	 * @param ILC\DataBundle\Entity\Moduleformation $modules
	 */
	public function addModuleformation(\ILC\DataBundle\Entity\Moduleformation $modules)
	{
		$this->modules[] = $modules;
	}

	/**
	 * Get modules
	 *
	 * @return Doctrine\Common\Collections\Collection
	 */
	public function getModules()
	{
		return $this->modules;
	}
}
