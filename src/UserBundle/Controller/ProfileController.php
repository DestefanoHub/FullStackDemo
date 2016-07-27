<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/11/16
 * Time: 6:45 PM
 */

namespace UserBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Form\Type\ProfileFormType;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends FOSRestController
{
    /**
     * Display the current user's profile.
     *
     * @return Response
     *
     * @ApiDoc(
     *     resource = true,
     *     statusCodes = {
     *          200 = "Success",
     *          401 = "Unauthorized"
     *     }
     * )
     */
    public function showAction()
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedHttpException(401);
        }
        $serializer = $this->container->get('jms_serializer');
        $response = new Response();
        $response->headers->set('Content-Type', "application/json");
        $serializedUser = $serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array(
            'default', 'user',
        )));
        $response->setContent($serializedUser);
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * Edit the current user's profile.
     *
     * @param Request $request
     * @return Response
     *
     * @ApiDoc(
     *     statusCodes = {
     *          200 = "Edited",
     *          400 = "Invalid data",
     *          401 = "Unauthorized",
     *          404 = "User not found"
     *     }
     * )
     */
    public function editAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedHttpException(401);
        }

        $deletedAt = $user->getDeletedAt();
        if(isset($deletedAt)){
            throw new NotFoundHttpException(404);
        }

        $form = $this->createForm(ProfileFormType::class, $user, array(
            'csrf_protection' => false,
            'validation_groups' => function (FormInterface $form){
                $password = $form->get('plainPassword')->getData();
                if($password){
                    return array('profile');
                } else{
                    return array();
                }
            },
            'method' => 'PUT',
        ));

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $serializer = $this->container->get('jms_serializer');

        $form->handleRequest($request);
        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user, false);
            $serializedUser = $serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array(
                'default', 'user',
            )));
            $response->setContent($serializedUser);
            $response->setStatusCode(200);
            return $response;
        }
        $formErrors = $form->getErrors(true, true);
        $count = count($formErrors);
        $errorArray = array();
        for($i = 0; $i < $count; $i++){
            if($formErrors->valid()){
                array_push($errorArray, $formErrors->current());
                $formErrors->next();
            }
        }
        $errors = array(
            "message" => "The form contained invalid data.",
            "errorArray" => $errorArray
        );
        $serializedErrors = $serializer->serialize($errors, 'json');
        $response->setContent($serializedErrors);
        $response->setStatusCode(400);
        return $response;
    }
}