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
}