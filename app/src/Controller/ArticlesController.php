<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    // list all articles
    public function index()
    {
        $articles = $this->paginate($this->Articles, [
            'contain' => [
                'Users' => function ($q) {
                    return $q->select(['Users.email']);
                }
            ],
        ]);
        $this->set([
            'status' => "success.",
            'data' => $articles
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    // view article detail
    public function view ($id) {
        $article_detail = $this->Articles->get($id, [
            'contain' => [
                'Users' => function ($q) {
                return $q->select(['Users.email']);
                }
            ],
        ]);
        $this->set([
            'status' => "success.",
            'data' => $article_detail
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    // create article detail
    public function add() {
        $articleDetail = $this->Articles->newEntity($this->request->getData());
        $article->user_id = $this->Authentication->getIdentity()->id;

        if ($this->Articles->save($articleDetail)) {
            $status = "success";
            $message = 'Add article successfully.';
            $this->set([
                'status' => $status,
                'data' => $article,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data', 'message']);
        } else {
            $status = "error";
            $message = 'Add article fail!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
        }
       
    }

    // update article detail
    public function edit($id = null) {
        $articleDetail = $this->Articles->get($id);
        $articleUser = $this->Authentication->getIdentity()->id;
        if ($articleDetail->user_id != $articleUser) {
            $status = "error";
            $message = 'You do not have permission to update this article!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
        } else {
            $article = $this->Articles->patchEntity($articleDetail, $this->request->getData());
            $updateArticle = $this->Articles->save($article);
            if ($this->Articles->save($article)) {
                $status = "success";
                $message = 'update article successfully.';
                $this->set([
                    'status' => $status,
                    'data' => $article,
                    'message' => $message,
                ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data', 'message']);
            } else {
                $status = "error";
                $message = 'update article fail!';
                $this->set([
                    'status' => $status,
                    'message' => $message,
                ]);
                $this->viewBuilder()->setOption('serialize', ['status', 'message']);
            }
        }
       
    }

    // delete article detail
    public function delete($id = null) {

    }
    
    // like article detail
    public function like($id = null) {

    }
 }