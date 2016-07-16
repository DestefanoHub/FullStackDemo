<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/11/16
 * Time: 6:45 PM
 */

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use UserBundle\Form\Type\RegistrationFormType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends FOSRestController
{
    /**
     * Registers a new user with the system
     *
     * @param Request $request
     * @return Response
     *
     * @ApiDoc(
     *     resource = true,
     *      statusCodes = {
     *          201 = "Created",
     *          400 = "Invalid data"
     *     }
     * )
     */
    public function registerAction(Request $request)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $form = $this->createForm(RegistrationFormType::class, $user, array(
            'csrf_protection' => false,
            'validation_groups' => array('registration'),
            'method' => 'POST',
        ));

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $serializer = $this->container->get('jms_serializer');

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user->addRole("USER");
            $userManager->updateUser($user);

            $serializedUser = $serializer->serialize($user, 'json', SerializationContext::create()->setGroups(array(
                'default', 'user',
            )));
            $response->setContent($serializedUser);
            $response->setStatusCode(201);
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
            "code" => 400,
            "message" => "The form contained invalid data.",
            "errorArray" => $errorArray
        );
        $serializedErrors = $serializer->serialize($errors, 'json');
        $response->setContent($serializedErrors);
        $response->setStatusCode(400);
        return $response;
    }


    /**
     * NOT USED
     *  |
     *  |
     *  |
     * \|/
     *
     *
     *
     *
     *
     *
     */

    /**
     * Tell the user to check his email provider
     */
//    public function checkEmailAction()
//    {
//        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');
//        $this->get('session')->remove('fos_user_send_confirmation_email/email');
//        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);
//
//        if (null === $user) {
//            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
//        }
//
//        return $this->render('FOSUserBundle:Registration:checkEmail.html.twig', array(
//            'user' => $user,
//        ));
//    }
//
//    /**
//     * Receive the confirmation token from user email provider, login the user
//     */
//    public function confirmAction(Request $request, $token)
//    {
//        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
//        $userManager = $this->get('fos_user.user_manager');
//
//        $user = $userManager->findUserByConfirmationToken($token);
//
//        if (null === $user) {
//            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
//        }
//
//        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
//        $dispatcher = $this->get('event_dispatcher');
//
//        $user->setConfirmationToken(null);
//        $user->setEnabled(true);
//
//        $event = new GetResponseUserEvent($user, $request);
//        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);
//
//        $userManager->updateUser($user);
//
//        if (null === $response = $event->getResponse()) {
//            $url = $this->generateUrl('fos_user_registration_confirmed');
//            $response = new RedirectResponse($url);
//        }
//
//        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));
//
//        return $response;
//    }
//
//    /**
//     * Tell the user his account is now confirmed
//     */
//    public function confirmedAction()
//    {
//        $user = $this->getUser();
//        if (!is_object($user) || !$user instanceof UserInterface) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//
//        return $this->render('FOSUserBundle:Registration:confirmed.html.twig', array(
//            'user' => $user,
//            'targetUrl' => $this->getTargetUrlFromSession(),
//        ));
//    }
//
//    private function getTargetUrlFromSession()
//    {
//        // Set the SecurityContext for Symfony <2.6
//        if (interface_exists('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface')) {
//            $tokenStorage = $this->get('security.token_storage');
//        } else {
//            $tokenStorage = $this->get('security.context');
//        }
//
//        $key = sprintf('_security.%s.target_path', $tokenStorage->getToken()->getProviderKey());
//
//        if ($this->get('session')->has($key)) {
//            return $this->get('session')->get($key);
//        }
//    }
}