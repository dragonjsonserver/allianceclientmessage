<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAlliance
 */

namespace DragonJsonServerAlliance\Service;

/**
 * Serviceklasse zur Verwaltung der Allianceclientmessages
 */
class Allianceclientmessage
{
	use \DragonJsonServer\ServiceManagerTrait;
	use \DragonJsonServerDoctrine\EntityManagerTrait;

	/**
	 * Erstellt eine Allianceclientmessage die dem Alliance beim nächsten Request ausgeliefert wird
     * @param integer $alliance_id
     * @param string $key
     * @param array $data
	 * @return \DragonJsonServerAllianceclientmessage\Entity\Allianceclientmessage
	 */
	public function createAllianceclientmessage($alliance_id, $key, array $data = [])
	{
        $entityManager = $this->getEntityManager();

		$allianceclientmessage = (new \DragonJsonServerAllianceclientmessage\Entity\Allianceclientmessage())
            ->setAllianceId($alliance_id)
            ->setKey($key)
            ->setData($data);
        $entityManager->persist($allianceclientmessage);
        $entityManager->flush();
		return $allianceclientmessage;
	}

    /**
     * Entfernt alle Allianceclientmessages der übergebenen AllianceId
     * @param integer $alliance_id
     * @return Allianceclientmessage
     */
    public function removeAllianceclientmessagesByAllianceId($alliance_id)
    {
        $entityManager = $this->getEntityManager();

        $allianceclientmessages = $entityManager
            ->getRepository('\DragonJsonServerAllianceclientmessage\Entity\Allianceclientmessage')
            ->findBy(['alliance_id' => $alliance_id]);
        foreach ($allianceclientmessages as $allianceclientmessage) {
            $entityManager->remove($allianceclientmessage);
        }
        $entityManager->flush();
    }

	/**
	 * Gibt die Allianceclientmessages der übergebenen AllianceId und des Clientmessage Events zurück
	 * @param integer $alliance_id
     * @param \DragonJsonServer\Event\Clientmessages $eventClientmessages
	 * @return array
	 */
	public function getAllianceclientmessagesByAllianceIdAndEventClientmessages($alliance_id,
                                                                                \DragonJsonServer\Event\Clientmessages $eventClientmessages)
	{
        $entityManager = $this->getEntityManager();

        return $entityManager
            ->createQuery('
                SELECT allianceclientmessages
                FROM \DragonJsonServerAllianceclientmessage\Entity\Allianceclientmessage allianceclientmessages
                WHERE
                    allianceclientmessages.alliance_id = :alliance_id
                    AND
                    allianceclientmessages.created >= :from
                    AND
                    allianceclientmessages.created < :to
                    AND
                    allianceclientmessages.key IN (:keys)
                ORDER BY
                    allianceclientmessages.created
            ')
            ->execute([
                'alliance_id' => $alliance_id,
                'from' => $eventClientmessages->getFrom(),
                'to' => $eventClientmessages->getTo(),
                'keys' => $eventClientmessages->getKeys(),
            ]);
	}
}
