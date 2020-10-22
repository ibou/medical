<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use OpenApi\Annotations as OA;

/**
 * Class ApiSecurityController
 * @package App\Controller
 */
class ApiSecurityController extends AbstractController
{
    /**
     * @Route("/authentication_token", name="login", methods={"POST"})
     *
     * @OA\PathItem(
     *     path="/authentication_token",
     *      @OA\Post(
     *     tags={"Authentication"},
     *     security={},
     * @OA\Response(
     *     response="200",
     *     description="JWT token used to authenticate yourself in subsequent api calls"
     * ),
     *
     * @OA\RequestBody(
     *     description="email and password",
     *     @OA\MediaType(
     *      mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(type="string", property="email"),
     *              @OA\Property(type="string", property="password"),
     *          ),
     *     ),
     * ),
     *     ),
     *     )
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function login(Request $request)
    {
        if ($request->headers->get('Content-Type') !== 'application/json') {
            throw new BadCredentialsException("Request body is not application/json encoded");
        }

        $user = $this->getUser();

        return $this->json(
            [
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
            ]
        );
    }
}