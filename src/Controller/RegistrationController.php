<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ApiService;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as REST;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @REST\Post(
     *     name="api_user_create",
     *     path="/register",
     * )
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, ApiService $apiService): View
    {
//        dump($request, $request->request->get('firstName'));die;

        $newUser = new User();
        $em = $this->getDoctrine()->getManager();

        $isEmailExist = $em->getRepository(User::class)->findOneBy(['email' => $request->request->get('email')]);

        if ($isEmailExist) {
            return null;
        }

        $newUser->setLastName($request->request->get('lastName'));
        $newUser->setFirstName($request->request->get('firstName'));
        $newUser->setEmail($request->request->get('email'));
        $newUser->setAge($request->request->get('age'));
        $newUser->setSexe($request->request->get('sexe'));
        $newUser->setPhoneNumber($request->request->get('phoneNumber'));

        if ($request->request->get('password') != $request->request->get('confirmPassword')) {
              return null;
        }

        $encodedPassword = $passwordEncoder->encodePassword(
            $newUser,
            $request->request->get('password')
        );
        $newUser->setPassword($encodedPassword);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($newUser);
        $entityManager->flush();

        $formatted = [
            'id' => $newUser->getId() ?: null,
            'firstName' => $newUser->getFirstName() ?: null,
            'lastName' => $newUser->getLastName() ?: null,
            'email' => $newUser->getEmail() ?: null,
            'age' => $newUser->getAge() ?: null,
            'sexe' => $newUser->getSexe() ?: null,
            'phoneNumber' => $newUser->getPhoneNumber() ?: null,
        ];
// do anything else you need here, like send an email

        return $apiService->createFosRestView($formatted,
            Response::HTTP_CREATED, [
                'location' => $this->generateLocationUrl($newUser)
            ]);
    }

    /**
     * @param User $user
     *
     * @return string
     */
    private function generateLocationUrl($user)
    {
        return $this->generateUrl("api_user_one", ['email' => $user->getEmail()], UrlGeneratorInterface::ABSOLUTE_URL);
    }

}