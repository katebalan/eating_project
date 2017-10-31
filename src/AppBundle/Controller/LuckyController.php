<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class LuckyController
{
    /**
     * @Route("/lucky/number", name="lucky_number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
//http://symfony.com/doc/current/best_practices/configuration.html
//http://www.kabit.ru/ru/post/%D0%9F%D0%BE%D0%B4%D1%81%D0%B2%D0%B5%D1%82%D0%BA%D0%B0_%D0%B2%D1%8B%D0%B2%D0%BE%D0%B4%D0%B0_%D0%B4%D0%BB%D1%8F_GIT.html
//https://habrahabr.ru/post/160177/
