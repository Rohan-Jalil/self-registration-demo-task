<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess()
    {
        $this->mockGoogleGeocodingRepository();
        $response = $this->post('/api/register', [
            'name' => 'Ad Network',
            'address1' => 'Rock Heven Way',
            'address2' => '#125',
            'city' => 'Sterling',
            'state' => 'VA',
            'country' => 'USA',
            'zipCode' => 20166,
            'phoneNo1' => '555-666-7777',
            'phoneNo2' => '',
            'user' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john.doe7@example.com',
                'password' => 'Secret@123',
                'passwordConfirmation' => 'Secret@123',
                'phone' => '123-456-7890'
            ]
        ]);
        $response->assertStatus(200);
    }

    public function testRegisterValidationError()
    {
        $this->mockGoogleGeocodingRepository();
        $response = $this->post('/api/register', [
            'name' => '',
            'address1' => '',
            'address2' => '',
            'city' => '',
            'state' => '',
            'country' => '',
            'zipCode' => '',
            'phoneNo1' => '',
            'phoneNo2' => '',
            'user' => [
                'firstName' => '',
                'lastName' => '',
                'email' => '',
                'password' => '',
                'passwordConfirmation' => '',
                'phone' => ''
            ]
        ]);
        $response->assertStatus(422);
        $content = json_decode($response->getContent(), true);
        $this->assertEquals('Validation Error', $content['message']);
        $this->assertEquals('The name field is required.', $content['errors']['name'][0]);
        $this->assertEquals('The address1 field is required.', $content['errors']['address1'][0]);
        $this->assertEquals('The city field is required.', $content['errors']['city'][0]);
        $this->assertEquals('The state field is required.', $content['errors']['state'][0]);
        $this->assertEquals('The country field is required.', $content['errors']['country'][0]);
        $this->assertEquals('The zip code field is required.', $content['errors']['zipCode'][0]);
        $this->assertEquals('The phone no1 field is required.', $content['errors']['phoneNo1'][0]);
        $this->assertEquals('The user.first name field is required.', $content['errors']['user.firstName'][0]);
        $this->assertEquals('The user.last name field is required.', $content['errors']['user.lastName'][0]);
        $this->assertEquals('The user.email field is required.', $content['errors']['user.email'][0]);
        $this->assertEquals('The user.password field is required.', $content['errors']['user.password'][0]);
        $this->assertEquals('The user.phone field is required.', $content['errors']['user.phone'][0]);
    }

    public function testGetAllUsersSuccess()
    {
        for ($i = 0; $i < 5; $i++) {
            factory(User::class)->create();
        }
        $response = $this->get('/api/accounts');
        $response->assertStatus(200);
        $content = json_decode($response->getContent(), true);
        $this->assertCount(5, $content['data']);
    }
}
