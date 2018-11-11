<?php

namespace spec\Imjoehaines\Session;

use OutOfBoundsException;
use Imjoehaines\Session\Session;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SessionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['a' => 1]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Session::class);
    }

    public function it_returns_false_for_values_not_in_storage()
    {
        $this->has('x')->shouldBe(false);
    }

    public function it_returns_true_for_values_in_storage()
    {
        $this->has('a')->shouldBe(true);
    }

    public function it_returns_value_for_values_in_storage()
    {
        $this->get('a')->shouldBe(1);
    }

    public function it_throws_when_trying_to_get_a_value_not_in_storage()
    {
        $this->shouldThrow(
            new OutOfBoundsException('The key "x" was not found in the session')
        )->during('get', ['x']);
    }

    public function it_allows_new_values_to_be_set()
    {
        $this->has('x')->shouldBe(false);

        $this->set('x', 23);

        $this->has('x')->shouldBe(true);
        $this->get('x')->shouldBe(23);
    }

    public function it_allows_existing_values_to_be_overwritten()
    {
        $this->has('a')->shouldBe(true);

        $this->set('a', 'something else');

        $this->has('a')->shouldBe(true);
        $this->get('a')->shouldBe('something else');
    }

    public function it_allows_existing_values_to_be_removed()
    {
        $this->has('a')->shouldBe(true);

        $this->delete('a');

        $this->has('a')->shouldBe(false);
    }

    public function it_throws_when_trying_to_delete_a_value_not_in_storage()
    {
        $this->shouldThrow(
            new OutOfBoundsException('The key "x" was not found in the session')
        )->during('delete', ['x']);
    }
}
