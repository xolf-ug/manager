<?php

class Manager {

    /**
     * @var \Xolf\io\Client
     */
    private $_io;

    // IO db path
    const IO_PATH = __DIR__ . '/../io-db';

    /**
     * @var \Manager\Setting
     */
    private $_setting;

    /**
     * @var \Manager\Setup
     */
    private $_setup;

    public function __construct()
    {
        if($this->getSetup()->needSetup()) header('Location: setup.php');
    }

    
    /**
     * @return \Xolf\io\Client
     */
    public function getIo()
    {
        if(is_null($this->_io)) $this->setIo(new \Xolf\io\Client(self::IO_PATH));
        return $this->_io;
    }

    /**
     * @param \Xolf\io\Client $io
     */
    public function setIo($io)
    {
        $this->_io = $io;
    }

    /**
     * @return \Manager\Setting
     */
    public function getSetting()
    {
        if(is_null($this->_setting)) $this->setSetting(new \Manager\Setting($this->getIo()));
        return $this->_setting;
    }

    /**
     * @param \Manager\Setting $setting
     */
    public function setSetting($setting)
    {
        $this->_setting = $setting;
    }

    /**
     * @return \Manager\Setup
     */
    public function getSetup()
    {
        if(is_null($this->_setup)) $this->setSetup(new \Manager\Setup($this));
        return $this->_setup;
    }

    /**
     * @param \Manager\Setup $setup
     */
    public function setSetup($setup)
    {
        $this->_setup = $setup;
    }

}