<?php

namespace Tests\Unit;

use App\Models\Member;
use Tests\TestCase;

class ModelDefinitionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_base_def(): void
    {
        $u = Member::def('u');
        $this->assertTrue($u->id === 'u.id');
        $u->noname();
        $this->assertTrue($u->id === 'id');
        $u = Member::def(null);
        $this->assertTrue($u->id === 'members.id');
        $u->noname();
        $this->assertTrue($u->id === 'id');
    }
}
