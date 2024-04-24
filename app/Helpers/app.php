<?php 

function saveFile($file){
    $file_name  = date("Y_m_d_His_") . $file->getClientOriginalName();
    $path = $file->move('uploads/images/cars', $file_name)->getPath();
    $image = "$path/$file_name";
    return $image;
}