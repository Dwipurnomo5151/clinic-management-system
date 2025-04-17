<?php

class CUserBehavior extends CActiveRecordBehavior
{
    public $createAttribute;
    public $updateAttribute;

    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord) {
            if ($this->createAttribute !== null) {
                $this->owner->{$this->createAttribute} = Yii::app()->user->id;
            }
        }
        if ($this->updateAttribute !== null) {
            $this->owner->{$this->updateAttribute} = Yii::app()->user->id;
        }
    }
} 