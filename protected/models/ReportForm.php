<?php

class ReportForm extends CFormModel
{
    public $start_date;
    public $end_date;
    public $group_by;

    public function rules()
    {
        return array(
            array('start_date, end_date, group_by', 'required'),
            array('start_date, end_date', 'date', 'format' => 'yyyy-MM-dd'),
            array('group_by', 'in', 'range' => array('day', 'month')),
        );
    }

    public function attributeLabels()
    {
        return array(
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'group_by' => 'Kelompokkan Berdasarkan',
        );
    }

    public function getKunjunganData()
    {
        $criteria = new CDbCriteria;
        $criteria->select = "to_char(tanggal_kunjungan, 'YYYY-MM-DD') as tanggal, COUNT(*) as jumlah";
        $criteria->addBetweenCondition('tanggal_kunjungan', $this->start_date, $this->end_date);
        $criteria->group = "to_char(tanggal_kunjungan, 'YYYY-MM-DD')";
        $criteria->order = 'tanggal ASC';

        return Visit::model()->findAll($criteria);
    }

    public function getTindakanData()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'tindakan_id, COUNT(*) as jumlah';
        $criteria->with = array('tindakan');
        $criteria->addBetweenCondition('tanggal_kunjungan', $this->start_date, $this->end_date);
        $criteria->group = 'tindakan_id';
        $criteria->order = 'jumlah DESC';
        $criteria->limit = 10;

        return Visit::model()->findAll($criteria);
    }

    public function getObatData()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'obat_id, COUNT(*) as jumlah';
        $criteria->with = array('obat');
        $criteria->addBetweenCondition('tanggal_kunjungan', $this->start_date, $this->end_date);
        $criteria->group = 'obat_id';
        $criteria->order = 'jumlah DESC';
        $criteria->limit = 10;

        return Resep::model()->findAll($criteria);
    }
} 