<?php

namespace AppBundle\Controller;

use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API controller.
 *
 * @Route("/api")
 */
class APIController extends Controller
{
    /**
     * @Route(path="/download/{path}/{name}", name="api_file_fetch",methods={"GET"})
     * @param $name
     * @param $path
     * @return BinaryFileResponse
     */
    public function download($name,$path): BinaryFileResponse
    {
        return new BinaryFileResponse($path. '/' .$name);
    }
    /**
     * @Route(path="/upload/{path}", name="api_file_upload",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request, $path): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $uuid = Uuid::uuid1();
            if (!empty($request->files)) $request->files->get('photo_association')->move($path, $uuid);
            else throw new HttpException(500, 'Caught exception: No file to upload');
            return new JsonResponse($uuid->jsonSerialize(),Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse('Failed to upload',Response::HTTP_BAD_REQUEST);
    }
}
