<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{

    private $apiTokenRepository;

    public function __construct(ApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function supports(Request $request)
    {
        return $request->headers->has('Authorization') && 0 == strpos($request->headers->get('Authorization'), 'Bearer ');
    }

    public function getCredentials(Request $request)
    {
        $authorization = $request->headers->get('Authorization');
        return substr($authorization, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = $this->apiTokenRepository->findOneBy([
            'token' => $credentials
        ]);
        if (!$token) {
            throw new CustomUserMessageAuthenticationException('Invalid API token');
        }
        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException('Token Expired');
        }
        return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // nie ma hasła więc zwracamy true
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw  new \Exception('not used: entry_point from other authorization is used');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
