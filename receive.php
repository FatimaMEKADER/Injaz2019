<?php

   foreach ($_FILES['Image']['tmp_name'] as $key=>$tmp_name) {
        echo 'Inside foreach loop '.$key.' File name: '.$_FILES['Image']['name'][$key].' <br />';
        if ($_FILES['Image']['error'][$key] > 0) {
            $imageError = true;
            $imageMessage = 'There was a problem with the image '.$_FILES['Image']['error'][$key].' File number: '.$key.' File name: '.$_FILES['Image']['name'][$key];
            echo $imageMessage.'<br />';
        } elseif (getimagesize($_FILES['Image']['tmp_name'][$key]) == false) {
            $imageError = true;
            $imageMessage = 'You did not uploaded an image.'.' File number: '.$key.' File name: '.$_FILES['Image']['name'][$key];
            echo $imageMessage.'<br />';
        } else {
            $temp = explode('.', $_FILES['Image']['name'][$key]);
            $imageName = round(microtime(true)).$key.'.'.end($temp);
            $imageType = $_FILES['Image']['type'][$key];
            $imageSize = $_FILES['Image']['size'][$key];
            $imageTempName = $_FILES['Image']['tmp_name'][$key];
            $validTypes = ['gif', 'jpg', 'jpe', 'jpeg', 'png'];
            $typeExt = pathinfo($imageName);
            $ext = strtolower($typeExt['extension']);
            if (!in_array($ext, $validTypes)) {
                $imageError = true;
                $imageMessage = 'File uploaded is not a valid image type.'.' File number: '.$key.' File name: '.$_FILES['Image']['name'][$key];
                echo $imageMessage.'<br />';
               
            } else {
                $directory = dirname(__FILE__).'/images/';
                if (strlen($imageName) > 225) {
                    $imageName = substr($imageName, -225);
                }
                $file_result =
                'Upload: '.$imageName.'<br />'.
                'Type: '.$imageType.'<br />'.
                'Size: '.$imageSize.' kb <br />'.
                'Temp file: '.$imageTempName.'<br />'.
                'Upload Directory: '.$directory.$imageName.'<br />';
                echo $file_result;
              
                if (move_uploaded_file($_FILES['Image']['tmp_name'][$key], $directory.$imageName) === true) {
                    $imageError = false;
                     $imageMessage = 'Image uploaded successfully.'.' File number: '.$key.' File name: '.$_FILES['Image']['name'][$key];
                    echo $imageMessage.'<br />';
                  
                } else {
                    $imageError = true;
                    $imageMessage = 'File was not uploaded successfully.'.' File number: '.$key.' File name: '.$_FILES['Image']['name'][$key];
                    echo $imageMessage.'<br /><br />';
                }
            }
        }
    }