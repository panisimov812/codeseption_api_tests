<?php


namespace Tests\Api;    
use Tests\Support\ApiTester;
use Tests\Support\Helper\DataHelper;

class CreateUserCest 
{
  
    public function _before(ApiTester $I)
    { 
    }

    public function tryToTest(ApiTester $I)
    {
    }

    //tests
    public function verificationCode200ForCreatingClient(ApiTester $I)
    {      
        $data = new DataHelper();

        $I->sendPost('/user/create', [
          'username' => $data->getRandomTestUserName(),
          'email' => $data->getRandomTestEmail(),
          'password' => $data->getRandomTestPassword()
        ]);  
        $I->seeResponseCodeIs(200);
    }

     //tests
     public function verificationCode400ForCreatingClient(ApiTester $I)
     {      
         $userName = 'test';
         $email =  'email@mail.com';
         $password = 'password';

         $I->sendPost('/user/create', [
           'username' => $userName,
           'email' => $email,
           'password' => $password
         ]);
         $I->seeResponseCodeIs(400);
     }

     // tests
     public function verificationBodyMessageForAlreadyUsingName(ApiTester $I)
     {       
         $I->sendPost('/user/create', [
           'username' => 'test',
           'email' => 'test@test.ru',
           'password' => 'password'
         ]);
         $I->seeResponseCodeIs(400);
         $I->seeResponseIsJson();
         $I->seeResponseContainsJson([
          'message' => ['This username is taken. Try another.']
        ]);
     }

      // tests
      public function verificationBodyMessageForAlreadyUsingEmail(ApiTester $I)
      {      
          $data = new DataHelper();
          
          $I->sendPost('/user/create', [
            'username' => $data->getRandomTestUserName(),
            'email' => 'test@test.ru',
            'password' => 'password'
          ]);
          $I->seeResponseCodeIs(400);
          $I->seeResponseIsJson();
          $I->seeResponseContainsJson([
           'message' => ['Email already exists']
         ]);
      }

      //tests
    public function verificationValidBodyForCreatingClient(ApiTester $I)
    {      
        $data = new DataHelper();
        $userName = $data->getRandomTestUserName();
        $email = $data->getRandomTestEmail();
        $password = $data->getRandomTestPassword();

        $I->sendPost('/user/create', [
          'username' => $userName,
          'email' => $email,
          'password' => $password
        ]);
        $id = $I->seeResponseContains('id');
        $I->grabDataFromResponseByJsonPath('$.id');  
        $I->sendGet('user/get?' . $id);
        
        
       
    }

    }
  
