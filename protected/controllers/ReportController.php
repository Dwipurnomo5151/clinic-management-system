<?php

Yii::import('application.models.ReportForm');

class ReportController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionKunjungan()
    {
        $model = new ReportForm;
        $data = array();
        
        if(isset($_POST['ReportForm'])) {
            $model->attributes = $_POST['ReportForm'];
            if($model->validate()) {
                $data = $model->getKunjunganData();
            }
        }
        
        $this->render('kunjungan', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionTindakan()
    {
        $model = new ReportForm;
        $data = array();
        
        if (isset($_POST['ReportForm'])) {
            $model->attributes = $_POST['ReportForm'];
            if ($model->validate()) {
                $sql = "SELECT p.tindakan as nama, COUNT(*) as jumlah 
                        FROM pemeriksaan p 
                        WHERE DATE(p.tanggal) BETWEEN :start_date AND :end_date 
                        GROUP BY p.tindakan";

                $command = Yii::app()->db->createCommand($sql);
                $command->bindValue(':start_date', $model->start_date);
                $command->bindValue(':end_date', $model->end_date);
                
                $rawData = $command->queryAll();
                
                // Menyesuaikan format data
                $data = array_map(function($item) {
                    return (object)[
                        'tindakan' => (object)['nama' => $item['nama']],
                        'jumlah' => (int)$item['jumlah']
                    ];
                }, $rawData);
            }
        }

        $this->render('tindakan', array(
            'model' => $model,
            'data' => $data
        ));
    }

    public function actionObat()
    {
        $model = new ReportForm;
        $data = array();
        
        if(isset($_POST['ReportForm'])) {
            $model->attributes = $_POST['ReportForm'];
            if($model->validate()) {
                $data = $model->getObatData();
            }
        }
        
        $this->render('obat', array(
            'model' => $model,
            'data' => $data,
        ));
    }
}