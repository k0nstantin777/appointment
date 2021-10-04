<?php

namespace App\Services\Entities\Visit;

use App\Services\BaseService;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Validator;

class ValidateVisitService extends BaseService
{
    public function __construct(private StoreRulesService $storeRulesService)
    {
    }

    public function getValidator(array $request) : Validator
    {
        return ValidatorFacade::make(
            $request,
            $this->storeRulesService->get($request),
        );
    }
}
