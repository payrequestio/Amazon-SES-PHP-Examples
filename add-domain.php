<form action="#" method="post" class="form-signin" _lpchecked="1">
<h1 class="h3 mb-3 font-weight-normal">Your domain</h1>
<input type="text" name="name" id="inputEmail" class="form-control" placeholder="Domeinnaam.ml" required="" autofocus="" autocomplete="off">
<input class="btn btn-lg btn-primary btn-block" type="submit">
</form>

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

$credentials = new Aws\Credentials\Credentials('key', 'key');

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
        $result2 = $SesClient->verifyDomainIdentity(['Domain' => $domain,]);
	    $result3 = $SesClient->verifyDomainDkim(['Domain' => $domain,]);
        $result = $SesClient->getIdentityVerificationAttributes([
            'Identities' => [
                $domain,
            ],
        ]);
	    
	    $status = $result['VerificationAttributes'][$domain]['VerificationStatus'];
	    $token = $result['VerificationAttributes'][$domain]['VerificationToken'];
        print "<p>";
	    print "<h3>Status: voor $domain <span class=\"badge badge-secondary\">";
	    print $status. PHP_EOL;
        print "</span></h3>";
        print ' <b> Token: </b>'.$token.PHP_EOL;
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
                $result2 = $SesClient->verifyDomainIdentity(['Domain' => $domain,]);
                $result = $SesClient->getIdentityVerificationAttributes([
                    'Identities' => [
                        $domain,
                    ],
                ]);
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
