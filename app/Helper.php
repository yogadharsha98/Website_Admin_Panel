<?php

/*
*
* INFOATCLUSTER TECHNOLABS LLP ("COMPANY") CONFIDENTIAL
* Copyright (c) 2016-2017 INFOATCLUSTER TECHNOLABS LLP, All Rights Reserved.
*
* NOTICE:  All information contained herein is, and remains the property of INFOATCLUSTER TECHNOLABS LLP. The intellectual and technical concepts contained
* herein are proprietary to INFOATCLUSTER TECHNOLABS LLP and may be covered by Indian and Foreign Patents, patents in process, and are protected by trade secret or copyright law.
* Dissemination of this information or reproduction of this material is strictly forbidden unless prior written permission is obtained
* from COMPANY.  Access to the source code contained herein is hereby forbidden to anyone except current COMPANY employees, managers or contractors who have executed 
* Confidentiality and Non-disclosure agreements explicitly covering such access.
*
* The copyright notice above does not evidence any actual or intended publication or disclosure  of  this source code, which includes  
* information that is confidential and/or proprietary, and is a trade secret, of  COMPANY.   ANY REPRODUCTION, MODIFICATION, DISTRIBUTION, PUBLIC  PERFORMANCE, 
* OR PUBLIC DISPLAY OF OR THROUGH USE  OF THIS  SOURCE CODE  WITHOUT  THE EXPRESS WRITTEN CONSENT OF COMPANY IS STRICTLY PROHIBITED, AND IN VIOLATION OF APPLICABLE 
* LAWS AND INTERNATIONAL TREATIES.  THE RECEIPT OR POSSESSION OF  THIS SOURCE CODE AND/OR RELATED INFORMATION DOES NOT CONVEY OR IMPLY ANY RIGHTS  
* TO REPRODUCE, DISCLOSE OR DISTRIBUTE ITS CONTENTS, OR TO MANUFACTURE, USE, OR SELL ANYTHING THAT IT  MAY DESCRIBE, IN WHOLE OR IN PART.                
*
*
* @author Mohammed Shayas M K
* 
*/
namespace App;
Class Helper
{
    function changeSerialzeArrayValues($data, $type = null)
    {
        $return = array();
        foreach($data AS $key => $value)
        {
            if(trim($value['value']) == null)
            {
                $return[$value['name']] = '';
            }
            else
            {
                $return[$value['name']] = $value['value'];
            }
            
        }
        
        
        
        return $return;
    }
   
    
    function checkFields($inputFields, $requiredFields)
    {
        foreach($requiredFields AS $field)
        {
            if(!isset($inputFields[$field]))
            {
                if(!is_null($inputFields[$field]))
                {
                    return 'Something Went Wrong';
                    exit;
                }
            }
        }
//        
//        $requiredFieldsFlip = array_flip($requiredFields);
//        foreach($inputFields AS $key => $field)
//        {
//            if(!isset($requiredFieldsFlip[$key]))
//            {
//                return 'Something Went Wrong1';
//                exit;
//            }
//        }
    }
}
