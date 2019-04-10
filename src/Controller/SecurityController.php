<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends FOSRestController
{
//    /**
//     * @Rest\Post("/login_check", name="app_login_check")
//     */
//    public function login(AuthenticationUtils $authenticationUtils)
//    {
//    }
}