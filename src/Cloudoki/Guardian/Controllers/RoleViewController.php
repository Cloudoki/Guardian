<?php

namespace Cloudoki\Guardian\Controllers;

use Cloudoki\Guardian\Controllers\BaseController;

class RoleViewController extends BaseController
{
    /**
     *  Validation Rules
     *  Based on Laravel Validation
     */
    protected static $indexRules =
    [
    ];

    /**
     *  RESTful actions
     */

    /**
     *  Get Role
     *
     *  @return array
     *
     * @SWG\Get(
     *     path="/role",
     *     description="Returns a list of roles",
     *     operationId="api.role.index",
     *     produces={"application/json"},
     *     tags={"role"},
     *     @SWG\Response(response=200, description="Role response."),
     *     @SWG\Response(response=403, description="Forbidden action.")
     * )
     */
    public function index()
    {
        // Request Foreground Job
        $response = self::restDispatch(
            'index',
            'Cloudoki\Guardian\Controllers\RoleController',
            [],
            self::$indexRules
        );

        return $response;
    }

}
