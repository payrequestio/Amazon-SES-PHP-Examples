<?php
/**
 * Copyright 2010-2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * This file is licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License. A copy of
 * the License is located at
 *
 * http://aws.amazon.com/apache2.0/
 *
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 *
 * ABOUT THIS PHP SAMPLE => This sample is part of the SDK for PHP Developer Guide topic at
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/ses-verify.html
 *
 */
// snippet-start:[ses.php.add_domain.complete]
// snippet-start:[ses.php.add_domain.import]

require 'vendor/autoload.php';

$credentials = new Aws\Credentials\Credentials('XXXXXXX', 'XXXXXX');

use Aws\Ses\SesClient; 
use Aws\Exception\AwsException;
// snippet-end:[ses.php.add_domain.import]

//Create a SESClient 
// snippet-start:[ses.php.add_domain.main]
$SesClient = new Aws\Ses\SesClient([
    'version' => 'latest',
    'credentials' => $credentials ,
    'region' => 'eu-west-1'
]);

if(isset($_POST['name'])){
    $domain = $_POST['name'];
    try{
$result = $SesClient->setIdentityNotificationTopic([
    'Identity' => $domain, // REQUIRED
    'NotificationType' => 'Complaint', // REQUIRED
    'SnsTopic' => 'arn:aws:sns:eu-west-1:XXXXXXX:Bounce',
]);

        
        $status = $result['VerificationAttributes'][$domain]['VerificationStatus'];
        $token = $result['setIdentityNotificationTopic'][$domain]['GetIdentityPoliciesResponse'];
        print "<p>";
        print "<h3>Update: voor $domain <span class=\"badge badge-secondary\">";
        print $status. PHP_EOL;
        print "</span></h3>";
        print ' <b> Complaint Notifications SNS Topic updated! </b>'.$token.PHP_EOL;
        print "</p>";
    } catch (AwsException $e){
        // output error message if fails
        echo $e->getMessage();
        echo "\n";
    }
}else{

    if(php_sapi_name() === 'cli'){

        $file = file_get_contents("domains.txt");
        $re = '/[\n\s\r]+/m';

        $domains = explode(",",preg_replace($re, ",", $file));
        foreach($domains as $i=>$domain){
                if($i % 5 != 0 && $i!=0)
                sleep(2);
              
            try{
                $result = $SesClient->setIdentityNotificationTopic([
    'Identity' => $domain, // REQUIRED
    'NotificationType' => 'Complaint', // REQUIRED
    'SnsTopic' => 'arn:aws:sns:eu-west-1:XXXXXXX:Bounce',
]);
                $result2 = $SesClient->verifyDomainIdentity(['Domain' => $domain,]);
                print "<p>";
                var_dump($result2);
                print "</p>";
            } catch (AwsException $e){
                // output error message if fails
                echo $e->getMessage();
                echo "\n";
            }
        }
    }
    ?>


  
    <?php
}

?>
