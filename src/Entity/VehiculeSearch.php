<?php
namespace App\Entity;

/**
* 
*/
class VehiculeSearch
{
	
	/**
	 * @var int|null
	 */
	private $ville;

	/**
	 * @var int|null
	 */
	private $typeVehicule;

	/**
	 * @var \DateTime|null
	 */
	private $start;

	/**
	 * @var \DateTime|null
	 */
	private $end;

    /**
     * @return int|null
     */
    public function getVille():?int
    {
    	return $this->ville;
    }

	/**
	 * @param int|null 
	 * @return VehiculeSearch
	 */
	public function setVille(?int $ville): VehiculeSearch
	{	
		$this->ville = $ville;
		return $this;

	}

	/**
     * @return int|null
     */
    public function getTypeVehicule():?int
    {
    	return $this->typeVehicule;
    }

	/**
	 * @param int|null 
	 * @return VehiculeSearch
	 */
	public function setTypeVehicule(?int $typeVehicule): VehiculeSearch
	{	
		$this->typeVehicule = $typeVehicule;
		return $this;

	}

	/**
     * @return \DateTime|null
     */
    public function getStart()
    {
    	return $this->start;
    }

	/**
	 * @param \DateTime|null 
	 * @return VehiculeSearch
	 */
	public function setStart(?\DateTimeInterface $start): VehiculeSearch
	{	
		$this->start = $start;
		return $this;

	}

	/**
     * @return \DateTime|null
     */
    public function getEnd()
    {
    	return $this->end;
    }

	/**
	 * @param \DateTime|null 
	 * @return VehiculeSearch
	 */
	public function setEnd(?\DateTimeInterface $end): VehiculeSearch
	{	
		$this->end = $end;
		return $this;

	}
}