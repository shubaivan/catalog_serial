<?php

namespace App\Controller\Api\Serial;

use App\Controller\Api\AbstractRestController;
use App\Entity\Serial;
use App\Exception\ValidatorException;
use App\Repository\SerialRepository;
use App\Service\ObjectManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SerialsApiController extends AbstractRestController
{
    /**
     * @var SerialRepository
     */
    private $serialsRepository;

    /**
     * @var ObjectManager $objectManager
     */
    private $objectManager;

    /**
     * SerialsApiController constructor.
     * @param SerialRepository $serialsRepository
     * @param ObjectManager $objectManager
     */
    public function __construct(SerialRepository $serialsRepository, ObjectManager $objectManager)
    {
        $this->serialsRepository = $serialsRepository;
        $this->objectManager = $objectManager;
    }

    /**
     * get Serials.
     * <strong>Simple example:</strong><br />
     * http://endpoint/api/serials/data <br>.
     *
     * @ApiDoc(
     * resource = true,
     * description = "get Serials",
     * authentication=true,
     *  parameters={
     *
     *  },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Bad request"
     * },
     * section="Serials"
     * )
     *
     * @RestView()
     *
     * @throws NotFoundHttpException when not exist
     *
     * @return Response|View
     *
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
     *
     * @Rest\QueryParam(name="count", requirements="\d+", default="10", description="Count entity at one page")
     * @Rest\QueryParam(name="page", requirements="\d+", default="1", description="Number of page to be shown")
     * @Rest\QueryParam(name="sort_by", strict=true, requirements="^[a-zA-Z]+", default="createdAt", description="Sort by", nullable=true)
     * @Rest\QueryParam(name="sort_order", strict=true, requirements="^[a-zA-Z]+", default="DESC", description="Sort order", nullable=true)
     *
     * @param ParamFetcher $paramFetcher
     */
    public function getSerialsDataAction(ParamFetcher $paramFetcher)
    {
        try {
            return $this->createSuccessResponse(
                [
                    'collection' => $this->serialsRepository->getSerials($paramFetcher),
                    'count' => $this->serialsRepository->getSerials($paramFetcher, true)
                ]
            );
        } catch (\Exception $e) {
            $view = $this->view((array)$e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * get Serial by id.
     * <strong>Simple example:</strong><br />
     * http://endpoint/api/serials/data/{id} <br>.
     *
     * @ApiDoc(
     * resource = true,
     * description = "get Serial by id",
     * authentication=true,
     *  parameters={
     *
     *  },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Bad request"
     * },
     * section="Serials"
     * )
     *
     * @RestView()
     *
     * @throws NotFoundHttpException when not exist
     *
     * @return Response|View
     *
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
     */
    public function getSerialAction(Serial $serial)
    {
        try {
            return $this->createSuccessResponse(
                $serial
            );
        } catch (\Exception $e) {
            $view = $this->view((array)$e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * put Serial by id.
     * <strong>Simple example:</strong><br />
     * http://endpoint/api/serials/data <br>.
     *
     * @ApiDoc(
     * resource = true,
     * description = "put Serial by id",
     * authentication=true,
     *  parameters={
     *
     *  },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Bad request"
     * },
     * section="Serials"
     * )
     *
     * @RestView()
     *
     * @throws NotFoundHttpException when not exist
     *
     * @return Response|View
     *
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
     */
    public function putSerialAction()
    {
        try {
            /** @var Serial $model */
            $model = $this->objectManager->startProcessingEntity(
                Serial::class,
                'request',
                [Serial::GROUP_PUT]
            );
            $this->serialsRepository->save($model);

            return $this->createSuccessResponse(
                $model
            );
        } catch (ValidatorException $e) {
            $view = $this->view($e->getConstraintViolatinosList(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $view = $this->view((array)$e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    /**
     * post Serial by id.
     * <strong>Simple example:</strong><br />
     * http://endpoint/api/serials/data <br>.
     *
     * @ApiDoc(
     * resource = true,
     * description = "post Serial by id",
     * authentication=true,
     *  parameters={
     *
     *  },
     * statusCodes = {
     *      200 = "Returned when successful",
     *      400 = "Bad request"
     * },
     * section="Serials"
     * )
     *
     * @RestView()
     *
     * @throws NotFoundHttpException when not exist
     *
     * @return Response|View
     *
     * @IsGranted({"ROLE_ADMIN", "ROLE_USER"})
     */
    public function postSerialAction()
    {
        try {
            /** @var Serial $model */
            $model = $this->objectManager->startProcessingEntity(
                Serial::class,
                'request',
                [Serial::GROUP_POST]
            );
            $this->serialsRepository->save($model);

            return $this->createSuccessResponse(
                $model
            );
        } catch (ValidatorException $e) {
            $view = $this->view($e->getConstraintViolatinosList(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $view = $this->view((array)$e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
