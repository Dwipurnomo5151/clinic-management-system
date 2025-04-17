<?php

class Wilayah extends BaseMasterModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'wilayah';
    }

    public function rules()
    {
        return array(
            array('kode, nama, tipe', 'required'),
            array('kode', 'unique'),
            array('kode', 'length', 'max' => 10),
            array('nama', 'length', 'max' => 100),
            array('tipe', 'in', 'range' => array('provinsi', 'kabupaten', 'kecamatan')),
            array('parent_id', 'numerical', 'integerOnly' => true),
            array('parent_id', 'exist', 'className' => 'Wilayah', 'attributeName' => 'id'),
            array('status', 'in', 'range' => array('aktif', 'nonaktif')),
            array('kode, nama, tipe, status', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'Wilayah', 'parent_id'),
            'children' => array(self::HAS_MANY, 'Wilayah', 'parent_id'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'tipe' => 'Tipe',
            'parent_id' => 'Induk',
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.nama', $this->nama, true);
        $criteria->compare('t.tipe', $this->tipe, true);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.status', $this->status, true);

        $criteria->with = array('parent');
        $criteria->together = true;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
            'sort' => array(
                'defaultOrder' => 't.tipe ASC, t.nama ASC',
                'attributes' => array(
                    'parent_id' => array(
                        'asc' => 'parent.nama ASC',
                        'desc' => 'parent.nama DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    public function getTipeOptions()
    {
        return array(
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'kecamatan' => 'Kecamatan',
        );
    }

    public function getTipeText()
    {
        $options = $this->getTipeOptions();
        return isset($options[$this->tipe]) ? $options[$this->tipe] : $this->tipe;
    }
} 