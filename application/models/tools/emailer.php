<?php

class Emailer extends CI_Model {

    public $ids_arr = array();
    public $num_totrec = "";
    protected $module_array = array();
    public $main_table = "";
    public $primary_key = "";

    public function __construct() {
        parent::__construct();
        $this->load->helper('listing');
        $this->main_table = "system_email";
    }

    public function getEmailContent($vEmailCode = 'USER_REQUEST') {
        $this->db->select('iEmailTemplateId,vEmailCode,vEmailTitle,vFromName,vFromEmail,vBccEmail,eEmailFormat,vEmailSubject,tEmailMessage,vEmailFooter,eStatus');
        $this->db->from($this->main_table);
        $this->db->where("vEmailCode", $vEmailCode);
        $emailData = $this->db->get()->result_array();
        return $emailData;
    }

    function send_mail($data, $type = "") {
        $emailData = $this->getEmailContent($type);
        $tEmailMessage = $emailData[0]['tEmailMessage'];
        $vEmailSubject = $emailData[0]['vEmailSubject'];
        switch ($type) {
            case "USER_REQUEST":
                $findarray = array('##IDENTITY##', '##COPYRIGHTS##');
                $replacearray = array($data["contact"], $this->systemsettings->getSettings('COPYRIGHTED_TEXT'));
                break;
        }
        $vBody = str_replace($findarray, $replacearray, $tEmailMessage);
        $subject = str_replace($findarray, $replacearray, $vEmailSubject);
        $this->load->library('email');
        $this->email->from($emailData[0]['vFromEmail'], 'call4peon');
        $this->email->to($data['vEmail']);
        $this->email->subject($subject);
        $this->email->message($vBody);
//        pr($this->email, 1);
        $success = $this->email->send();
//        echo $this->email->print_debugger();exit;
        return $success;
    }

}
