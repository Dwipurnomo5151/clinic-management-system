<?php

class Pemeriksaan extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pemeriksaan';
    }

    public function rules()
    {
        return array(
            array('pendaftaran_id, dokter_id, diagnosa', 'required'),
            array('pendaftaran_id, dokter_id', 'numerical', 'integerOnly'=>true),
            array('tindakan, resep, catatan', 'safe'),
            array('id, pendaftaran_id, dokter_id, tanggal, diagnosa, tindakan, resep, catatan, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'Pendaftaran', 'pendaftaran_id'),
            'dokter' => array(self::BELONGS_TO, 'User', 'dokter_id'),
            'patient' => array(self::HAS_ONE, 'Patient', array('id'=>'pasien_id'), 'through'=>'pendaftaran'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'pendaftaran_id' => 'Pendaftaran',
            'dokter_id' => 'Dokter',
            'tanggal' => 'Tanggal',
            'diagnosa' => 'Diagnosa',
            'tindakan' => 'Tindakan Medis',
            'resep' => 'Resep Obat',
            'catatan' => 'Catatan Tambahan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('dokter_id', $this->dokter_id);
        $criteria->compare('diagnosa', $this->diagnosa, true);
        $criteria->compare('tindakan', $this->tindakan, true);
        $criteria->compare('resep', $this->resep, true);

        // Filter by current doctor's examinations
        if (Yii::app()->user->checkAccess('dokter')) {
            $criteria->compare('dokter_id', Yii::app()->user->id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'tanggal DESC',
            ),
        ));
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