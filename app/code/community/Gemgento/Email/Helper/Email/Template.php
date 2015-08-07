<?php

class Gemgento_Email_Helper_Email_Template extends Mage_Core_Helper_Abstract
{

    public function sendSalesEmail($path, $data) {
        $this->send("email/sales/{$path}", $data);
    }

    public function send($path, $data) {
        Mage::getModel('gemgento_push/observer')->push('POST', $path, '', $data);
    }

    public function recipientStrings($emails, $names = [])
    {
        $recipients = array();

        if (is_array($emails)) {

            foreach ($emails as $key => $email) {

                if (!empty($names[$key])) {
                    $recipients[] = "\"{$names[$key]}\" <{$email}>";
                } else {
                    $recipients[] = $email;
                }
            }

        } else {

            if (!empty($names)) {
                $recipients[] = "\"{$names}\" <$emails>";
            } else {
                $recipients[] = $emails;
            }
        }

        return $recipients;
    }

    public function isExcluded($code) {
        $excludedCodes = explode(',', Mage::getStoreConfig("gemgento_email/settings/excluded_codes"));
        $excludedCodes = array_map('trim', $excludedCodes);

        return in_array($code, $excludedCodes);
    }

    public function code($template) {
        $code = $template->getTemplateId();

        if (is_numeric($code)) {
            $code = $template->getOrigTemplateCode();
        }

        if (empty($code)) {
            $code = $template->getTemplateCode();
        }

        return $code;
    }

}
