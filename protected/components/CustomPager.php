<?php

class CustomPager extends CLinkPager
{
    public function init()
    {
        parent::init();
        $this->htmlOptions['class'] = 'pagination justify-content-end';
    }

    protected function createPageButton($label, $page, $class, $hidden, $selected)
    {
        if ($hidden || $selected) {
            $class .= ' ' . ($selected ? 'active' : 'disabled');
        }

        return CHtml::tag('li', array('class' => 'page-item ' . $class),
            CHtml::link($label, $this->createPageUrl($page), array('class' => 'page-link'))
        );
    }
} 