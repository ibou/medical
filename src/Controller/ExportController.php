<?php


namespace App\Controller;

use App\Service\FoldersExport;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class ExportController
 * @package App\Controller
 */
class ExportController
{

    private FoldersExport $foldersExport;

    /**
     * ExportController constructor.
     * @param FoldersExport $foldersExport
     */
    public function __construct(FoldersExport $foldersExport)
    {
        $this->foldersExport = $foldersExport;
    }


    /**
     * @Route("/api/dossiers/export", name="export_yml", methods={"GET"})
     * @OA\Info(title="oa title", version="1")
     *
     * @OA\PathItem(
     *     path="/api/dossiers/export",
     * @OA\Get(
     *     tags={"Export"},
     *
     * @OA\Response(
     *     response="200",
     *     description="return un zip contenant les dossiers des patients",
     * ),
     *  @OA\Parameter(
     *     name="id",
     *     in="query",
     *     @OA\Schema(
     *     type="integer",
     *      ),
     *     description="id user exple: 2",
     * ),
     *  @OA\Parameter(
     *     name="username",
     *     in="query",
     *     @OA\Schema(
     *     type="string",
     *      ),
     *     description="username user exple: idiallo",
     * ),
     * )
     * )
     * @param Request $request
     * @return BinaryFileResponse|JsonResponse
     */
    public function exportDossier(Request $request)
    {
        $id = $request->query->get('id');
        $username = $request->query->get('username');

        try {
            $filePath = $this->foldersExport->export(null, $id, $username);
            $response = new BinaryFileResponse($filePath);
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, "dossier_patient.zip");
        } catch (InvalidArgumentException $e) {
            $code = (($e->getCode() >= 400) && ($e->getCode() <= 417)) ? $e->getCode() : 500;

            return new JsonResponse(
                ["code" => $e->getCode(), "message" => $e->getMessage()],
                $code
            );
        }

        return $response;
    }

}