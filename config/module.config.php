<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAllianceclientmessage
 */

/**
 * @return array
 */
return [
	'service_manager' => [
		'invokables' => [
            '\DragonJsonServerAllianceclientmessage\Service\Allianceclientmessage' => '\DragonJsonServerAllianceclientmessage\Service\Allianceclientmessage',
		],
	],
	'doctrine' => [
		'driver' => [
			'DragonJsonServerAllianceclientmessage_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [
					__DIR__ . '/../src/DragonJsonServerAllianceclientmessage/Entity'
				],
			],
			'orm_default' => [
				'drivers' => [
					'DragonJsonServerAllianceclientmessage\Entity' => 'DragonJsonServerAllianceclientmessage_driver'
				],
			],
		],
	],
];
