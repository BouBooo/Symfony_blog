<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class Home extends AbstractController
{
    public function message()
    {
        return new Response(
            'yo bro'
        );
    }

    public function test($name)
    {
        return $this->render('test.html.twig', [
            'name' => $name
        ]);
    }
} 