<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return View
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): View
    {
        $newUser = new User();
        $em = $this->getDoctrine()->getManager();

        $getUserByEmail = $em->getRepository(User::class)->findOneBy(['email' => $request->request->get('email')]);

        // INSCRIPTION VIA FB AVEC DEJA UN COMPTE SUR APPLI
        if (($getUserByEmail and $request->request->get('fbUserInfo')) and !$getUserByEmail->getCreatedFromFacebook()) {
            $actualYear = new DateTime();
            $userBirthdayDate = new DateTime($request->request->get('fbUserInfo')['birthday']);
            $age = $actualYear->format('Y') - $userBirthdayDate->format('Y');

            $getUserByEmail->setFacebookId($request->request->get('fbUserInfo')['id']);
            !$getUserByEmail->getLastName() ? $getUserByEmail->setLastName($request->request->get('lastName')) : null;
            !$getUserByEmail->getFirstName() ? $getUserByEmail->setFirstName($request->request->get('firstName')) : null;
            !$getUserByEmail->getSexe() ? $getUserByEmail->setSexe($request->request->get('sexe')) : null;
            $getUserByEmail->setAge($age);
            $getUserByEmail->setBirthdayDate($userBirthdayDate);
            $newUser->setCreatedFromFacebook(true);

            $em->persist($getUserByEmail);
            $em->flush();

            $formatted = $this->formattedView($getUserByEmail);

            return View::create($formatted, Response::HTTP_CREATED);

        } elseif (!$getUserByEmail and $request->request->get('fbUserInfo')) {         // INSCRIPTION VIA FB SANS COMPTE SUR APPLI

            $actualYear = new DateTime();
            $userBirthdayDate = new DateTime($request->request->get('fbUserInfo')['birthday']);
            $age = $actualYear->format('Y') - $userBirthdayDate->format('Y');

            $newUser->setFacebookId($request->request->get('fbUserInfo')['id']);
            $newUser->setLastName($request->request->get('lastName'));
            $newUser->setFirstName($request->request->get('firstName'));
            $newUser->setSexe($request->request->get('sexe'));
            $newUser->setEmail($request->request->get('email'));
            $newUser->setAge($age);
            $newUser->setBirthdayDate($userBirthdayDate);
            $newUser->setCreatedFromFacebook(true);


            $newUser->setPasswordPlainText($request->request->get('fbUserInfo')['id']);

            $encodedPassword = $passwordEncoder->encodePassword(
                $newUser,
                $request->request->get('fbUserInfo')['id']
            );
            $newUser->setPassword($encodedPassword);

            $em->persist($newUser);

            $em->flush();

            $formatted = $this->formattedView($newUser);


            return View::create($formatted, Response::HTTP_CREATED);

        } elseif ($getUserByEmail and !$request->request->get('fbUserInfo') and !$getUserByEmail->getCreatedFromFacebook()) {
            // INSCRIPTION VIA FORMULAIRE AVEC DEJA UN COMPTE SUR APPLI

            throw new HttpException(500, "Ce compte existe déjà en faite");
        } elseif ($getUserByEmail and $request->request->get('fbUserInfo') and $getUserByEmail->getCreatedFromFacebook()) {
            // INSCRIPTION VIA FB AVEC DEJA UN COMPTE CREER VIA FB UNIQUEMENT

            $formatted = $this->formattedView($getUserByEmail);


            return View::create($formatted, Response::HTTP_CREATED);
        } elseif ($getUserByEmail and !$request->request->get('fbUserInfo') and $getUserByEmail->getCreatedFromFacebook()) {
            // INSCRIPTION VIA FORMULAIRE INSCRIPTION AVEC DEJA UN COMPTE CREER VIA FB UNIQUEMENT
            $em->remove($getUserByEmail);
            $em->flush();

            $actualYear = new DateTime();
            $userBirthdayDate = new DateTime($request->request->get('age'));
            $age = $actualYear->format('Y') - $userBirthdayDate->format('Y');

            $newUser->setLastName($request->request->get('lastName'));
            $newUser->setFirstName($request->request->get('firstName'));
            $newUser->setEmail($request->request->get('email'));
            $newUser->setAge($age);
            $newUser->setBirthdayDate($userBirthdayDate);
            $newUser->setSexe($request->request->get('sexe'));
            $newUser->setPhoneNumber($request->request->get('phoneNumber'));
            $newUser->setCreatedFromFacebook(false);

            if ($request->request->get('password') != $request->request->get('confirmPassword')) {
                return null;
            }
            $newUser->setPasswordPlainText($request->request->get('password'));

            $encodedPassword = $passwordEncoder->encodePassword(
                $newUser,
                $request->request->get('password')
            );
            $newUser->setPassword($encodedPassword);

            $em->persist($newUser);

            $em->flush();

            $formatted = $this->formattedView($newUser);


            return View::create($formatted, Response::HTTP_CREATED);

        } else {
            $actualYear = new DateTime();
            $userBirthdayDate = new DateTime($request->request->get('age'));
            $age = $actualYear->format('Y') - $userBirthdayDate->format('Y');

            $newUser->setLastName($request->request->get('lastName'));
            $newUser->setFirstName($request->request->get('firstName'));
            $newUser->setEmail($request->request->get('email'));
            $newUser->setAge($age);
            $newUser->setBirthdayDate($userBirthdayDate);
            $newUser->setSexe($request->request->get('sexe'));
            $newUser->setPhoneNumber($request->request->get('phoneNumber'));
            $newUser->setCreatedFromFacebook(false);

            if ($request->request->get('password') != $request->request->get('confirmPassword')) {
                  return null;
            }
            $newUser->setPasswordPlainText($request->request->get('password'));

            $encodedPassword = $passwordEncoder->encodePassword(
                $newUser,
                $request->request->get('password')
            );
            $newUser->setPassword($encodedPassword);

            $em->persist($newUser);

            $em->flush();

            $formatted = $this->formattedView($newUser);

            return View::create($formatted, Response::HTTP_CREATED);

        }
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

    private function formattedView($user)
    {
        return $formatted = [
            "id" => $user->getId(),
            "email"=> $user->getEmail(),
            "first_name"=> $user->getFirstName(),
            "last_name"=> $user->getLastName(),
            "sexe"=> $user->getSexe(),
            "phone_number"=> $user->getPhoneNumber(),
            "age"=> $user->getAge(),
            "facebook_id"=> $user->getFacebookId(),
            "created_from_facebook"=> $user->getCreatedFromFacebook(),
            "password"=> $user->getPassword(),
            "password_plain_text"=> $user->getPasswordPlainText(),
            "birthday_date"=> $user->getBirthdayDate(),
        ];
    }
}
