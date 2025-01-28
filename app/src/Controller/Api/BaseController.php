<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", requirements={"_locale": "en|ru"}, name="app_api_")
 */
class BaseController extends AbstractController
{
}
