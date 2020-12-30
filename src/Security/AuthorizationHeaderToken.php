<?php

declare(strict_types=1);

namespace App\Security;

use App\Exceptions\Security\TokenExtractionError;
use App\Security\Interfaces\TokenExtractor;
use Symfony\Component\HttpFoundation\Request;

final class AuthorizationHeaderToken implements TokenExtractor
{
    private string $prefix;
    private string $name;

    /**
     * @param string $prefix
     * @param string $name
     */
    public function __construct(string $prefix = 'Bearer', string $name = 'Authorization')
    {
        $this->prefix = $prefix;
        $this->name = $name;
    }

    /**
     * @param Request $request
     * @return bool|string|null
     * @throws TokenExtractionError
     */
    public function extract(Request $request): string
    {
        if (!$request->headers->has($this->name)) {
            throw new TokenExtractionError(sprintf("Header $this->name not found in request."));
        }

        $authorizationHeader = $request->headers->get($this->name);

        if (empty($this->prefix)) {
            return $authorizationHeader;
        }

        $headerParts = explode(' ', $authorizationHeader);

        if (!(2 === count($headerParts) && 0 === strcasecmp($headerParts[0], $this->prefix))) {
            throw new TokenExtractionError("Prefix '{$this->prefix}' not found in header '{$this->name}'.");
        }

        return $headerParts[1];
    }
}