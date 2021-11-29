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

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\GoogleMaps\AddonManager;

if (AddonManager::valid())
{
    $GLOBALS['TL_DCA']['tl_module']['palettes']['realEstateGoogleMap'] = '{title_legend},name,headline,type;{config_legend},realEstateGroups,filterMode;{provider_legend},filterByProvider;{google_maps_legend},googleInitialLat,googleInitialLng,googleInitialZoom,googleMinZoom,googleMaxZoom,googleType,googleGestureHandling,googleUseBounce,googleUseCluster,googleUseSpiderfier,googleUseBounds,googleInteractive,googleControls,googleFullscreen,googleStreetview,googleMapTypeControl;{redirect_legend},jumpTo;{template_legend:hide},customTpl,googleMapPopupTemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

    // Add fields
    $GLOBALS['TL_DCA']['tl_module']['fields']['googleInitialLat'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleInitialLat'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
        'sql' => "varchar(32) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleInitialLng'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleInitialLng'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
        'sql' => "varchar(32) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleInitialZoom'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleInitialZoom'],
        'default' => 12,
        'exclude' => true,
        'inputType' => 'select',
        'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "int(2) unsigned NOT NULL default '12'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleMinZoom'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleMinZoom'],
        'default' => 1,
        'exclude' => true,
        'inputType' => 'select',
        'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "int(2) unsigned NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleMaxZoom'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleMaxZoom'],
        'default' => 20,
        'exclude' => true,
        'inputType' => 'select',
        'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'eval' => ['tl_class' => 'w50'],
        'sql' => "int(2) unsigned NOT NULL default '20'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleType'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleType'],
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

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleGestureHandling'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleGestureHandling'],
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

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleUseCluster'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleUseCluster'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleUseSpiderfier'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleUseSpiderfier'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleUseBounce'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleUseBounce'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleInteractive'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleInteractive'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleControls'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleControls'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleFullscreen'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleFullscreen'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleStreetview'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleStreetview'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleMapTypeControl'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleMapTypeControl'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '1'",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleMapPopupTemplate'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleMapPopupTemplate'],
        'default' => 'maps_google_popup_default',
        'exclude' => true,
        'inputType' => 'select',
        'options_callback' => static fn () => Controller::getTemplateGroup('maps_google_popup_'),
        'eval' => ['tl_class' => 'w50'],
        'sql' => "varchar(64) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleFilterAddSorting'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleFilterAddSorting'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['submitOnChange' => true, 'tl_class' => 'w50 m12 clr'],
        'sql' => "char(1) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleFilterLat'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleFilterLat'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['mandatory' => true, 'tl_class' => 'w50 clr'],
        'sql' => "varchar(32) NOT NULL default ''",
    ];

    $GLOBALS['TL_DCA']['tl_module']['fields']['googleFilterLng'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['googleFilterLng'],
        'exclude' => true,
        'inputType' => 'text',
        'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
        'sql' => "varchar(32) NOT NULL default ''",
    ];

    // Add sorting option
    $GLOBALS['TL_DCA']['tl_module']['fields']['defaultSorting']['options'][] = 'location';

    // Add palettes
    $GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'googleFilterAddSorting';

    // Add subpalettes
    $GLOBALS['TL_DCA']['tl_module']['subpalettes']['googleFilterAddSorting'] = 'googleFilterLat,googleFilterLng';

    // Extend sorting subpalette
    PaletteManipulator::create()
        ->addField(['googleFilterAddSorting'], 'sorting_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToSubpalette('addSorting', 'tl_module')
    ;
}
