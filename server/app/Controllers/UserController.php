<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $UserModel = new \App\Models\UserModel();
        $data = $UserModel->findAll();

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Data retrieved successfully',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No data found',
                'data' => []
            ];
        }

        return $this->respond($response);
    }

    public function register()
    {
        $rules = [
            'email' => ['rules' => 'required'],
            'name' => ['rules' => 'required|'],
            'password' => ['rules' => 'required'],
            'phone' => ['rules' => 'required'],
            'address' => ['rules' => 'required'],

        ];


        if ($this->validate($rules)) {
            $model = new \App\Models\UserModel();
            $data = [
                'email'    => $this->request->getVar('email'),
                'name'    => $this->request->getVar('name'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'phone'    => $this->request->getVar('phone'),
                'address'    => $this->request->getVar('address'),
            ];
            $model->save($data);

            return $this->respond(['message' => 'Registered Successfully'], 200);
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response, 409);
        }
}

public function update($id = null)
{
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($id);
    if ($user) {
        $data = [
            'id' => $id,
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'phone' => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)

        ];
        $proses = $userModel->save($data);
        if ($proses) {
            $response = [
                'status' => 200,
                'messages' => 'Data berhasil diubah',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 402,
                'messages' => 'Gagal diubah',
            ];
        }
        return $this->respond($response);
    }
    return $this->failNotFound('Data tidak ditemukan');
}

// function untuk menghapus data
public function delete($id = null)
{
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($id);
    if ($user) {
        $proses = $userModel->delete($id);
        if ($proses) {
            $response = [
                'status' => 200,
                'messages' => 'Data berhasil dihapus',
            ];
        } else {
            $response = [
                'status' => 402,
                'messages' => 'Gagal menghapus data',
            ];
        }
        return $this->respond($response);
    } else {
        return $this->failNotFound('Data tidak ditemukan');
    }}
    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];
    
        if ($this->validate($rules)) {
            // Check if the user with the provided email and password exists in your database
            // Add your logic here
    
            // Example: Assume UserModel has a method named 'authenticate'
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $model = new \App\Models\UserModel();
    
            $user = $model->where('email', $email)->first();
    
            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                return $this->respond(['message' => 'Login Successful'], 200);
            } else {
                // Failed login
                return $this->fail(['message' => 'Invalid Email or Password'], 401);
            }
        } else {
            // Validation failed
            return $this->fail(['errors' => $this->validator->getErrors(), 'message' => 'Invalid Inputs'], 409);
        }
    }
    }