<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/19/16
 * Time: 4:54 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\BattleMech;
use AppBundle\Entity\User;
use AppBundle\Form\BattleMechFormType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Model\UserInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class BattleMechController extends FOSRestController
{
    /**
     * Retrieves all BattleMechs.
     * @ApiDoc(
     *     resource = true,
     *     statusCodes = {
     *          200 = "Success",
     *          400 = "Invalid parameters",
     *          401 = "Unauthorized"
     *     }
     * )
     * @Rest\QueryParam(name="offset", requirements="\d+", default=0, description="Offset of Mechs to display")
     * @Rest\QueryParam(name="limit", requirements="\d+", default=100, description="Limit of Mechs to display")
     * @Rest\QueryParam(name="direction", requirements="\w+", description="Ordering direction")
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function allAction(ParamFetcherInterface $paramFetcher)
    {
        /** @var User $user */
        $user = $this->getUser();
        if(!is_object($user) || !$user instanceof UserInterface){
            throw new UnauthorizedHttpException(401);
        }

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $direction = strtoupper($paramFetcher->get('direction'));
        if(!($direction == "DESC" || $direction == "ASC")){
            throw new BadRequestHttpException(400);
        }

        $mechs = $this->getDoctrine()->getRepository("AppBundle:BattleMech")->getAllBattleMechs($offset, $limit, $direction);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $serializer = $this->container->get('jms_serializer');
        $serializedMechs = $serializer->serialize($mechs, 'json', SerializationContext::create()->setGroups(array(
            'default', 'mech-stub',
        )));
        $response->setContent($serializedMechs);
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * Retrieves all BattleMechs in a weight class.
     * @ApiDoc(
     *     statusCodes = {
     *          200 = "Success",
     *          400 = "Invalid parameters",
     *          401 = "Unauthorized"
     *     }
     * )
     * @Rest\QueryParam(name="offset", requirements="\d+", default=0, description="Offset of Mechs to display")
     * @Rest\QueryParam(name="limit", requirements="\d+", default=100, description="Limit of Mechs to display")
     * @Rest\QueryParam(name="weightClass", requirements="\w+", description="Weight range of Mechs to display")
     * @Rest\QueryParam(name="direction", requirements="\w+", default="DESC", description="Ordering direction")
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function byWeightClassAction(ParamFetcherInterface $paramFetcher)
    {
        /** @var User $user */
        $user = $this->getUser();
        if(!is_object($user) || !$user instanceof UserInterface){
            throw new UnauthorizedHttpException(401);
        }

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $weightClass = strtoupper($paramFetcher->get('weightClass'));
        $direction = strtoupper($paramFetcher->get('direction'));
        if(!($direction == "ASC" || $direction == "DESC")){
            throw new BadRequestHttpException(400);
        }

        $minWeight = null;
        $maxWeight = null;
        switch($weightClass){
            case "LIGHT":
                $minWeight = 20;
                $maxWeight = 35;
                break;
            case "MEDIUM":
                $minWeight = 40;
                $maxWeight = 55;
                break;
            case "HEAVY":
                $minWeight = 60;
                $maxWeight = 75;
                break;
            case "ASSAULT":
                $minWeight = 80;
                $maxWeight = 100;
                break;
            default:
                throw new BadRequestHttpException(400);
        }

        $mechs = $this->getDoctrine()->getRepository("AppBundle:BattleMech")->allBattleMechsByWeightClass($offset, $limit, $direction, $minWeight, $maxWeight);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $serializer = $this->container->get('jms_serializer');
        $serializedMechs = $serializer->serialize($mechs, 'json', SerializationContext::create()->setGroups(array(
            'default', 'mech-stub',
        )));
        $response->setContent($serializedMechs);
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * Retrieves all BattleMechs whose names start with the string provided. Partial strings are acceptable.
     * @ApiDoc(
     *     statusCodes = {
     *          200 = "Success",
     *          400 = "Invalid parameters",
     *          401 = "Unauthorized"
     *      }
     * )
     * @Rest\QueryParam(name="offset", requirements="\d+", default=0, description="Offset of Mechs to display")
     * @Rest\QueryParam(name="limit", requirements="\d+", default=100, description="Limit of Mechs to display")
     * @Rest\QueryParam(name="name", requirements="\w+", description="String name to search on")
     * @param ParamFetcherInterface $paramFetcher
     * @return Response
     */
    public function byNameAction(ParamFetcherInterface $paramFetcher)
    {
        /** @var User $user */
        $user = $this->getUser();
        if(!is_object($user) || !$user instanceof UserInterface){
            throw new UnauthorizedHttpException(401);
        }

        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $name = $paramFetcher->get('name');
        if($name == null || 1 == preg_match("/^$/", $name)){
            throw new BadRequestHttpException(400);
        }

        $mechs = $this->getDoctrine()->getRepository('AppBundle:BattleMech')->battlemechsByName($offset, $limit, $name);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        if($mechs == false){
            $error = [
                "message" => "The search parameter you provided yielded no results."
            ];
            $serializer = $this->container->get('jms_serializer');
            $serializedError = $serializer->serialize($error, 'json');
            $response->setContent($serializedError);
            $response->setStatusCode(400);
            return $response;
        } else{
            $serializer = $this->container->get('jms_serializer');
            $serializedMechs = $serializer->serialize($mechs, 'json', SerializationContext::create()->setGroups(array(
                'default', 'mech-stub',
            )));
            $response->setContent($serializedMechs);
            $response->setStatusCode(200);
            return $response;
        }
    }

    /**
     * Retrieves all information about a single BattleMech as long as it is in stock
     * @param BattleMech $mech
     * @return Response|NotFoundHttpException
     */
    public function getAction(BattleMech $mech)
    {
        /** @var User $user */
        $user = $this->getUser();
        if(!is_object($user) || !$user instanceof UserInterface){
            throw new UnauthorizedHttpException(401);
        }

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $serializer = $this->container->get('jms_serializer');
        $serializedMech = $serializer->serialize($mech, 'json', SerializationContext::create()->setGroups(array(
            'default', 'mech', 'engine'
        )));
        $response->setContent($serializedMech);
        $response->setStatusCode(200);
        return $response;
    }

    public function postAction()
    {

    }

    public function putAction()
    {

    }

    private function processForm()
    {

    }

    private function createBattleMechForm(BattleMech $mech, $method)
    {
        $form = $this->createForm(BattleMechFormType::class, $mech, array(
            'csrf_protection' => false,
            'method' => $method
        ));
        return $form;
    }

    public function deleteAction()
    {

    }
}