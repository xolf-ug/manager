<?php

namespace Manager;

class Setup {

    /**
     * @var \Manager
     */
    private $_manager;

    public function __construct($manager)
    {
        $this->setManager($manager);
    }

    public function needSetup()
    {
        if(isset($this->getManager()->getIo()->table('settings')->document('generel')->title)) return false;
        $file = explode("/", $_SERVER['REQUEST_URI']);
        $file = $file[count($file)-1];
        if($file == 'setup.php') return false;
        return true;
    }


    /**
     * @return \Manager
     */
    public function getManager()
    {
        return $this->_manager;
    }

    /**
     * @param \Manager $manager
     */
    public function setManager($manager)
    {
        $this->_manager = $manager;
    }
}