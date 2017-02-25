<?php


use Vanguard\Role;
use Vanguard\User;
use Mockery as m;

class FunctionalTestCase extends TestCase
{
    use \Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

    protected $seed = true;

    public function setUp()
    {
        $this->afterApplicationCreated(function () {
            $this->artisan('migrate');

            if ($this->seed) {
                $this->artisan('db:seed', ['--class' => 'CountriesSeeder']);
                $this->artisan('db:seed', ['--class' => 'RolesSeeder']);
                $this->artisan('db:seed', ['--class' => 'PermissionsSeeder']);
            }
        });

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });

        parent::setUp();
    }

    /**
     * @param array $attrubutes
     * @return mixed
     */
    protected function createAndLoginUser(array $attrubutes = [])
    {
        $user = $this->createUserWithSocialNetworks($attrubutes);

        $user = $this->setRoleForUser($user, 'User');

        $this->be($user);

        return $user;
    }

    /**
     * @param array $attrubutes
     * @return mixed
     */
    protected function createAndLoginAdminUser(array $attrubutes = [])
    {
        $user = $this->createUserWithSocialNetworks($attrubutes);

        $user = $this->setRoleForUser($user, 'Admin');

        $this->be($user);

        return $user;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    protected function createUserWithSocialNetworks(array $attributes = [])
    {
        $user = factory(User::class)->create($attributes);
        $user->socialNetworks()->create([]);

        return $user;
    }

    /**
     * @return mixed
     */
    protected function createSuperUser()
    {
        $user = factory(User::class)->create();
        return $this->makeSuperUser($user);
    }

    protected function makeSuperUser(User $user = null)
    {
        $user = m::mock($user ?: User::class)->makePartial();
        $user->shouldReceive('can')->andReturn(true);

        return $user;
    }

    /**
     * @param User $user
     * @param $role
     * @return User
     */
    public function setRoleForUser(User $user, $role)
    {
        $role = Role::where('name', $role)->first();
        $user->roles()->attach($role);

        return $user;
    }

    public function seeElement($element, $negate = false)
    {
        $method = $negate ? 'assertEquals' : 'assertGreaterThan';

        $message = $negate
            ? "Element [$element] exists on specified page."
            : "Element [$element] does not exist on specified page.";

        $this->$method(0, $this->crawler->filter($element)->count(), $message);

        return $this;
    }

    public function dontSeeElement($element)
    {
        return $this->seeElement($element, true);
    }

    public function seeInTable($selector, $text, $rowNumber, $columnNumber, $negate = false)
    {
        $fullSelector = "{$selector} tbody tr:nth-child({$rowNumber}) > td:nth-child({$columnNumber})";
        return $this->seeInElement($fullSelector, $text, $negate);
    }

    public function dontSeeInTable($selector, $text, $rowNumber, $columnNumber)
    {
        return $this->seeInTable($selector, $text, $rowNumber, $columnNumber, true);
    }

    /**
     * Click on link that matches provided selector.
     *
     * @param $selector
     * @return $this
     */
    protected function clickOn($selector)
    {
        $link = $this->crawler->filter($selector)->first();
        return $this->visit($link->link()->getUri());
    }

}