<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\Tasks;
use frontend\models\FormSearchTask;
use Yii;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $filterCategories = null;

        $model = new FormSearchTask();
        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());
            $filterCategories = is_array($model->categories) ? array_map('intval', $model->categories) : [];
        }

        $query = Tasks::find()
        ->where(['status' => 'new'])
        ->joinWith('category')
        ->joinWith('city')
        ->orderBy(['created_at' => SORT_DESC]);

        if ($filterCategories) {
            $query->andWhere(['category_id' => $filterCategories]);
        }

        if ($model->myCity) {
            // TODO: get city_id from user (visitor) profile
            // temporary myCity id is static = 1
            $query->andWhere(['city_id' => 1]);
        }

        if ($model->remoteWork) {
            $query->andWhere(['is', 'city_id', null]);
        }

        switch ($model->period) {
            case 'day':
                $query->andWhere(['>', 'created_at', new Expression('CURRENT_TIMESTAMP() - INTERVAL 1 DAY') ]);
                break;
            case 'week':
                $query->andWhere(['>', 'created_at', new Expression('CURRENT_TIMESTAMP() - INTERVAL 7 DAY') ]);
                break;
            case 'month':
                $query->andWhere(['>', 'created_at', new Expression('CURRENT_TIMESTAMP() - INTERVAL 30 DAY') ]);
                break;
        }

        if ($model->searchName) {
            $query->andWhere("MATCH(tasks.name) AGAINST ('$model->searchName')");
        }

        $tasks = $query->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'model' => $model,
        ]);
    }

    public function actionShow($id)
    {
        $task = Tasks::find()
            ->where(['tasks.id' => $id])
            ->joinWith('category')
            ->joinWith('ownerUser')
            ->one();

        if (!$task) {
            throw new NotFoundHttpException;
        }

        return $this->render('show', [
            'task' => $task,
        ]);
    }
}
