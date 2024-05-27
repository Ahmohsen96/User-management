<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * @group User management
 *
 * APIs for managing users
 */
class UserController extends BaseController
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users
     *
     * @response 200 scenario="success" [{"id":1,"name":"John Doe","email":"johndoe@example.com"}]
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->userRepository->getAllUsers());
    }

    /**
     * Create a new user
     *
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email of the user. Example: johndoe@example.com
     * @bodyParam password string required The password of the user. Example: secret
     * @response 201 scenario="success" {"id":1,"name":"John Doe","email":"johndoe@example.com"}
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userRepository->createUser($request->all());
        return response()->json($user, 201);
    }

    /**
     * Get a user by ID
     *
     * @urlParam id int required The ID of the user. Example: 1
     * @response 200 scenario="success" {"id":1,"name":"John Doe","email":"johndoe@example.com"}
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->userRepository->getUserById($id));
    }

    /**
     * Update a user by ID
     *
     * @urlParam id int required The ID of the user. Example: 1
     * @bodyParam name string The name of the user. Example: John Doe
     * @bodyParam email string The email of the user. Example: johndoe@example.com
     * @bodyParam password string The password of the user. Example: secret
     * @response 200 scenario="success" {"id":1,"name":"John Doe","email":"johndoe@example.com"}
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = $this->userRepository->updateUser($id, $request->all());
        return response()->json($user);
    }

    /**
     * Delete a user by ID
     *
     * @urlParam id int required The ID of the user. Example: 1
     * @response 204 scenario="success" null
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->userRepository->deleteUser($id);
        return response()->json([
            'message' => 'Deleted successful'
        ], 200);
    }
}


