<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/5/16
 * Time: 5:41 PM
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends FOSRestController
{
    public function getTokenAction()
    {
        return new Response('', 401);
    }
}