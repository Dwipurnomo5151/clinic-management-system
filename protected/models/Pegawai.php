<?php

class Pegawai extends BaseMasterModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'pegawai';
    }

    public function delete()
    {
        // Delete associated user first if exists
        if ($this->user !== null) {
            $this->user->delete();
        }
        
        // Perform hard delete
        return parent::delete();
    }

    public function rules()
    {
        return array(
            array('nip, nama, jenis_kelamin, jabatan', 'required'),
            array('nip, email', 'unique'),
            array('nip', 'length', 'max' => 20),
            array('nama', 'length', 'max' => 100),
            array('jenis_kelamin', 'in', 'range' => array('L', 'P')),
            array('email', 'email'),
            array('telepon', 'length', 'max' => 15),
            array('jabatan', 'length', 'max' => 50),
            array('status', 'in', 'range' => array('aktif', 'nonaktif')),
            array('tanggal_lahir', 'date', 'format' => 'yyyy-MM-dd'),
            array('tempat_lahir, alamat', 'safe'),
            array('nip, nama, jenis_kelamin, jabatan, status', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::HAS_ONE, 'User', 'pegawai_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'nip' => 'NIP',
            'nama' => 'Nama',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'email' => 'Email',
            'jabatan' => 'Jabatan',
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
        $criteria->compare('nip', $this->nip, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('jenis_kelamin', $this->jenis_kelamin);
        $criteria->compare('jabatan', $this->jabatan, true);
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

    public function getJenisKelaminOptions()
    {
        return array(
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
        );
    }

    public function getJenisKelaminText()
    {
        $options = $this->getJenisKelaminOptions();
        return isset($options[$this->jenis_kelamin]) ? $options[$this->jenis_kelamin] : $this->jenis_kelamin;
    }

    public function getJabatanOptions()
    {
        return array(
            'dokter' => 'Dokter',
            'perawat' => 'Perawat',
            'apoteker' => 'Apoteker',
            'admin' => 'Admin',
            'staff' => 'Staff',
        );
    }

    public function getJabatanText()
    {
        $options = $this->getJabatanOptions();
        return isset($options[$this->jabatan]) ? $options[$this->jabatan] : $this->jabatan;
    }

    public function getStatusOptions()
    {
        return array(
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
        );
    }

    public function getStatusLabel()
    {
        $class = $this->status === 'aktif' ? 'success' : 'danger';
        return '<span class="badge bg-' . $class . '">' . ucfirst($this->status) . '</span>';
    }
} 