<?php

class Obat extends BaseMasterModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'obat';
    }

    public function rules()
    {
        return array(
            array('kode, nama, kategori, satuan, harga_beli, harga_jual, stok_minimal', 'required'),
            array('kode', 'unique'),
            array('kode', 'length', 'max' => 10),
            array('nama', 'length', 'max' => 100),
            array('kategori, satuan', 'length', 'max' => 50),
            array('harga_beli, harga_jual', 'numerical', 'min' => 0),
            array('stok, stok_minimal', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('keterangan', 'safe'),
            array('status', 'in', 'range' => array('aktif', 'nonaktif')),
            array('kode, nama, kategori, keterangan, status', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'kategori' => 'Kategori',
            'satuan' => 'Satuan',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'stok' => 'Stok',
            'stok_minimal' => 'Stok Minimal',
            'keterangan' => 'Keterangan',
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
        $criteria->compare('kategori', $this->kategori, true);
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

    public function relations()
    {
        return array(
            'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updatedBy' => array(self::BELONGS_TO, 'User', 'updated_by'),
        );
    }

    public function getFormattedHargaBeli()
    {
        return Yii::app()->numberFormatter->formatCurrency($this->harga_beli, 'IDR');
    }

    public function getFormattedHargaJual()
    {
        return Yii::app()->numberFormatter->formatCurrency($this->harga_jual, 'IDR');
    }

    public function getKategoriOptions()
    {
        return array(
            'obat_bebas' => 'Obat Bebas',
            'obat_keras' => 'Obat Keras',
            'obat_terbatas' => 'Obat Terbatas',
            'obat_narkotika' => 'Obat Narkotika',
            'obat_psikotropika' => 'Obat Psikotropika',
        );
    }

    public function getKategoriText()
    {
        $options = $this->getKategoriOptions();
        return isset($options[$this->kategori]) ? $options[$this->kategori] : $this->kategori;
    }

    public function getSatuanOptions()
    {
        return array(
            'tablet' => 'Tablet',
            'kapsul' => 'Kapsul',
            'sirup' => 'Sirup',
            'suntik' => 'Suntik',
            'salep' => 'Salep',
            'krim' => 'Krim',
            'drop' => 'Drop',
        );
    }

    public function getSatuanText()
    {
        $options = $this->getSatuanOptions();
        return isset($options[$this->satuan]) ? $options[$this->satuan] : $this->satuan;
    }
} 