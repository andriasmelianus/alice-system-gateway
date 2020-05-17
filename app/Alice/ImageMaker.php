<?php
namespace App\Alice;

use Intervention\Image\ImageManager;

class ImageMaker {
    private $maker;
    private $imageFullPath;
    private $newImageFilename;

    private $iconImageWidthValue = 80;
    private $smallImageWidthValue = 150;
    private $mediumImageWidthValue = 400;
    private $largeImageWidthValue = 800;

    private $basePath;
    private $specificPath;

    private $iconImagePathSuffix = 'icon/';
    private $smallImagePathSuffix = 'small/';
    private $mediumImagePathSuffix = 'medium/';
    private $largeImagePathSuffix = 'large/';

    private $iconImageSavePath;
    private $smallImageSavePath;
    private $mediumImageSavePath;
    private $largeImageSavePath;

    /**
     * Constructor
     *
     * @param String $imageFullPath
     * @param String $newImageFilename
     * @param String $specificPath (Opsional) Menentukan nama folder di bawah Base Path. Contoh: product/, user/, dsb.
     */
    public function __construct($imageFullPath, $newImageFilename, $specificPath=''){
        $this->maker = new ImageManager();
        $this->basePath = base_path('public/images/');

        $this->imageFullPath = $imageFullPath;
        $this->specificPath = $specificPath;
        $this->iconImageSavePath = $this->basePath.$this->specificPath.$this->iconImagePathSuffix;
        $this->smallImageSavePath = $this->basePath.$this->specificPath.$this->smallImagePathSuffix;
        $this->mediumImageSavePath = $this->basePath.$this->specificPath.$this->mediumImagePathSuffix;
        $this->largeImageSavePath = $this->basePath.$this->specificPath.$this->largeImagePathSuffix;

        $this->newImageFilename = $newImageFilename;
    }

    /**
     * Getter Base Path
     * Mengembalikan alamat fisik pada filesystem sistem operasi.
     * Contoh: D:\xampp\htdocs\alice\public\...
     *
     * @return String
     */
    public function getBasePath(){
        return $this->basePath.$this->specificPath;
    }

    /**
     * Mempersiapkan folder di mana gambar akan disimpan.
     *
     * @param String $folderPath
     * @return void
     */
    private function prepareFolder($folderPath){
        if(!\file_exists($folderPath)){
            mkdir($folderPath, 666, true);
        }
    }

    /**
     * Buat file icon yang otomatis tersimpan pada folder icon
     */
    public function makeIcon(){
        $this->prepareFolder($this->iconImageSavePath);

        $theImage = $this->maker->make($this->imageFullPath);
        $theImage->resize($this->iconImageWidthValue, null, function($constraint){$constraint->aspectRatio();})
            ->save($this->iconImageSavePath.$this->newImageFilename);
    }

    /**
     * Buat file small yang otomatis tersimpan pada folder small
     */
    public function makeSmall(){
        $this->prepareFolder($this->smallImageSavePath);

        $theImage = $this->maker->make($this->imageFullPath);
        $theImage->resize($this->smallImageWidthValue, null, function($constraint){$constraint->aspectRatio();})
            ->save($this->smallImageSavePath.$this->newImageFilename);
    }

    /**
     * Buat file medium yang otomatis tersimpan pada folder medium
     */
    public function makeMedium(){
        $this->prepareFolder($this->mediumImageSavePath);

        $theImage = $this->maker->make($this->imageFullPath);
        $theImage->resize($this->mediumImageWidthValue, null, function($constraint){$constraint->aspectRatio();})
            ->save($this->mediumImageSavePath.$this->newImageFilename);
    }

    /**
     * Buat file large yang otomatis tersimpan pada folder large
     */
    public function makeLarge(){
        $this->prepareFolder($this->largeImageSavePath);

        $theImage = $this->maker->make($this->imageFullPath);
        $theImage->resize($this->largeImageWidthValue, null, function($constraint){$constraint->aspectRatio();})
            ->save($this->largeImageSavePath.$this->newImageFilename);
    }

    /**
     * Jalankan semua jenis make...
     */
    public function makeAll(){
        $this->makeIcon();
        $this->makeSmall();
        $this->makeMedium();
        $this->makeLarge();
    }
}
