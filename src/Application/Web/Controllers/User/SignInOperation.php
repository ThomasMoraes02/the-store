<?php 
namespace TheStore\Application\Web\Controllers\User;

use Throwable;
use TheStore\Application\UseCases\UseCase;
use TheStore\Application\Helpers\HttpHelper;
use TheStore\Application\Web\Controllers\ControllerOperation;

class SignInOperation implements ControllerOperation
{
    use HttpHelper;

    public array $requiredParams = ['email', 'password'];
    
    private UseCase $useCase;

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