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
        if ($file->getMimeType() === "image/png" || $file->getMimeType() === "image/jpeg") {
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
        } else {
            return 0;
        }
    }

    public function errMessage() {
        return 'Error in file type. You have to upload an image/type file and it must be jpeg, jpg or png';
    }
}
