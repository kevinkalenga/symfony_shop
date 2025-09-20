<?php 

namespace App\Service;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper 
{
    // The best way to upload image into the database using symfony
    private $uploadsPath;
    private $slugger;

    public function __construct(string $uploadsPath, SluggerInterface $slugger)
    {
        $this->uploadsPath = $uploadsPath;
        $this->slugger = $slugger;
    }

    public function uploadProductImage(UploadFile $uploadedFile): String
    {
       $destination = $this->uploadsPath.'/product_images'; 

       $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
       $safeFilename = $this->slugger->slug($originalFilename);

       $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

       $uploadedFile->move(
          $destination,
          $newFilename
       );

       return $newFilename;
    }

    public function getTargetDirectory(): String 
    {
        return $this->uploadsPath.'/product_images';
    }
}