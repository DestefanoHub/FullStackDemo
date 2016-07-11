<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/11/16
 * Time: 6:42 PM
 */

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}