<?php

/**
 * This file works with Amazon Simple Email Service to send formatted contact form submissions with a bunch of optional fields
 * and attaches any uploaded files to the message.
 *
 * Since this was a part of a Laravel project, I probably could have used a Blade template instead of the mess of 
 * markup inside of buildContent. On the other hand, that would restrict me to HTML emails only, so I could go
 * either way on that one.
 *
 * Written by Tom Lagier
 */

require_once('mime.php');

class EmailHelper{
    
    public static function sendEmail($data) {

        $SES = AWS::get('ses');

        $email = new Mail_mime(array('eol' => "\n"));
        
        //Generate subject
        $rawSubject = $data['subject'];

        switch($rawSubject){
            case 'store_information':
                $subject = "Web Form - Store";
                break;
            case 'product_enquiries':
                $subject = "Web Form - Product";
                break;
            case 'company_feedback':
                $subject = "Web Form - Corporate";
                break;
            case 'donations':
                $subject = "Web Form - Donations";
                break;
            case 'employment_enquiries':
                $subject = "Web Form - Careers";
                break;
            case 'technical_assistance':
                $subject = "Web Form - Technical";
                break;
            case 'other':
                $subject = "Web Form - Other";
                break;
            default:
                $subject = "Web Form - Other";
                break;
        }

        //Generate body
        $rawBody = EmailHelper::buildContent($data);
        $email->setTxtBody($rawBody);

        //Attach files
        if(isset($data['files'])){

            foreach($data['files'] as $file ){

                $email->addAttachment($file['path'], $file['mime']);
            }

        }

        //Generate headers
        $headers = $email->txtHeaders(
            array(
                'From' => Config::get('email.from_name').'<'.Config::get('email.from_address').'>', 
                'Subject' => $subject,
                'To' => Config::get('email.to_address_string')
            ));

        //Generate body
        $body = $email->get();

        //Compose raw message
        $message = $headers . "\r\n" . $body;

        //Send messasge
        $SES->SendRawEmail(
            array(
                'Source' => Config::get('email.from_address'), 
                'RawMessage' => array('Data' => base64_encode($message)), 
                'Destinations' => Config::get('email.to_address')
            ));
    }
    
    private static function buildContent($data){
        $content = '';

        $content .= 'Received = ' . date('m/d/Y') . PHP_EOL;
        $content .= 'TimeRecvd = ' . date('H:i') . PHP_EOL;
        $content .= 'Priority = CORP - Social Media' . PHP_EOL;
        $content .= 'FirstName = ' . $data['first_name'] . PHP_EOL;
        $content .= 'LastName = ' . $data['last_name'] .PHP_EOL;
        $content .= 'Salutation = ' . $data['salutation'] . PHP_EOL;
        $content .= 'Address = ' . $data['address_1'] . PHP_EOL;
        $content .= 'City = ' . $data['city'] . PHP_EOL;
        $content .= 'State = ' . $data['state'] . PHP_EOL;
        $content .= 'Zip = ' . $data['zip'] . PHP_EOL;
        $content .= 'Country = ' . $data['country'] . PHP_EOL;
        $content .= 'Phone = ' . str_replace(array("(", ")"), "", $data['telephone']) . PHP_EOL;
        $content .= 'Email = ' . $data['email'] . PHP_EOL;
        $content .= 'Info1 = ' . (isset($data['est']) ? $data['est'] : "" ) . PHP_EOL;
        $content .= 'Info2 = ' . (isset($data['bbd']) ? $data['bbd'] : "" ) . PHP_EOL;
        $content .= 'Info3 = ' . (isset($data['purchase_date']) ? $data['purchase_date'] : "" ) . PHP_EOL;
        $content .= 'Info4 = ' . (isset($data['use_date']) ? $data['use_date'] : "" ) . PHP_EOL;
        $content .= 'Reference2 = ' . (isset($data['upc']) ? $data['upc'] : "" ) . PHP_EOL;
        $content .= 'Product = ' . $data['store_address'] . ' ' . $data['store_city'] . ' ' . $data['store_state'] . (isset($data['brand_name']) ? ' ' . $data['brand_name'] : '') . (isset($data['product_description']) ? ' ' . $data['product_description'] : '') . '~' . PHP_EOL;
        $content .= 'Problem = ' . $data['comments'] . '~' . PHP_EOL;

        return $content;
    }

}