<?php
class DudeTests extends EnhanceTestFixture { 

    public function mathewSubtract() {
        $d = new Mathew();
        $result = $d->substract(10, 5);
        Assert::areIdentical(5, $result);
    }
}
