<?php

abstract class BaseMasterModel extends CActiveRecord
{
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
                'setUpdateOnCreate' => true,
                'timestampExpression' => 'date("Y-m-d H:i:s")',
            ),
            'CUserBehavior' => array(
                'class' => 'application.components.CUserBehavior',
                'createAttribute' => 'created_by',
                'updateAttribute' => 'updated_by',
            ),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
        }
        $this->updated_by = Yii::app()->user->id;
        return parent::beforeSave();
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getStatusOptions()
    {
        return array(
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
        );
    }

    public function getStatusLabel()
    {
        $class = $this->status === 'aktif' ? 'success' : 'danger';
        return '<span class="badge bg-' . $class . '">' . ucfirst($this->status) . '</span>';
    }

    public function getStatusText()
    {
        $options = $this->getStatusOptions();
        return isset($options[$this->status]) ? $options[$this->status] : $this->status;
    }
} 