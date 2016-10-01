<?php

namespace Cloudoki\Guardian\Controllers;

use Cloudoki\Guardian\Controllers\BaseController;

class RolegroupViewController extends BaseController
{
    /**
     *  Validation Rules
     *  Based on Laravel Validation
     */
    protected static $indexRules =
    [
        'ids'    =>  'regex:[\d,]',
        'q'      =>  ''
    ];

    protected static $getRules =
    [
        'id'    =>  'required|integer'
    ];

    protected static $updateRules =
    [
        'id'           =>  'required|integer',
        'name'         =>  'min:1|max:250',
        'description'  =>  'min:1|max:1000',
        'roles'        =>  'sometimes|array|max:100',
        'roles.*'      =>  'required|integer'
    ];

    protected static $postRules =
    [
        'name'         =>  'required|min:1|max:250',
        'description'  =>  'required|min:1|max:1000',
        'roles'        =>  'array|max:100'
    ];

    /**
     *  RESTful actions
     */

    /**
     *  Get Rolegroups
     *
     *  @return array
     *
     * @SWG\Get(
     *     path="/rolegroups",
     *     description="Returns a list of rolegroups",
     *     operationId="api.rolegroups.index",
     *     produces={"application/json"},
     *     tags={"rolegroups"},
     *     @SWG\Response(response=200, description="Rolegroups response."),
     *     @SWG\Response(response=403, description="Forbidden action.")
     * )
     */
    public function index()
    {
        // Request Foreground Job
        $response = self::restDispatch(
            'index',
            'Cloudoki\Guardian\Controllers\RolegroupController',
            [],
            self::$indexRules
        );

        return $response;
    }

    /**
     * Get Rolegroup
     *
     * @return object
     *
     * @SWG\Get(
     *     path="/rolegroups/{id}",
     *     description="Returns a rolegroup",
     *     operationId="api.rolegroups.show",
     *     produces={"application/json"},
     *     tags={"rolegroups"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of the rolegroup that needs to be fetched",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(response=200, description="Rolegroup response."),
     *     @SWG\Response(response=403, description="Forbidden action."),
     *     @SWG\Response(response=404, description="Rolegroup not Found.")
     * )
     *
     */
    public function show($id)
    {

        $input = ['id' => $id];

        // Request Foreground Job
        $response = self::restDispatch(
            'show',
            'Cloudoki\Guardian\Controllers\RolegroupController',
            $input,
            self::$getRules
        );

        return $response;
    }

    /**
     *  Post Rolegroup
     *
     *  @return object
     *
     *  @SWG\Definition(
     *      definition="Rolegroup",
     *      allOf={
     *          @SWG\Schema(required={"name"}, @SWG\Property(property="email", type="string")),
     *          @SWG\Schema(required={"description"}, @SWG\Property(property="firstname", type="string")),
     *      },
     *  )
     *
     *  @SWG\Post(
     *     path="/rolegroups",
     *     description="Creates a new Rolegroup",
     *     operationId="api.rolegroups.store",
     *     produces={"application/json"},
     *     tags={"rolegroups"},
     *     @SWG\Parameter(
     *         name="rolegroup",
     *         in="body",
     *         description="The rolegroup info",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Rolegroup"),
     *     ),
     *     @SWG\Response(response=200, description="Rolegroup response."),
     *     @SWG\Response(response=403, description="Forbidden action."),
     *     @SWG\Response(response=500, description="Internal Server Error")
     * )
     *
     */
    public function store()
    {
        $input = null;
        $rules = self::$postRules;

        // Request Foreground Job
        $response = self::restDispatch(
            'store',
            'Cloudoki\Guardian\Controllers\RolegroupController',
            $input,
            self::$postRules
        );

        return $response;
    }

    /**
     * Update Rolegroup
     *
     * @return object
     *
     * @SWG\Definition(
     *     definition="UpdateRolegroup",
     *     allOf={
     *         @SWG\Schema(@SWG\Property(property="email", type="string")),
     *         @SWG\Schema(@SWG\Property(property="firstname", type="string")),
     *         @SWG\Schema(@SWG\Property(property="lastnam", type="string")),
     *         @SWG\Schema(@SWG\Property(property="avatar", type="string")),
     *         @SWG\Schema(@SWG\Property(property="language", type="string", enum={"EN", "NL"})),
     *     },
     * )
     *
     * @SWG\Patch(
     *     path="/rolegroups/{id}",
     *     description="Updates a rolegroup",
     *     operationId="api.rolegroups.update",
     *     produces={"application/json"},
     *     tags={"rolegroups"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of the rolegroup that needs to be updated",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="rolegroup",
     *         in="body",
     *         description="The data that needs to be updated",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/UpdateRolegroup"),
     *     ),
     *     @SWG\Response(response=200, description="Rolegroup response."),
     *     @SWG\Response(response=403, description="Forbidden action."),
     *     @SWG\Response(response=404, description="Rolegroup not Found"),
     *     @SWG\Response(response=500, description="Internal Server Error")
     * )
     *
     */
    public function update($id)
    {
        $input = ['id'=> $id];

        // Request Foreground Job
        $response = self::restDispatch(
            'update',
            'Cloudoki\Guardian\Controllers\RolegroupController',
            $input,
            self::$updateRules
        );

        return $response;
    }

    /**
     * Delete Rolegroups
     *
     * @return boolean
     *     *
     * @SWG\Delete(
     *     path="/rolegroups/{id}",
     *     description="Deletes a rolegroup",
     *     operationId="api.rolegroups.delete",
     *     produces={"application/json"},
     *     tags={"rolegroups"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of the rolegroup to be deleted",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(response=200, description="Rolegroup response."),
     *     @SWG\Response(response=403, description="Forbidden action."),
     *     @SWG\Response(response=404, description="Rolegroup not Found"),
     *     @SWG\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy($id)
    {
        $input = ['id' => $id];

        // Request Foreground Job
        $response = self::restDispatch(
            'destroy',
            'Cloudoki\Guardian\Controllers\RolegroupController',
            $input,
            self::$getRules
        );

        return $response;
    }
}
