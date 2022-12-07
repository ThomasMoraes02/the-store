<?php 
namespace TheStore\Application\Web\Controllers\User;

use TheStore\Application\Web\HttpHelper;
use TheStore\Application\UseCases\UseCase;
use TheStore\Application\Web\Controllers\ControllerOperation;
use Throwable;

class SignUpOperation implements ControllerOperation
{
    use HttpHelper;

    public array $requiredParams = ['name', 'email', 'cpf', 'phone', 'address', 'password'];

    private UseCase $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function execute(array $request)
    {
        try {
            $response = $this->useCase->perform($request);

            if($response['email'] == $request['email']) {
                return $this->created($response);
            }
        } catch(Throwable $e) {
            return $this->forbidden($e->getMessage());
        }
        return $this->badRequest($request);
    }
}