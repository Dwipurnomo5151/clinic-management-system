<?php

class User extends BaseMasterModel {
    public $password_repeat;
    public $old_password;
    private $_oldPassword;
    public $id_pegawai;
    
    // Explicitly declare timestamp and user tracking fields
    public $created_at;
    public $updated_at;
    public $created_by;
    public $updated_by;
    public $last_login;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'user';
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('username', 'required'),
            array('username', 'unique'),
            array('username', 'length', 'max' => 50),
            array('password', 'length', 'max' => 255),
            array('role', 'in', 'range'=>array('admin', 'dokter', 'apoteker', 'kasir', 'pendaftaran')),
            array('status', 'in', 'range'=>array('aktif', 'nonaktif')),
            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'on'=>'insert,update'),
            array('old_password', 'required', 'on' => 'changePassword'),
            array('password, password_repeat', 'required', 'on' => 'register, changePassword'),
            array('username, role, status, pegawai_id, created_at, updated_at, created_by, updated_by, last_login', 'safe', 'on' => 'search'),
            array('pegawai_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
            array('pegawai_id', 'exist', 'className'=>'Pegawai', 'attributeName'=>'id'),
            array('created_by, updated_by', 'exist', 'className'=>'User', 'attributeName'=>'id', 'allowEmpty'=>true),
            array('created_at, updated_at', 'safe'),
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'pegawai' => array(self::BELONGS_TO, 'Pegawai', 'pegawai_id'),
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'username' => 'Username',
            'password' => 'Password',
            'password_repeat' => 'Ulangi Password',
            'old_password' => 'Password Lama',
            'role' => 'Role',
            'pegawai_id' => 'Pegawai',
            'status' => 'Status',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diubah Oleh',
            'id_pegawai' => 'Pegawai',
        ));
    }

    public function beforeSave() {
        if(parent::beforeSave()) {
            if($this->isNewRecord || !empty($this->password)) {
                $this->password = CPasswordHelper::hashPassword($this->password);
            } else {
                $this->password = $this->_oldPassword;
            }
            return true;
        }
        return false;
    }

    public function afterFind() {
        parent::afterFind();
        $this->_oldPassword = $this->password;
    }

    public function getRoleOptions() {
        return array(
            'admin' => 'Administrator',
            'dokter' => 'Dokter',
            'apoteker' => 'Apoteker',
            'kasir' => 'Kasir',
            'pendaftaran' => 'Pendaftaran',
        );
    }

    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'id' => CSort::SORT_DESC,
                ),
            ),
        ));
    }

    public function getRoleText() {
        $options = $this->getRoleOptions();
        return isset($options[$this->role]) ? $options[$this->role] : $this->role;
    }

    public function getStatusOptions() {
        return array(
            'aktif' => 'Aktif',
            'nonaktif' => 'Nonaktif',
        );
    }

    public function getStatusLabel() {
        return $this->status === 'aktif' 
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-danger">Nonaktif</span>';
    }

    public function getNama() {
        return $this->pegawai ? $this->pegawai->nama : $this->username;
    }

    public function getLastLogin() {
        return $this->last_login ? Yii::app()->dateFormatter->format('dd MMMM yyyy HH:mm', $this->last_login) : '-';
    }
}
?>
