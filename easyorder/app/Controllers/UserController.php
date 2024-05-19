<?php namespace App\Controllers;

use CodeIgniter\Controller;

class UserController extends BaseController
{
    public function __construct()
    {
        // Load the URL helper, it will be useful in the next steps
        // Adding this within the __construct() function will make it 
        // available to all views in the UserController
        helper('url'); 

        $this->session = session();
    }

    /**
     * Display the authentication page.
     */
   public function auth()
    {
        return view('auth');
    }

    /**
     * Attempt user authentication (login or signup).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function attemptAuth()
    {
        $action = $this->request->getVar('action');
        if ($action === 'login') {
            return $this->attemptLogin();
        } elseif ($action === 'signup') {
            return $this->attemptSignup();
        }
        return redirect()->back()->with('error', 'Invalid action');
    }

    /**
     * Attempt user login.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    private function attemptLogin()
    {
        $model = new \App\Models\UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = $model->where('email', $email)->first(); //Using where function to prevent SQL injection

        if ($user && password_verify($password, $user['password_hash'])) {
            session()->set('user_id', $user['user_id']);
            session()->setFlashdata('success', 'Login successful.');
            return redirect()->to(base_url('/'));
        } else {
            session()->setFlashdata('error', 'Invalid credentials. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Attempt user signup.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    private function attemptSignup()
    {
        $model = new \App\Models\UserModel();
        //Using password hash for security concern.
        $data = [
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'restaurant_name' => $this->request->getPost('restaurant_name'),
            'location' => $this->request->getPost('location'),
            'city' => $this->request->getPost('city')
        ];

        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Signup successful. Please login.');
            return redirect()->to(base_url('/auth'));
        } else {
            session()->setFlashdata('error', 'Signup failed. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Logout the user.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }

    /**
     * Display the admin page with user management.
     */
    public function admin()
    {

        $user_id = session()->get('user_id');
        if (!$user_id) {
            return redirect()->to('/auth');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($user_id);
        //Return to homepage is user is not admin.
        if ($user['role'] !== 'admin') {
            session()->setFlashdata('alert', 'You do not have permission to access this page.');
            return redirect()->to(base_url('/'));
        }

        $search = $this->request->getGet('search');

        if (!empty($search)) {
            $users = $userModel->like('email', $search)
                ->orLike('restaurant_name', $search)
                ->orLike('location', $search)
                ->orLike('city', $search)
                ->findAll();
        } else {
            $users = $userModel->findAll();
        }

        $data['users'] = $users;
        $data['search'] = $search;

        return view('admin', $data);
    }

    /**
     * Display the edit user page.
     *
     * @param int $user_id The user ID to edit.
     * @return void
     */
    public function editUser($user_id)
    {
        $session_user_id = session()->get('user_id');
        if (!$session_user_id) {
            return redirect()->back()->with('error', 'Please log in first!');
        }

        $userModel = new \App\Models\UserModel();
        $session_user = $userModel->find($session_user_id);

        if ($session_user['role'] !== 'admin') {
            return redirect()->back()->with('error', 'You are not admin!');
        }

        $user = $userModel->find($user_id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data['user'] = $user;

        return view('edituser', $data);
    }

    /**
     * Update a user's information.
     *
     * @param int $user_id The user ID to update.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function updateUser($user_id)
    {
        $session_user_id = session()->get('user_id');
        if (!$session_user_id) {
            return redirect()->back()->with('error', 'Please log in first!');
        }

        $userModel = new \App\Models\UserModel();
        $session_user = $userModel->find($session_user_id);

        if ($session_user['role'] !== 'admin') {
            return redirect()->back()->with('error', 'You are not admin!');
        }

        $user = $userModel->find($user_id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'restaurant_name' => $this->request->getPost('restaurant_name'),
            'location' => $this->request->getPost('location'),
            'city' => $this->request->getPost('city'),
            'role' => $this->request->getPost('role')
        ];

        $userModel->update($user_id, $data);

        session()->setFlashdata('success', 'User updated successfully.');

        return redirect()->to('/admin');
    }

    /**
     * Delete a user.
     *
     * @param int $user_id The user ID to delete.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function deleteUser($user_id)
    {
        $session_user_id = session()->get('user_id');
        if (!$session_user_id) {
            return redirect()->to('/auth');
        }

        $userModel = new \App\Models\UserModel();
        $session_user = $userModel->find($session_user_id);

        if ($session_user['role'] !== 'admin') {
            return redirect()->back()->with('error', 'You are not admin!');
        }

        $user = $userModel->find($user_id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $userModel->delete($user_id);

        session()->setFlashdata('success', 'User deleted successfully.');

        return redirect()->to('/admin');
    }
}