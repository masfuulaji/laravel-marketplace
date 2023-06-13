<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\v1\AdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminRepository;
    public function __construct(AdminRepository $adminRepository){
        $this->adminRepository = $adminRepository;
    }

    public function findById($id){
        return $this->adminRepository->findById($id);
    }

    public function findAll(Request $request){
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
        ]);
        return $this->adminRepository->findAll($validatedData);
    }

    public function findWhere(Request $request){
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
        ]);
        return $this->adminRepository->findWhere($validatedData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|string|min:8',
        ]);
        return $this->adminRepository->create($validatedData);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
            'password' => 'nullable|string|min:8',
        ]);
        if ($request->has('password') && $request->password !== null) {
            $validatedData['password'] = bcrypt($request->password);
        }
        return $this->adminRepository->update($validatedData, $id);
    }

    public function delete($id){
        return $this->adminRepository->delete($id);
    }
}
