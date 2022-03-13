<?php
// src/Service/FileUploaderArticle.php
namespace App\Service;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FileUploader{
    private $params;

    public function __construct(ParameterBagInterface $params){
        $this->params = $params;
    }

    public function upload(UploadedFile $file, $path){
        $fileName = uniqid().'.'.$file->guessExtension();

        try {
            $file->move(
                $this->params->get($path),
                $fileName
            );
            return $fileName;
        } catch (FileException $e) {
            return $e;
        }
    }
}
