<?php

class Visit extends CActiveRecord
{
    public $tanggal; // Add virtual property for formatted date
    public $jumlah;  // Add virtual property for count

    public function tableName()
    {
        return 'visit';
    }

    public function rules()
    {
        return array(
            array('jenis_kunjungan, tanggal_kunjungan, keluhan', 'required'),
            array('patient_id', 'numerical', 'integerOnly'=>true),
            array('jenis_kunjungan', 'length', 'max'=>50),
            array('keluhan', 'length', 'max'=>255),
            array('created_at, updated_at, tanggal, jumlah', 'safe'),
            array('id, patient_id, jenis_kunjungan, tanggal_kunjungan, keluhan, created_at, updated_at, tanggal, jumlah', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'patient' => array(self::BELONGS_TO, 'Patient', 'patient_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'patient_id' => 'Pasien',
            'jenis_kunjungan' => 'Jenis Kunjungan',
            'tanggal_kunjungan' => 'Tanggal Kunjungan',
            'keluhan' => 'Keluhan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('patient_id', $this->patient_id);
        $criteria->compare('jenis_kunjungan', $this->jenis_kunjungan, true);
        $criteria->compare('tanggal_kunjungan', $this->tanggal_kunjungan, true);
        $criteria->compare('keluhan', $this->keluhan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'tanggal_kunjungan DESC',
            ),
        ));
    }

    public function getJenisKunjunganOptions()
    {
        return array(
            'umum' => 'Umum',
            'gigi' => 'Gigi',
            'kandungan' => 'Kandungan',
            'anak' => 'Anak',
            'mata' => 'Mata',
            'tht' => 'THT',
            'kulit' => 'Kulit',
            'jantung' => 'Jantung',
            'paru' => 'Paru',
            'saraf' => 'Saraf',
            'bedah' => 'Bedah',
            'ortopedi' => 'Ortopedi',
            'urologi' => 'Urologi',
            'psikiatri' => 'Psikiatri',
        );
    }

    public function getJenisKunjunganText()
    {
        $options = $this->getJenisKunjunganOptions();
        return isset($options[$this->jenis_kunjungan]) ? $options[$this->jenis_kunjungan] : $this->jenis_kunjungan;
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