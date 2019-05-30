<?php

namespace App\Controller\Api\Serial;

use App\Controller\Api\AbstractRestController;
use App\Entity\Serial;
use App\Repository\SerialRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View as RestView;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SerialsApiController extends AbstractRestController
{
    /**
     * @var SerialRepository
     */
    private $serialsRepository;

    /**
     * SerialsApiController constructor.
     * @param SerialRepository $serialsRepository
     */
    public function __construct(SerialRepository $serialsRepository)
    {
        $this->serialsRepository = $serialsRepository;
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
}
