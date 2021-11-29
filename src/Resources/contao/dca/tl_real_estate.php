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

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\GoogleMaps\AddonManager;

if (AddonManager::valid())
{
    // Add fields
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['plzBreitengrad'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_real_estate']['plzBreitengrad'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['maxlength' => 32, 'tl_class' => 'w50'],
        'sql' => "varchar(32) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['plzLaengengrad'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_real_estate']['plzLaengengrad'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['maxlength' => 32, 'tl_class' => 'w50'],
        'sql' => "varchar(32) NOT NULL default ''",
    ];

    // Extend default palette
    PaletteManipulator::create()
        ->addField(['plzBreitengrad', 'plzLaengengrad'], 'laengengrad', PaletteManipulator::POSITION_AFTER)
        ->applyToPalette('default', 'tl_real_estate')
    ;
}
