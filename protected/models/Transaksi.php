<?php

class Transaksi extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'transaksi';
    }

    public function rules()
    {
        return array(
            array('pendaftaran_id, pemeriksaan_id, jenis, item_id, jumlah, harga, total', 'required'),
            array('pendaftaran_id, pemeriksaan_id, item_id, jumlah', 'numerical', 'integerOnly'=>true),
            array('harga, total', 'numerical'),
            array('jenis', 'in', 'range'=>array('tindakan', 'obat')),
            array('status', 'in', 'range'=>array('pending', 'selesai', 'batal')),
            array('created_at, updated_at', 'safe'),
            array('id, pendaftaran_id, pemeriksaan_id, jenis, item_id, jumlah, harga, total, status, created_at, updated_at', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'Pendaftaran', 'pendaftaran_id'),
            'pemeriksaan' => array(self::BELONGS_TO, 'Pemeriksaan', 'pemeriksaan_id'),
            'tindakan' => array(self::BELONGS_TO, 'Tindakan', 'item_id'),
            'obat' => array(self::BELONGS_TO, 'Obat', 'item_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'pendaftaran_id' => 'Pendaftaran',
            'pemeriksaan_id' => 'Pemeriksaan',
            'jenis' => 'Jenis',
            'item_id' => 'Item',
            'jumlah' => 'Jumlah',
            'harga' => 'Harga',
            'total' => 'Total',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pemeriksaan_id', $this->pemeriksaan_id);
        $criteria->compare('jenis', $this->jenis, true);
        $criteria->compare('item_id', $this->item_id);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('harga', $this->harga);
        $criteria->compare('total', $this->total);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'created_at DESC',
            ),
        ));
    }

    public function getJenisText()
    {
        $options = array(
            'tindakan' => 'Tindakan Medis',
            'obat' => 'Obat',
        );
        return isset($options[$this->jenis]) ? $options[$this->jenis] : $this->jenis;
    }

    public function getStatusText()
    {
        $options = array(
            'pending' => 'Menunggu',
            'selesai' => 'Selesai',
            'batal' => 'Batal',
        );
        return isset($options[$this->status]) ? $options[$this->status] : $this->status;
    }

    public function getItemName()
    {
        if ($this->jenis == 'tindakan' && $this->tindakan) {
            return $this->tindakan->nama;
        } elseif ($this->jenis == 'obat' && $this->obat) {
            return $this->obat->nama;
        }
        return '-';
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

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = new CDbExpression('NOW()');
        }
        $this->updated_at = new CDbExpression('NOW()');
        return parent::beforeSave();
    }
} 