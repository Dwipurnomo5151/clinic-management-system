<?php

class Patient extends CActiveRecord
{
    public function tableName()
    {
        return 'pasien';
    }

    public function rules()
    {
        return array(
            array('no_rm, nama, tanggal_lahir, jenis_kelamin, alamat, no_telp', 'required'),
            array('no_rm', 'unique'),
            array('no_telp', 'length', 'max'=>15),
            array('nama', 'length', 'max'=>100),
            array('jenis_kelamin', 'in', 'range'=>array('L', 'P')),
            array('alamat', 'length', 'max'=>255),
            array('created_at, updated_at', 'safe'),
            array('id, no_rm, nama, tanggal_lahir, jenis_kelamin, alamat, no_telp, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'visits' => array(self::HAS_MANY, 'Visit', 'patient_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'no_rm' => 'No. Rekam Medis',
            'nama' => 'Nama Lengkap',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat',
            'no_telp' => 'No. Telepon',
            'created_at' => 'Tanggal Daftar',
            'updated_at' => 'Terakhir Diubah',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('no_rm', $this->no_rm, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin);
        $criteria->compare('alamat', $this->alamat, true);
        $criteria->compare('no_telp', $this->no_telp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'nama ASC',
            ),
        ));
    }

    public function getJenisKelaminText()
    {
        $options = $this->getJenisKelaminOptions();
        return isset($options[$this->jenis_kelamin]) ? $options[$this->jenis_kelamin] : '-';
    }

    public function getJenisKelaminOptions()
    {
        return array(
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
        );
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }
        $this->updated_at = new CDbExpression('NOW()');
        
        return parent::beforeSave();
    }
} 