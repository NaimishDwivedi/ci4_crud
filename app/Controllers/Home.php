<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Home extends BaseController
{
    public function index(): string
    {
        $studentModel = model(StudentModel::class);

        $data['students'] = $studentModel->paginate(10);

        $data['pager'] = $studentModel->pager;

        return view('student_detail', $data);
    }


    public function create()
    {
        $data = $this->request->getPost([
            'name',
            'email',
            'phone',
            'course'
        ]);

        if (
            !$this->validateData($data, [
                'name' => 'required|max_length[50]|min_length[3]',
                'email' => 'required|max_length[50]|min_length[10]|valid_email',
                'phone' => 'required|max_length[12]|min_length[10]',
                'course' => 'required|max_length[100]|min_length[2]',
            ])
        ) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $post = $this->validator->getValidated();

        $model = model(StudentModel::class);
        $id = $model->insert($post);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Student added successfully',
            'student' => [
                'id' => $id,
                'name' => $post['name'],
                'email' => $post['email'],
                'phone' => $post['phone'],
                'course' => $post['course']
            ]
        ]);
    }


    public function update()
    {
        $data = $this->request->getPost();

        if (
            !$this->validateData($data, [
                'name' => 'required|max_length[50]|min_length[3]',
                'email' => 'required|max_length[50]|min_length[10]|valid_email',
                'phone' => 'required|max_length[12]|min_length[10]',
                'course' => 'required|max_length[100]|min_length[2]',
            ])
        ) {
            return $this->response->setJSON(['status' => 'error']);
        }

        $model = model(StudentModel::class);
        $model->update($data['id'], $data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $model = model(StudentModel::class);

        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Student deleted successfully'
            ]);
        }
        return $this->response->setJSON(['status' => 'error']);
    }
}
