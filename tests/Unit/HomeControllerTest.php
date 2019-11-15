<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class HomeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

  public function testIndexMethod(){ 
      $response = $this->get('/');
      $response ->assertStatus(200);
  }

   

  public function testRequestStatusMethod(){
 
  $response = $this->withHeaders([
              'X-CSRF-TOKEN' => csrf_token(),
              ])->json('POST', '/home', ['url' => 'https://ridanoor.com']);

          $response
              ->assertStatus(200);

  }

  public function testResultsMethod(){
      $response = $this->get('/status/google.com');
      $response ->assertStatus(200);
  }


  public function testStatusMethod(){
      $response = $this->get('/status/google.com');
      $response ->assertStatus(200);
  }


}
