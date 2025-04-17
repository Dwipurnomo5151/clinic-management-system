<?php

class Pembayaran extends CFormModel
{
    public $jumlah_bayar;

    public function rules()
    {
        return array(
            array('jumlah_bayar', 'required'),
            array('jumlah_bayar', 'numerical', 'min'=>0),
        );
    }

    public function attributeLabels()
    {
        return array(
            'jumlah_bayar' => 'Jumlah Bayar',
        );
    }
} 