<?php
namespace App\Controller;

//require __DIR__.'/BaseController.php';
//require __DIR__.'/../Model/CategoryModel.php';


use App\Controller\BaseController;
use ImageKit\ImageKit;


class ImageKitController extends BaseController
{
    private $imageKit;

    public function init()
    {
        $this->imageKit = new ImageKit(
            "public_DgRh+fRF2Y8QPPIyq9+E3ew6nlo=",
            "private_Pb7F28A3S8JirIOobNJF5x2E57s=",
            "https://ik.imagekit.io/kivel59"
        );

        return $this->imageKit;
    }

    public function getAuthenticationParams()
    {
        $ik = $this->init();
        $authParams = $ik->getAuthenticationParameters();
        return json_encode($authParams);
    }
}
