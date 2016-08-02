<?php

namespace app\models;

class UserIdentity extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $status;

    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/

    public static function findIdentity($id)
    {
        $user = User::find()->where(['id'=>$id])->one();
        if($user){
            $userStatic = [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'authKey' => 'key-'.$user->id,
                'accessToken' => 'token-'.$user->id
            ];
            return new static($userStatic);
        }
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        ##没有用到

        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }*/

        return null;
    }

    public static function findByUsername($username)
    {
        $user = User::find()->where(['username'=>$username])->one();
        if($user){
            $userStatic = [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'authKey' => 'key-'.$user->id,
                'accessToken' => 'token-'.$user->id,
                'status' => $user->status
            ];
            return new static($userStatic);
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }


    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

}
