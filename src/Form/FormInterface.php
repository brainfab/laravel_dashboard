<?php namespace SmallTeam\Form;

interface FormInterface
{

    public function __construct($name, array $data = [], array $options = []);

    public function setName($name);

    public function getName();

    public function setData(array $data);

    public function getData();

    public function setOptions(array $options);

    public function getOptions();

    public function setOption($key, $value);

    public function getOption($key);

}
