<?php

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
        
        if(isset($_POST['ReportForm'])) {
            $model->attributes = $_POST['ReportForm'];
            if($model->validate()) {
                $data = $model->getTindakanData();
            }
        }
        
        $this->render('tindakan', array(
            'model' => $model,
            'data' => $data,
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