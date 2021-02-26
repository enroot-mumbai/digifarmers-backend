<?php

namespace App\Controller\Users;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;
use App\Forms\UserType;
use App\Forms\UserPersonalDetailsType;

class UserController extends AbstractFOSRestController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Get("/", name="user_get")
     * @return View
     */
    public function getAuthenticatedProfile()
    {

        return new View( $this->getUser());
    }

    /**
     * @Rest\Put("/signup", name="signup_user", methods={"POST"})
     * @param Request $request
     * @return View|User|JsonResponse
     */
    public function register(
        Request $request
    ): View {
        try {
            $user = new User();
            $form = $this->createForm(UserType::class, $user, [
                'csrf_protection' => false,
                'method'          => 'POST'
            ]);

            $data = json_decode($request->getContent(), true);
            $form->submit($data);

            if ($form->isSubmitted() && $form->isValid()) {
                $user->setGuid("user_1234567890");
                $this->em->persist($user);
                $this->em->flush();

                return new View("ok", Response::HTTP_OK);
            }

            if ($form->getErrors()) {
                $errors = $this->getErrorsFromForm($form);
                $data   = [
                    'type'   => 'validation_error',
                    'title'  => 'There was a validation error',
                    'errors' => $errors
                ];

                return new View($data, 400);
            }

        } catch (\Exception $e) {
            return new View($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new View("",Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Rest\Post("/personalDetails",name="personal_details_post")
     * @param Request $request
     * @return View
     */
    public function registerPersonalDetails(Request $request)
    {
        try {
            /** @var User $user */
            $user = $this->getUser();

            $form = $this->createForm(UserPersonalDetailsType::class, $user, [
                'csrf_protection' => false,
                'method'          => 'POST'
            ]);


            $data = json_decode($request->getContent(), true);
            $form->submit($data);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($user);
                $this->em->flush();
                return new View($user);
            }

            if ($form->getErrors()) {
                $errors = $this->getErrorsFromForm($form);
                $data   = [
                    'type'   => 'validation_error',
                    'title'  => 'There was a validation error',
                    'errors' => $errors
                ];

                return new View($data, 400);
            }

        } catch (\Exception $e) {
            return new View($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new View("",Response::HTTP_INTERNAL_SERVER_ERROR);
    }



    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }
}
