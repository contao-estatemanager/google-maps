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

namespace ContaoEstateManager\GoogleMaps;

use Contao\Config;
use Contao\File;
use Contao\FilesModel;
use Contao\StringUtil;

class GoogleMaps
{
    /**
     * Return a style package for clustered markers.
     *
     * @param $objFileModel
     * @param $disablePathCount
     *
     * @throws \Exception
     */
    public static function getMarkerImage($objFileModel = null, $disablePathCount = true): ?array
    {
        if (null === $objFileModel && $markerImage = Config::get('googleMapsDefaultMarkerSRC'))
        {
            $objFileModel = FilesModel::findByUuid($markerImage);
        }

        if (null !== $objFileModel && is_file(TL_ROOT.'/'.$objFileModel->path))
        {
            $markerSize = [];
            $markerImagePath = $objFileModel->path.($disablePathCount ? '?disablePathCount=1' : '');

            $objFile = new File($objFileModel->path);

            if (null !== $objFile)
            {
                $imageSize = $objFile->imageSize;

                $markerSize[0] = $imageSize[0];
                $markerSize[1] = $imageSize[1];

                return [$markerImagePath, $markerSize];
            }
        }

        return null;
    }

    /**
     * Return a style package for map.
     */
    public static function getMapStyles(): ?array
    {
        if (!Config::get('googleMapUseMapStyles'))
        {
            return null;
        }

        return json_decode(Config::get('googleMapStylesScript')) ?: null;
    }

    /**
     * Return a style package for clustered markers.
     *
     * @param $arrClusterStyles
     *
     * @throws \Exception
     */
    public static function getClusterStyles($arrClusterStyles = null): ?array
    {
        if (!Config::get('googleMapUseClusterStyles'))
        {
            return null;
        }

        if (null === $arrClusterStyles)
        {
            $arrClusterStyles = StringUtil::deserialize(Config::get('googleMapClusterStyles'));
        }

        if ($arrClusterStyles)
        {
            $clusterStyles = [];
            $clusterSteps = [];

            foreach ($arrClusterStyles as $styles)
            {
                if ($clusterImage = $styles['image'])
                {
                    $objModel = FilesModel::findByUuid($clusterImage);

                    if (null !== $objModel && is_file(TL_ROOT.'/'.$objModel->path))
                    {
                        $url = $objModel->path.'?disablePathCount=1';

                        $objFile = new File($objModel->path);

                        if (null !== $objFile)
                        {
                            $imageSize = $objFile->imageSize;

                            $width = $imageSize[0];
                            $height = $imageSize[1];

                            $clusterSteps[] = (int) ($styles['step']);

                            $clusterStyles[] = [
                                'url' => $url,
                                'width' => $width,
                                'height' => $height,
                                'anchor' => [
                                    (int) ($styles['textOffsetY']),
                                    (int) ($styles['textOffsetX']),
                                ],
                                'textColor' => '#'.$styles['textColor'],
                                'textSize' => $styles['textSize'],
                            ];
                        }
                    }
                }
            }

            return [$clusterSteps, $clusterStyles];
        }

        return null;
    }
}
