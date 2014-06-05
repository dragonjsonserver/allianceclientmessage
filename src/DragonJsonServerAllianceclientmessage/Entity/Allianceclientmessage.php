<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAlliancelientmessage
 */

namespace DragonJsonServerAllianceclientmessage\Entity;

/**
 * Entityklasse einer Allianceclientmessage
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="allianceclientmessages")
 */
class Allianceclientmessage
{
	use \DragonJsonServerDoctrine\Entity\CreatedTrait;
    use \DragonJsonServerAlliance\Entity\AllianceIdTrait;
	
	/** 
	 * @Doctrine\ORM\Mapping\Id 
	 * @Doctrine\ORM\Mapping\Column(type="integer")
	 * @Doctrine\ORM\Mapping\GeneratedValue
	 **/
	protected $allianceclientmessage_id;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string")
     **/
    protected $key;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string")
     **/
    protected $data;
	
	/**
	 * Setzt die ID der Allianceclientmessage
	 * @param integer $allianceclientmessage_id
	 * @return Allianceclientmessage
	 */
	protected function setAllianceclientmessageId($allianceclientmessage_id)
	{
		$this->allianceclientmessage_id = $allianceclientmessage_id;
		return $this;
	}
	
	/**
	 * Gibt die ID der Allianceclientmessage zurück
	 * @return integer
	 */
	public function getAllianceclientmessageId()
	{
		return $this->allianceclientmessage_id;
	}

    /**
     * Setzt den Key der Allianceclientmessage
     * @param string $key
     * @return Allianceclientmessage
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Gibt den Key der Allianceclientmessage zurück
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Setzt die Daten der Allianceclientmessage
     * @param array $data
     * @return Allianceclientmessage
     */
    public function setData(array $data)
    {
        $this->data = \Zend\Json\Encoder::encode($data);
        return $this;
    }

    /**
     * Gibt die Daten der Allianceclientmessage zurück
     * @return array
     */
    public function getData()
    {
        return \Zend\Json\Decoder::decode($this->data, \Zend\Json\Json::TYPE_ARRAY);
    }
	
	/**
	 * Setzt die Attribute der Allianceclientmessage aus dem Array
	 * @param array $array
	 * @return Allianceclientmessage
	 */
	public function fromArray(array $array)
	{
		return $this
            ->setAllianceclientmessageId($array['allianceclientmessage_id'])
            ->setCreatedTimestamp($array['created'])
            ->setAllianceId($array['alliance_id'])
            ->setKey($array['key'])
            ->setData($array['data']);
	}
	
	/**
	 * Gibt die Attribute der Allianceclientmessage als Array zurück
	 * @return array
	 */
	public function toArray()
	{
		return [
			'__className' => __CLASS__,
			'allianceclientmessage_id' => $this->getAllianceclientmessageId(),
            'created' => $this->getCreatedTimestamp(),
            'alliance_id' => $this->getAllianceId(),
            'key' => $this->getKey(),
            'data' => $this->getData(),
		];
	}
}
