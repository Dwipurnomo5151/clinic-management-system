<?php

class Pendaftaran extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pendaftaran';
    }

    public function rules()
    {
        return array(
            array('no_pendaftaran, pasien_id, keluhan', 'required'),
            array('pasien_id, created_by', 'numerical', 'integerOnly'=>true),
            array('no_pendaftaran', 'length', 'max'=>20),
            array('status', 'length', 'max'=>50),
            array('keluhan', 'length', 'max'=>255),
            array('tanggal, created_at, updated_at', 'safe'),
            array('id, no_pendaftaran, pasien_id, tanggal, keluhan, status, created_by, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'patient' => array(self::BELONGS_TO, 'Patient', 'pasien_id'),
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'pemeriksaan' => array(self::HAS_ONE, 'Pemeriksaan', 'pendaftaran_id'),
            'transaksis' => array(self::HAS_MANY, 'Transaksi', 'pendaftaran_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'no_pendaftaran' => 'No. Pendaftaran',
            'pasien_id' => 'Pasien',
            'tanggal' => 'Tanggal',
            'keluhan' => 'Keluhan',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    public function getStatusOptions()
    {
        return array(
            'menunggu' => 'Menunggu',
            'dalam-proses' => 'Dalam Proses',
            'selesai' => 'Selesai',
            'batal' => 'Batal',
        );
    }

    public function getStatusText()
    {
        $options = $this->getStatusOptions();
        return isset($options[$this->status]) ? $options[$this->status] : $this->status;
    }

    public function getStatusPembayaranOptions()
    {
        return array(
            'belum_lunas' => 'Belum Lunas',
            'lunas' => 'Lunas',
        );
    }

    public function getStatusPembayaranText()
    {
        $options = $this->getStatusPembayaranOptions();
        return isset($options[$this->status_pembayaran]) ? $options[$this->status_pembayaran] : 'Unknown';
    }

    public function getTotalTagihan()
    {
        $total = 0;
        foreach ($this->transaksis as $transaksi) {
            $total += $transaksi->total;
        }
        return $total;
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('keluhan', $this->keluhan, true);
        $criteria->compare('status', $this->status, true);
        
        // Filter by waiting status
        $criteria->compare('status', 'menunggu');
        
        // Order by date ascending
        $criteria->order = 'tanggal ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchForKasir()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('keluhan', $this->keluhan, true);
        $criteria->compare('status', $this->status, true);
        
        // Filter by completed status and unpaid
        $criteria->compare('status', 'selesai');
        $criteria->compare('status_pembayaran', 'belum_lunas');
        
        // Order by date ascending
        $criteria->order = 'tanggal ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchRiwayat()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('keluhan', $this->keluhan, true);
        $criteria->compare('status', $this->status, true);
        
        // Filter by completed status and paid
        $criteria->compare('status', 'selesai');
        $criteria->compare('status_pembayaran', 'lunas');
        
        // Order by date descending (terbaru dulu)
        $criteria->order = 'tanggal DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,
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

    protected function beforeValidate()
    {
        if ($this->isNewRecord) {
            // Generate registration number
            $this->no_pendaftaran = 'REG' . date('Ymd') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        }
        return parent::beforeValidate();
    }
} 