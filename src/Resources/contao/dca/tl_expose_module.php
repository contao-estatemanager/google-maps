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
    // Add palettes
    $GLOBALS['TL_DCA']['tl_expose_module']['palettes']['googleMap'] = '{title_legend},name,headline,type;{google_maps_legend},googleInitialZoom,googleMinZoom,googleMaxZoom,googleType,googleGestureHandling,googleInteractive,googleControls,googleFullscreen,googleStreetview,googleMapTypeControl,iFrameFallbackIfAddressNotPublished;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

    // Add fields
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleInitialZoom'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleInitialZoom'],
        'default' => 12,
        'exclude' => true,
        'inputType' => 'select',
        'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "int(2) unsigned NOT NULL default '12'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleMinZoom'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleMinZoom'],
        'default' => 0,
        'exclude' => true,
        'inputType' => 'select',
        'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "int(2) unsigned NOT NULL default '10'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleMaxZoom'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleMaxZoom'],
        'default' => 0,
        'exclude' => true,
        'inputType' => 'select',
        'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "int(2) unsigned NOT NULL default '14'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleType'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleType'],
        'default' => 'roadmap',
        'exclude' => true,
        'inputType' => 'select',
        'options' => [
            'roadmap' => 'roadmap',
            'satellite' => 'satellite',
            'hybrid' => 'hybrid',
            'terrain' => 'terrain',
        ],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(255) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleGestureHandling'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleGestureHandling'],
        'default' => 'cooperative',
        'exclude' => true,
        'inputType' => 'select',
        'options' => [
            'cooperative' => 'cooperative',
            'greedy' => 'greedy',
            'auto' => 'auto',
            'none' => 'none',
        ],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(16) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleInteractive'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleInteractive'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleControls'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleControls'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleFullscreen'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleFullscreen'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleStreetview'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleStreetview'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['googleMapTypeControl'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['googleMapTypeControl'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['iFrameFallbackIfAddressNotPublished'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_expose_module']['iFrameFallbackIfAddressNotPublished'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];
}
