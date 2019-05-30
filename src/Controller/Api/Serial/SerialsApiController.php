<?php

namespace App\Controller\Api\Serial;

use App\Controller\Api\AbstractRestController;
use App\Repository\SerialRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View as RestView;
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
     * http://endpoint/partner/apps/{id}/data <br>.
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
     */
    public function getSerialsDataAction()
    {
        try {
            return $this->createSuccessResponse(
                $this->serialsRepository->findAll()
            );
        } catch (\Exception $e) {
            $view = $this->view((array)$e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }
}
