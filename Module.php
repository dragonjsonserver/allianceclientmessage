<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAllianceclientmessage
 */

namespace DragonJsonServerAllianceclientmessage;

/**
 * Klasse zur Initialisierung des Moduls
 */
class Module
{
    use \DragonJsonServer\ServiceManagerTrait;

    /**
     * Gibt die Konfiguration des Moduls zurück
     * @return array
     */
    public function getConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }

    /**
     * Gibt die Autoloaderkonfiguration des Moduls zurück
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * Wird bei der Initialisierung des Moduls aufgerufen
     * @param \Zend\ModuleManager\ModuleManager $moduleManager
     */
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
    {
        $sharedManager = $moduleManager->getEventManager()->getSharedManager();
        $sharedManager->attach('DragonJsonServer\Service\Clientmessages', 'Clientmessages',
            function (\DragonJsonServer\Event\Clientmessages $eventClientmessages) {
                $serviceManager = $this->getServiceManager();

                $serviceAllianceavatar = $serviceManager->get('\DragonJsonServerAlliance\Service\Allianceavatar');
                $allianceavatar = $serviceAllianceavatar->getAllianceavatar();
                if (!isset($allianceavatar)) {
                    $avatar = $serviceManager->get('\DragonJsonServerAvatar\Service\Avatar')
                        ->getAvatar();
                    if (!isset($avatar)) {
                        return;
                    }
                    $allianceavatar = $serviceAllianceavatar->getAllianceavatarByAvatar($avatar, false);
                    if (!isset($allianceavatar)) {
                        return;
                    }
                }
                $allianceclientmessages = $serviceManager->get('\DragonJsonServerAllianceclientmessage\Service\Allianceclientmessage')
                    ->getAllianceclientmessagesByAllianceIdAndEventClientmessages($allianceavatar->getAllianceId(), $eventClientmessages);
                $serviceClientmessages = $serviceManager->get('\DragonJsonServer\Service\Clientmessages');
                foreach ($allianceclientmessages as $allianceclientmessage) {
                    $serviceClientmessages->addClientmessage($allianceclientmessage->getKey(), $allianceclientmessage->getData());
                }
            }
        );
        $sharedManager->attach('DragonJsonServerAlliance\Service\Alliance', 'RemoveAlliance',
            function (\DragonJsonServerAlliance\Event\RemoveAlliance $eventRemoveAlliance) {
                $alliance = $eventRemoveAlliance->getAlliance();
                $this->getServiceManager()->get('\DragonJsonServerAllianceclientmessage\Service\Allianceclientmessage')
                    ->removeAllianceclientmessagesByAllianceId($alliance->getAllianceId());
            }
        );
    }
}
