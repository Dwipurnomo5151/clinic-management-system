<?php

class Tindakan extends BaseMasterModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'tindakan';
    }

    public function rules()
    {
        return array(
            array('kode, nama, biaya', 'required'),
            array('kode', 'unique'),
            array('kode', 'length', 'max' => 10),
            array('nama', 'length', 'max' => 100),
            array('biaya', 'numerical', 'min' => 0),
            array('deskripsi', 'safe'),
            array('status', 'in', 'range' => array('aktif', 'nonaktif')),
            array('kode, nama, deskripsi, status', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'deskripsi' => 'Deskripsi',
            'biaya' => 'Biaya',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diubah Oleh',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('kode', $this->kode, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'nama ASC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getFormattedBiaya()
    {
        return Yii::app()->numberFormatter->formatCurrency($this->biaya, 'IDR');
    }

    public function relations()
    {
        return array(
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
        );
    }
} 