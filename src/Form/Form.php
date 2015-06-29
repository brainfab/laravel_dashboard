<?php namespace SmallTeam\Form;

class Form implements FormInterface
{

    private $name;
    private $data;
    private $options;

    public function __construct($name, array $data = [], array $options = [])
    {
        $this->setName($name);
        $this->setData($data);
        $this->setOptions($options);
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function getOption($key)
    {
        return array_key_exists($key, $this->options) ? $this->options[$key] : null;
    }

}
