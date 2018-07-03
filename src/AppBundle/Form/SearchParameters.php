<?php

namespace AppBundle\Form;


class SearchParameters
{
    public $name;

    public $grad;

    public $obrazovanje;
    
    public $smijer;
    
    public function getObrazovanje()
    {
        return $this->obrazovanje;
    }

    public function setObrazovanje($obrazovanje)
    {
        $this->obrazovanje = $obrazovanje;
    }

}
