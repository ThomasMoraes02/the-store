<?php 
namespace TheStore\Application\Middleware;

use TheStore\Application\Authentication\TokenManager;
use TheStore\Application\Web\HttpHelper;
use Throwable;

class Authentication implements Middleware
{
    use HttpHelper;

    private TokenManager $tokenManager;

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function handle(string $request)
    {
        try {
            $decoded = $this->tokenManager->decode($request);

            if($decoded == false) {
                return $this->forbidden('Invalid Token');
            }
            return $this->ok(true);
        } catch(Throwable $e) {
            return $this->serverError($e->getMessage());
        }
    }
}