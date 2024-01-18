<?php
require_once 'infoContentsBaseClass.php';

class infoUser extends infoContentsBase
{
    public $_fieldMap = array(
        'loginid'           => array(1, FIELD_TYPE_STRING),
        'loginpwd'          => array(2, FIELD_TYPE_STRING),
        'name_sei'          => array(3, FIELD_TYPE_STRING),
        'name_mei'          => array(4, FIELD_TYPE_STRING),
        'status'            => array(5, FIELD_TYPE_NUMERIC),
    );

    public $_status = array(
                  1=>"未確認",
                  2=>"確認済み",
              );

    public function __construct($db_target='slave') {
        parent::__construct($db_target);

        $this->_table = 'ca_user';
        $this->_upfileDir = UP_IMAGE_DIR.$this->_table.'/';
        $this->_uppath = UP_IMAGE_PATH.'/'.$this->_table;
    }

    public function getUserList() {
        $sql = "SELECT ";
        $sql .= " sid";
        $sql .= ",loginid";
        $sql .= ",loginpwd";
        $sql .= ",name_sei";
        $sql .= ",name_mei";
        $sql .= ",status ";
        $sql .= "FROM ";
        $sql .= $this->_table." ";
        $sql .= "WHERE ";
        $sql .= "   active = 1 ";
        $sql .= $this->getSQL_order();
        $sql .= $this->getSQL_limit();
        $sql .= $this->getSQL_offset();
        $list = $this->getObjList($this->search($sql));
        return $list;
    }

    public function getUserListCount() {
        $sql = "SELECT ";
        $sql .= " COUNT(*) cnt ";
        $sql .= "FROM ";
        $sql .= $this->_table."  ";
        $sql .= "WHERE ";
        $sql .= "   active = 1 ";
        $list = $this->getObjList($this->search($sql));
        if (!empty($list)) {
            return $list[0]->cnt;
        }
        return false;
    }

    public function getUserListById($sid) {
        $sql = "SELECT ";
        $sql .= " sid";
        $sql .= ",loginid";
        $sql .= ",loginpwd";
        $sql .= ",name_sei";
        $sql .= ",name_mei";
        $sql .= ",status ";
        $sql .= "FROM ";
        $sql .= $this->_table."  ";
        $sql .= "WHERE ";
        $sql .= "  active = 1 ";
        $sql .= "  and sid = ".$sid;
        $list = $this->getObjList($this->search($sql));
        if (!empty($list)) {
            return $list[0];
        }
        return false;
    }

    public function addUser($values)
    {
        $stmt = $this->addPrepare();
        $result = $this->add($stmt, $values);
        return $result;
    }

    public function updateUser($sid, $values)
    {
        $stmt = $this->updatePrepare();
        $this->bind($stmt, 'sid', $sid);
        $result = $this->update($stmt, $values);
        return $result;
    }

    public function deleteUser($sid)
    {
        $stmt = $this->deleteStatusPrepare();
        $result = $this->deleteStatus($stmt, $sid);
        return $result;
    }

    function password_decrypt($pwd, $sid)
    {
        $iv = hex2bin(CRYPT_IV);
        return openssl_decrypt(hex2bin($pwd), CRYPT_METHOD, $sid, OPENSSL_RAW_DATA, $iv);
    }


}
