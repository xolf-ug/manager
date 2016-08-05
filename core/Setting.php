<?php

namespace Manager;

class Setting {

    /**
     * @var \Xolf\io\Client
     */
    private $_io;

    public function __construct($io)
    {
        $this->setIo($io);
    }


    /**
     * @return \Xolf\io\Client
     */
    public function getIo()
    {
        return $this->_io;
    }

    /**
     * @param \Xolf\io\Client $io
     */
    public function setIo($io)
    {
        $this->_io = $io;
    }

}