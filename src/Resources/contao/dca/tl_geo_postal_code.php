<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/google-maps
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

use ContaoEstateManager\GoogleMaps\AddonManager;

if (AddonManager::valid())
{
    $GLOBALS['TL_DCA']['tl_geo_postal_code'] = [
        // Config
        'config' => [
            'dataContainer' => 'Table',
            'sql' => [
                'keys' => [
                    'id' => 'primary',
                ],
            ],
        ],
        // Fields
        'fields' => [
            'id' => [
                'sql' => 'int(10) unsigned NOT NULL auto_increment',
            ],
            'code' => [
                'sql' => "varchar(8) NOT NULL default ''",
            ],
            'latitude' => [
                'sql' => "varchar(32) NOT NULL default ''",
            ],
            'longitude' => [
                'sql' => "varchar(32) NOT NULL default ''",
            ],
        ],
    ];
}
