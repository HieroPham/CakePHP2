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
        ])->toArray();
        foreach ($articles as $key=>$art) {
            $count_like = $this->Articles->Likes->find('all')->where([
                'article_id' => $art->id,
            ])->count();
            $articles[$key]['like_count'] = $count_like ? $count_like : 0;
        }
        $this->set([
            'status' => "success.",
            'data' => $articles
        ]);
        $this->viewBuilder()->setOption('serialize', ['status', 'data']);
    }

    // view article detail
    public function view ($id) {
        $articleDetail = $this->Articles->find()->where(['id' => $id])->first();
        if (!$articleDetail) {
            $status = 'error';
            $message = 'article not found!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
        } else {
            $article_detail = $this->Articles->get($id, [
                'contain' => [
                    'Users' => function ($q) {
                    return $q->select(['Users.email']);
                    },
                ],
            ]);
            $like_count = $this->Articles->Likes->find('all')->where([
                'article_id' => $articleDetail->id,
            ])->count();
            $article_detail->like_count = $like_count ? $like_count : 0;
            $this->set([
                'status' => "success.",
                'data' => $article_detail
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data']);
        }
    }

    // create article detail
    public function add() {
        $articleData = $this->Articles->newEntity($this->request->getData());
        $articleData->user_id = $this->Authentication->getIdentity()->id;
        $newArticle = $this->Articles->save($articleData);
        if ($newArticle) {
            $status = 'success';
            $message = 'Add article successfully.';
            $this->set([
                'status' => $status,
                'data' => $newArticle,
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
        $articleDetail = $this->Articles->find()->where(['id' => $id])->first();
        $articleUser = $this->Authentication->getIdentity()->id;
        if (!$articleDetail) {
            $status = 'error';
            $message = 'article not found!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
            return;
        }
        if ($articleDetail->user_id != $articleUser) {
            $status = 'error';
            $message = 'You do not have permission to update this article!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
        } else {
            $article = $this->Articles->patchEntity($articleDetail, $this->request->getData());
            $updateArticle = $this->Articles->save($article);
            if ($updateArticle) {
                $status = 'success';
                $message = 'update article successfully.';
                $this->set([
                    'status' => $status,
                    'data' => $article,
                    'message' => $message,
                ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data', 'message']);
            } else {
                $status = 'error';
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
        $articleDetail = $this->Articles->find()->where(['id' => $id])->first();
        if (!$articleDetail) {
            $status = 'error';
            $message = 'article not found!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
            return;
        } 
        $articleUser = $this->Authentication->getIdentity()->id;
        if ($articleDetail->user_id != $articleUser) {
            $status = 'error';
            $message = 'You do not have permission to delete this article!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
        } else {
            $deleteArticle = $this->Articles->delete($articleDetail);
            if ($deleteArticle) {
                $status = 'success';
                $message = 'delete article successfully.';
                $this->set([
                    'status' => $status,
                    'message' => $message,
                ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data', 'message']);
            } else {
                $status = 'error';
                $message = 'delete article fail!';
                $this->set([
                    'status' => $status,
                    'message' => $message,
                ]);
                $this->viewBuilder()->setOption('serialize', ['status', 'message']);
            }
        }
    }
    
    // like article detail
    public function like($id = null) {
        $articleDetail = $this->Articles->find()->where(['id' => $id])->first();
        $articleUserId = $this->Authentication->getIdentity()->id;
        if (!$articleDetail) {
            $status = 'error';
            $message = 'article not found!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'message']);
            return;
        }
        $liked = $this->Articles->Likes->find('all')->where([
            'article_id' => $articleDetail->id,
            'user_id' => $articleUserId,
        ])->first();

        if ($liked) {
            $status = 'error';
            $message = 'you already liked this article!';
            $this->set([
                'status' => $status,
                'message' => $message,
            ]);
            
            $this->viewBuilder()->setOption('serialize', ['message']);
            return;
        }
        $like = $this->Articles->Likes->newEntity([
            'article_id' => $articleDetail->id,
            'user_id' => $articleUserId,
        ]);
        $newLike = $this->Articles->Likes->save($like);
        if ($newLike) {
                $status = 'success';
                $message = 'like article successfully.';
                $this->set([
                    'status' => $status,
                    'message' => $message,
                ]);
            $this->viewBuilder()->setOption('serialize', ['status', 'data', 'message']);
        }
    }
 }