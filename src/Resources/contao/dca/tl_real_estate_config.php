<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/googlemaps
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

if(ContaoEstateManager\GoogleMaps\AddonManager::valid()) {
    // Add field
    $GLOBALS['TL_DCA']['tl_real_estate_config']['fields']['googleRadiusOptions'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_config']['googleRadiusOptions'],
        'default'                 => '1,2,3,4,5,10,15,20,30,50',
        'inputType'               => 'text',
        'eval'                    => array('tl_class'=>'w50')
    );

    $GLOBALS['TL_DCA']['tl_real_estate_config']['fields']['googleMapsDefaultMarkerSRC'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_config']['googleMapsDefaultMarkerSRC'],
        'exclude'                 => true,
        'inputType'               => 'fileTree',
        'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'isGallery'=>true, 'extensions'=>Contao\Config::get('validImageTypes'), 'tl_class'=>'clr w50'),
    );

    $GLOBALS['TL_DCA']['tl_real_estate_config']['fields']['googleMapUseClusterStyles'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate_config']['googleMapUseClusterStyles'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12 clr', 'submitOnChange'=>true),
    );

    $GLOBALS['TL_DCA']['tl_real_estate_config']['fields']['googleMapUseMapStyles'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate_config']['googleMapUseMapStyles'],
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'w50 m12 clr', 'submitOnChange'=>true),
    );

    $GLOBALS['TL_DCA']['tl_real_estate_config']['fields']['googleMapStylesScript'] = array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_real_estate_config']['googleMapStylesScript'],
        'inputType'               => 'textarea',
        'eval'                    => array('style'=>'height:120px', 'rte'=>'ace|js', 'tl_class'=>'clr'),
    );

    $GLOBALS['TL_DCA']['tl_real_estate_config']['fields']['googleMapClusterStyles'] = array
    (
        'label'     => &$GLOBALS['TL_LANG']['tl_real_estate_config']['googleMapClusterStyles'],
        'exclude'   => true,
        'inputType' => 'multiColumnWizard',
        'eval'      => [
            'maxCount'  => 5,
            'tl_class'  => 'clr',
            'columnFields' => [
                'image' => [
                    'label'         => &$GLOBALS['TL_LANG']['tl_real_estate_config']['clusterImage'],
                    'exclude'       => true,
                    'inputType'     => 'fileTree',
                    'eval'          => array('mandatory'=>true, 'fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>Contao\Config::get('validImageTypes')),
                ],
                'textColor' => [
                    'label'         => &$GLOBALS['TL_LANG']['tl_real_estate_config']['clusterTextColor'],
                    'inputType'     => 'text',
                    'eval'          => array('mandatory'=>true, 'valign'=>'bottom', 'maxlength'=>6, 'size'=>1, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'wizard', 'style'=>'width:100px'),
                ],
                'textSize' => [
                    'label'         => &$GLOBALS['TL_LANG']['tl_real_estate_config']['clusterTextSize'],
                    'inputType'     => 'text',
                    'default'       => 14,
                    'eval'          => array('mandatory'=>true, 'valign'=>'bottom', 'style'=>'width:100px', 'rgxp'=>'natural')
                ],
                'textOffsetX' => [
                    'label'         => &$GLOBALS['TL_LANG']['tl_real_estate_config']['clusterTextOffsetX'],
                    'inputType'     => 'text',
                    'default'       => 0,
                    'eval'          => array('mandatory'=>true, 'valign'=>'bottom', 'style'=>'width:100px', 'rgxp'=>'digit')
                ],
                'textOffsetY' => [
                    'label'         => &$GLOBALS['TL_LANG']['tl_real_estate_config']['clusterTextOffsetY'],
                    'inputType'     => 'text',
                    'default'       => 0,
                    'eval'          => array('mandatory'=>true, 'valign'=>'bottom', 'style'=>'width:100px', 'rgxp'=>'digit')
                ],
                'step' => [
                    'label'         => &$GLOBALS['TL_LANG']['tl_real_estate_config']['clusterStep'],
                    'inputType'     => 'text',
                    'default'       => 0,
                    'eval'          => array('mandatory'=>true, 'valign'=>'bottom', 'style'=>'width:80px', 'rgxp'=>'natural')
                ]
            ],
        ]
    );

    // Extend the default palettes
    $GLOBALS['TL_DCA']['tl_real_estate_config']['palettes']['__selector__'][] = 'googleMapUseClusterStyles';
    $GLOBALS['TL_DCA']['tl_real_estate_config']['palettes']['__selector__'][] = 'googleMapUseMapStyles';

    // Add subplattes
    $GLOBALS['TL_DCA']['tl_real_estate_config']['subpalettes']['googleMapUseClusterStyles'] = 'googleMapClusterStyles';
    $GLOBALS['TL_DCA']['tl_real_estate_config']['subpalettes']['googleMapUseMapStyles'] = 'googleMapStylesScript';

    // Extend default palette
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addField(array('googleRadiusOptions'), 'filter_config_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->addField(array('googleMapsDefaultMarkerSRC', 'googleMapsDefaultClusterSRC', 'googleMapUseClusterStyles', 'googleMapUseMapStyles'), 'google_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_real_estate_config')
    ;
}
