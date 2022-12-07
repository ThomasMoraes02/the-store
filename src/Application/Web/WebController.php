<?php 
namespace TheStore\Application\Web;

use TheStore\Application\Web\Controllers\ControllerOperation;
use Throwable;

class WebController
{
    use HttpHelper;

    private ControllerOperation $controller;

    public function __construct(ControllerOperation $controller)
    {
        $this->controller = $controller;
    }

    public function handle(array $request)
    {
        try {
            $missingParams = WebController::getMissingParams($request, $this->controller->requiredParams);

            if(!empty($missingParams)) {
                return $this->badRequest($missingParams);
            }

            return $this->controller->execute($request);
        } catch(Throwable $e) {
            return $this->serverError($e->getMessage());
        }
    }

    /**
     * Verifica se todos os campos obrigatórios foram preenchidos
     *
     * @param array $request
     * @param array $requiredParams
     * @return void
     */
    public static function getMissingParams(array $request, array $requiredParams): array
    {
        $missingParams = [];

        for ($i=0; $i < count($requiredParams); $i++) { 
            if(!in_array($requiredParams[$i], array_keys($request)) || empty($request[$requiredParams[$i]])) {
                $missingParams[] = $requiredParams[$i];
            }
        }
    
        return $missingParams;
    }
}