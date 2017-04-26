<?php

namespace MGD\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MGDUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
