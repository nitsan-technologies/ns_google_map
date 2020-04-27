<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,address,infocontent,closebyclick,openbyclick,opened,latitude,longitude,map, marker_image',
        'iconfile' => 'EXT:ns_google_map/Resources/Public/Icons/tx_nsgooglemap_domain_model_address.gif',
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, address, infocontent, maplink,closebyclick, openbyclick, opened, latitude, longitude, map, marker_image',
    ],
    'types' => [
        '1' => ['showitem' => 'title, address, infocontent, maplink,closebyclick, openbyclick, opened, latitude, longitude, map, marker_image, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, sys_language_uid, l10n_parent, l10n_diffsource, hidden,starttime, endtime'],
    ],
    'types' => [
        '0' => [
            'showitem' => 'title,map,marker_image,--palette--;;data,
					--div--;LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.info_window,
					infocontent,maplink,
					--palette--;LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.palettes.interaction;interaction',
            'columnsOverrides' => [
                'infocontent' => [
                    'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
                ],
            ],
        ],
    ],
    'palettes' => [
        'data' => ['showitem' => 'latitude, longitude, address'],
        'interaction' => ['showitem' => 'openbyclick, closebyclick, opened'],
        'time' => ['showitem' => 'starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_nsgooglemap_domain_model_address',
                'foreign_table_where' => 'AND tx_nsgooglemap_domain_model_address.pid=###CURRENT_PID### AND tx_nsgooglemap_domain_model_address.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],
        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'address' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.address',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'infocontent' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.infocontent',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
            'defaultExtras' => 'richtext:rte_transform[mode=ts_css]',
        ],        
        'closebyclick' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.closebyclick',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'openbyclick' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.openbyclick',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'opened' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.opened',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'latitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'longitude' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'map' => [
            'exclude' => true,
            'label' => 'LLL:EXT:ns_google_map/Resources/Private/Language/locallang_db.xlf:tx_nsgooglemap_domain_model_address.map',
            'config' => [
                'type' => 'user',
                'userFunc' => 'Nitsan\\NsGoogleMap\\Utility\\MapUtilityV8->render',
                'parameters' => [
                    'longitude' => 'longitude',
                    'latitude' => 'latitude',
                    'address' => 'address',
                ],
            ],
        ],        
    ],
];
