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

$credentials = new Aws\Credentials\Credentials('SECRET', 'SECRET');

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
              
            try{
                $result = $SesClient->listIdentities([
'IdentityType' => 'Domain',
    'MaxItems' => 1000,
    // MaxItems is 1000
    'NextToken' => '',
]);
                var_dump($result);
            } catch (AwsException $e){
                // output error message if fails
                echo $e->getMessage();
                echo "\n";
            }
        }

    ?>


