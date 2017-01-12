<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class imap {

    protected $CI;
    public $orderBook;

    function __construct() {
        $this->CI = & get_instance();
        $this->orderBook = array();
        $this->CI->load->model('mailbox/model_mailbox');
    }

    function getConnected($server, $username, $pass) {
        return imap_open($server, $username, $pass);
    }

    function getEmail($connection, $server, $mailboxtype, $username, $case = array()) {

        $mailbox = array();
        $inbox = $connection;
        imap_reopen($inbox, $server);
        if ($case['subject'] == '') {
            $date = date('d F Y');
            $msgdetail = imap_check($inbox);
            $ext_cond_mailno = 'vUserMail = "' . $username . '" and eMailboxType = "' . $mailboxtype . '"';
            $msgno = $this->CI->model_mailbox->getData('iReference', array(), $ext_cond_mailno, 'iReference DESC', '', '', '1');

            $j = 0;
            if ($msgno[0]['iReference'] != '') {
                for ($i = ($msgno[0]['iReference'] + 1); $i <= $msgdetail->Nmsgs; $i++) {
                    $emails[$j] = $i;
                    $j++;
                }
            } else {
                $emails = imap_search($inbox, 'SINCE "' . $date . '"');
            }
            $mailbox['eItemType'] = 'Message';
        }  else {
            $emails = imap_search($inbox, 'SUBJECT "' . $case['subject'] . '"');
            $mailbox['eItemType'] = 'Case';
            $mailbox['iItemTypeId'] = $case['iItemTypeId'];
        }
//        pr($emails);exit;
        /* grab emails */

        /* if emails are returned, cycle through each... */
        if ($emails) {
            /* begin output var */
            $output = '';            
            /* put the newest emails on top */
            rsort($emails);
            foreach ($emails as $email_number) {

                /* get information specific to this email */

                $structure = imap_fetchstructure($inbox, $email_number);
                $head = imap_header($inbox, $email_number);
                $elements = imap_mime_header_decode($head->subject);

                $to = json_decode(json_encode($head->to), true);
                $from = json_decode(json_encode($head->from), true);
                $cc = json_decode(json_encode($head->cc), true);
                $mailbox['vTo'] = $to[0]['mailbox'] . '@' . $to[0]['host'];
                $mailbox['vFromAddress'] = $from[0]['mailbox'] . '@' . $from[0]['host'];
                if ($cc[0]['mailbox'] != '') {
                    $mailbox['vCc'] = $cc[0]['mailbox'] . '@' . $cc[0]['host'];
                }

                foreach ($elements as $elementsk => $elementsv) {
                    $subject.= $elementsv->text;
                }

                $mailbox['vFromName'] = $head->fromaddress;
                $mailbox['vToName'] = $head->toaddress;
                $mailbox['vSubject'] = $subject;
                $mailbox['dtEmailDate'] = date('Y-m-d H:i:s', strtotime($head->date));
                $mailbox['iCompanyId'] = $this->CI->config->item('YT_USER_COMPANY_ID');
                $mailbox['iUserId'] = $this->CI->session->userdata('iUserId');
                $mailbox['vUserMail'] = $username;
                if ($head->Unseen == 'U') {
                    $mailbox['eStatus'] = "Unread";
                } else {
                    $mailbox['eStatus'] = "Read";
                }
                if ($head->Flagged == 'F') {
                    $mailbox['eMailboxType'] = "Starred";
                } else {
                    $mailbox['eMailboxType'] = $mailboxtype;
                }
                $mailbox['iReference'] = $email_number;
                $mailbox['vUserMail'] = $username;                
                $result = $this->CI->model_mailbox->insert($mailbox);
                $part_number = $this->create_part_array($structure);

                foreach ($part_number as $part_numberk => $part_numberv) {
                    if ($part_numberv['part_object']->subtype == "RELATED" || $part_numberv['part_object']->subtype == "ALTERNATIVE") {
                        continue;
                    } else {
                        if ($part_numberv['part_object']->subtype == "PLAIN") {
                            continue;
                        } else {

                            $message[$part_numberk] = imap_fetchbody($inbox, $email_number, $part_numberv['part_number']);
                            switch ($part_numberv['part_object']->encoding) {
                                # 7BIT
                                case 0:
                                    $mailbox['tHtmlBody'][$part_numberk] = $message[$part_numberk];
                                    break;
                                # 8BIT
                                case 1:
                                    $mailbox['tHtmlBody'][$part_numberk] = quoted_printable_decode(imap_8bit($message[$part_numberk]));
                                    break;
                                # BINARY
                                case 2:
                                    $mailbox['tHtmlBody'][$part_numberk] = imap_binary($message[$part_numberk]);
                                    break;
                                # BASE64
                                case 3:
                                    $img = imap_base64($message[$part_numberk]);
                                    $path = $this->CI->config->item('upload_path') . 'mailbox';
                                    if (strtoupper($part_numberv['part_object']->disposition) == "ATTACHMENT" || $part_numberv['part_object']->ifid == '0') {
                                        $this->CI->general->createfolder($path . '/attachment/' . $result);
                                        file_put_contents($path . '/attachment/' . $result . '/' . $part_numberv['part_object']->parameters[0]->value, $img);
                                        $attach['iMailboxId'] = $result;
                                        $attach['vFileName'] = $part_numberv['part_object']->parameters[0]->value;
                                        $resultattach = $this->CI->model_mailbox->insertAttachment($attach);
                                        $mailbox['hasAttachment'] = '1';
                                        if ($mailbox['vAttachmentId'] != '') {
                                            $mailbox['vAttachmentId'].=',' . $resultattach;
                                        } else {
                                            $mailbox['vAttachmentId'] = $resultattach;
                                        }
                                    } elseif (strtoupper($part_numberv['part_object']->disposition) == "INLINE" || $part_numberv['part_object']->ifid == '1') {
                                        $this->CI->general->createfolder($path . '/inline/' . $result);
                                        file_put_contents($path . '/inline/' . $result . '/' . $part_numberv['part_object']->parameters[0]->value, $img);
//                                        $inline['iMailboxId'] = $result;
//                                        $inline['vFileName'] = $part_numberv['part_object']->dparameters[0]->value;
//                                        $resultinline = $this->CI->model_mailbox->insertAttachment($inline);
                                        if ($mailbox['tInline'] != '') {
                                            $mailbox['tInline'].=',src="' . $this->CI->config->item('upload_url') . 'mailbox' . '/inline/' . $result . '/' . $part_numberv['part_object']->parameters[0]->value . '"';
                                        } else {
                                            $mailbox['tInline'] = 'src="' . $this->CI->config->item('upload_url') . 'mailbox' . '/inline/' . $result . '/' . $part_numberv['part_object']->parameters[0]->value . '"';
                                        }
                                    }
                                    break;
                                # QUOTED-PRINTABLE
                                case 4:
                                    $mailbox['tHtmlBody'][$part_numberk] = quoted_printable_decode($message[$part_numberk]);
                                    break;
                                # OTHER
                                case 5:
                                    $mailbox['tHtmlBody'][$part_numberk] = $message[$part_numberk];
                                    break;
                                # UNKNOWN
                                default:
                                    $mailbox['tHtmlBody'][$part_numberk] = $message[$part_numberk];
                                    break;
                            }
                        }
                    }
                }
                $mailbox['tHtmlBody'] = implode(";--@--;", $mailbox['tHtmlBody']);
                $t = preg_match_all('/src="cid:(.*)"/Uims', $mailbox['tHtmlBody'], $matches);

                $replace = explode(',', $mailbox['tInline']);
                foreach ($matches[1] as $matchesk => $matchesv) {
                    $search[] = "src=\"cid:$matchesv\"";
                }
                $mailbox['tHtmlBody'] = str_replace($search, $replace, $mailbox['tHtmlBody']);
                $ext_cond = 'iMailboxId = ' . $result;
                $updatemail = $this->CI->model_mailbox->update($mailbox, $ext_cond);
                $mailbox = '';
                $subject = '';
            }
        }
        return;
    }

    function create_part_array($structure, $prefix = "") {
        if (sizeof($structure->parts) > 0) {    // There some sub parts
            foreach ($structure->parts as $count => $part) {
                $this->add_part_to_array($part, $prefix . ($count + 1), $part_array);
            }
        } else {    // Email does not have a seperate mime attachment for text
            $part_array[] = array('part_number' => $prefix . '1', 'part_object' => $obj);
        }
        return $part_array;
    }

// Sub function for create_part_array(). Only called by create_part_array() and itself. 
    function add_part_to_array($obj, $partno, & $part_array) {
        $part_array[] = array('part_number' => $partno, 'part_object' => $obj);
        if ($obj->type == 2) { // Check to see if the part is an attached email message, as in the RFC-822 type
            if (sizeof($obj->parts) > 0) {    // Check to see if the email has parts
                foreach ($obj->parts as $count => $part) {
                    // Iterate here again to compensate for the broken way that imap_fetchbody() handles attachments
                    if (sizeof($part->parts) > 0) {
                        foreach ($part->parts as $count2 => $part2) {
                            $this->add_part_to_array($part2, $partno . "." . ($count2 + 1), $part_array);
                        }
                    } else {    // Attached email does not have a seperate mime attachment for text
                        $part_array[] = array('part_number' => $partno . '.' . ($count + 1), 'part_object' => $obj);
                    }
                }
            } else {    // Not sure if this is possible
                $part_array[] = array('part_number' => $prefix . '.1', 'part_object' => $obj);
            }
        } else {    // If there are more sub-parts, expand them out.
            if (sizeof($obj->parts) > 0) {
                foreach ($obj->parts as $count => $p) {
                    $this->add_part_to_array($p, $partno . "." . ($count + 1), $part_array);
                }
            }
        }
    }

}
