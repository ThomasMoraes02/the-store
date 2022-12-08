<?php 
namespace TheStore\Application\Web\Controllers\Product;

use TheStore\Application\UseCases\UseCase;
use TheStore\Application\Web\Controllers\ControllerOperation;
use TheStore\Application\Helpers\HttpHelper;
use Throwable;

class CreateProductOperation implements ControllerOperation
{
    use HttpHelper;

    public array $requiredParams = ["title", "price", "amount", "description", "category"];

    private UseCase $useCase;

    public function __construct(UseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function execute(array $request)
    {
        try {
            $response = $this->useCase->perform($request);
            return $this->created($response);
        } catch(Throwable $e) {
            return $this->forbidden($e->getMessage());
        }
        return $this->badRequest($request);
    }
}