<?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use Codeception\Specify;

class LoginFormTest extends TestCase
{
    use Specify;

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        $this->specify('member should not be able to login, when there is no identity', function () use ($model) {
            expect('model should not login member', $model->login())->false();
            expect('member should not be logged in', Yii::$app->user->isGuest)->true();
        });
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'username' => 'demo',
            'password' => 'wrong_password',
        ]);

        $this->specify('member should not be able to login with wrong password', function () use ($model) {
            expect('model should not login member', $model->login())->false();
            expect('error message should be set', $model->errors)->hasKey('password');
            expect('member should not be logged in', Yii::$app->user->isGuest)->true();
        });
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => 'demo',
            'password' => 'demo',
        ]);

        $this->specify('member should be able to login with correct credentials', function () use ($model) {
            expect('model should login member', $model->login())->true();
            expect('error message should not be set', $model->errors)->hasntKey('password');
            expect('member should be logged in', Yii::$app->user->isGuest)->false();
        });
    }

}
