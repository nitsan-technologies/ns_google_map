<?php

$EM_CONF['ns_google_map'] = [
	'title' => 'TYPO3 Google Map Extension',
	'description' => 'Easily integrate and customize responsive Google Maps on your TYPO3 website. Designed to be SEO-friendly and user-centric, it enhances user experience with smooth map embedding and layout options.',

	'category' => 'plugin',
	'author' => 'Team T3Planet',
	'author_email' => 'info@t3planet.de',
	'author_company' => 'T3Planet',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'version' => '14.0.2',
	'constraints' => [
		'depends' => [
			'php' => '8.1.0-8.5.99',
			'typo3' => '12.4.37-14.9.99',
			'ns_license' => '14.5.4-14.9.99',
		],
		'conflicts' => [],
		'suggests' => [],
	],
];
