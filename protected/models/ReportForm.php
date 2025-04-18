<?php

class ReportForm extends CFormModel
{
    public $start_date;
    public $end_date;

    public function rules()
    {
        return array(
            array('start_date, end_date', 'required'),
            array('start_date, end_date', 'date', 'format'=>'yyyy-MM-dd'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
        );
    }

    public function getKunjunganData()
    {
        $sql = "SELECT DATE(p.tanggal) as tanggal, COUNT(*) as jumlah 
                FROM pemeriksaan p 
                WHERE DATE(p.tanggal) BETWEEN :start_date AND :end_date 
                GROUP BY DATE(p.tanggal)";
    
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':start_date', $this->start_date);
        $command->bindValue(':end_date', $this->end_date);
        
        $rawData = $command->queryAll();
        
        return array_map(function($item) {
            return (object)[
                'tanggal' => $item['tanggal'],
                'jumlah' => (int)$item['jumlah']
            ];
        }, $rawData);
    }

    public function getObatData()
    {
        $sql = "SELECT p.resep as nama, COUNT(*) as jumlah 
                FROM pemeriksaan p 
                WHERE DATE(p.tanggal) BETWEEN :start_date AND :end_date 
                AND p.resep IS NOT NULL 
                GROUP BY p.resep";
    
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':start_date', $this->start_date);
        $command->bindValue(':end_date', $this->end_date);
        
        $rawData = $command->queryAll();
        
        return array_map(function($item) {
            return (object)[
                'obat' => (object)['nama' => $item['nama']],
                'jumlah' => (int)$item['jumlah']
            ];
        }, $rawData);
    }
}