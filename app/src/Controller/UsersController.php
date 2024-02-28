<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Security;
use Cake\View\JsonView;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'index', 'view']);
    }

    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->viewBuilder()->setOption('serialize', ['users']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();
            $user = $userIdentity->getOriginalData();
            $user->token = $this->generateToken();
            $user = $this->Users->save($user);
            $user = $this->Users->get($user->id);
            $message = 'login successfully.';
            $this->set([
                'status' => "success",
                'data' => ['user' => $user],
                'message' => $message
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data', 'message']);
        }
    }
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = null;
            $user = $this->Users->save($user);

            $message = 'Logout successfully.';
            $this->set([
                'status' => "success",
                'message' => $message
            ]);
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
        }
    }

    private function generateToken(int $length = 36)
    {
        $token = base64_encode(Security::randomBytes($length));
        $token_generate = preg_replace('/[^A-Za-z0-9]/', '', $token);
        return $token_generate;
    }
}
