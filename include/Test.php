<?php


class Test{
	public $name;

	function setName($name){
		$this->name=$name;
	}
	function getName(): string{
		return $this->name;
	}
}
$test=new Test();
$test->setName("james");
echo $test->getName();