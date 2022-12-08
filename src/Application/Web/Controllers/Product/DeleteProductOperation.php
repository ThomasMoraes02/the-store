<?php 
namespace TheStore\Application\Web\Controllers\Product;

use Throwable;
use TheStore\Application\Helpers\HttpHelper;
use TheStore\Application\UseCases\UseCase;
use TheStore\Application\Web\Controllers\ControllerOperation;

class DeleteProductOperation implements ControllerOperation
{
    use HttpHelper;

    public array $requiredParams = ["id"];

    private UseCase $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function execute(array $request)
    {
        try {
            $response = $this->useCase->perform($request);
            return $this->ok($response);
        } catch(Throwable $e) {
            return $this->forbidden($e->getMessage());
        }
        return $this->badRequest($request);
    }
}