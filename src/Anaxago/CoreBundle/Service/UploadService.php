<?php

namespace Anaxago\CoreBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{
    /**
     * The directory where the file will be stored.
     *
     * @var string
     */
    protected $destination;

    /**
     * UploadService constructor.
     */
    public function __construct(string $destination)
    {
        $this->destination = $destination;
    }

    /**
     * Upload the given file.
     */
    public function upload(UploadedFile $file): string
    {
        if (!$file) {
            return '';
        }

        $fileName = $this->createFileName($file);

        $file->move($this->getFullPath(), $fileName);

        return $this->getShortPath() . '/' . $fileName;
    }

    /**
     * Create a unique file name for a file to be stored.
     */
    protected function createFileName(UploadedFile $file): string
    {
        return md5(uniqid()) . '.' . $file->guessExtension();
    }

    /**
     * Get the path where the files should be uploaded.
     * This one is an absolute path.
     */
    protected function getFullPath()
    {
        return $this->destination . '/' . $this->getShortPath();
    }

    /**
     * Get the path where the file will be uploaded.
     */
    protected function getShortPath()
    {
        return date('Y') . '/' . date('m');
    }
}