<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\v1\UserRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findById(string $id): JsonResponse
    {
        return $this->userRepository->findById($id);
    }

    public function findAll(Request $request) : JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
        ]);

        return $this->userRepository->findAll($validatedData);
    }

    public function findWhere(Request $request) : JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
        ]);
        return $this->userRepository->findWhere($validatedData);
    }

    public function create(Request $request) : JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        return $this->userRepository->create($validatedData);
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
            'password' => 'nullable|string|min:8',
        ]);

        if ($request->has('password') && $request->password !== null) {
            $validatedData['password'] = bcrypt($request->password);
        }

        return $this->userRepository->update($id, $validatedData);
    }

    public function delete(string $id) : JsonResponse
    {
        return $this->userRepository->delete($id);
    }
}
