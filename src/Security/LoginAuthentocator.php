<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class LoginAuthentocator implements AuthenticationEntryPointInterface
{
    /**
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return Response|void
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $content = json_decode($request->getContent(),false);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {

    }
}