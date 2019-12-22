<?php

namespace App\Service;

class GalleryService
{
    /**
     * @param string $galleryPath
     * @return string[]
     */
    public static function getFileList(string $galleryPath): array
    {
        return array_diff(scandir($galleryPath), array('..', '.'));
    }
}