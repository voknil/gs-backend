<?php

declare(strict_types=1);

namespace App\Media\Storage;

interface GenerateUploadLink
{
    public function getFileName(): string;
}
