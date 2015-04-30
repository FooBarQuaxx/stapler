<?php namespace Codesleeve\Stapler\Storage;

use Codesleeve\Stapler\Exceptions;
use Codesleeve\Stapler\Attachment;

class Flysystem implements StorageableInterface
{

    public $attachedFile;
    public $flysystem;


    function __construct($attachedFile, $flysystem_instance)
    {
        $this->attachedFile = $attachedFile;
        $this->flysystem = $flysystem_instance;
    }

    public function url($styleName)
    {
        return $this->attachedFile->getInterpolator()->interpolate($this->attachedFile->url, $this->attachedFile, $styleName);
    }

    public function path($styleName)
    {
        return $this->attachedFile->getInterpolator()->interpolate($this->attachedFile->path, $this->attachedFile, $styleName);
    }

    public function remove(array $filePaths)
    {
         foreach ($filePaths as $filePath) {
            $this->flysystem->delete($filePath);
         }
    }

    public function move($file, $filePath)
    {
        $this->moveFile($file, $filePath);
    }

    protected function moveFile($file, $filePath)
    {
        $content = file_get_contents($file);
        $this->flysystem->put($filePath, $content);
    }
}
