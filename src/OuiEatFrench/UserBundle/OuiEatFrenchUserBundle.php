<?php

namespace OuiEatFrench\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OuiEatFrenchUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
