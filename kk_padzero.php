<?php
function pad_zero_18($number, $length=18, $in_front=TRUE) 
{
    $number = (string)$number;
    $loop = $length - strlen($number);
     
    $result = '';
    for ($i=0; $i<$loop; $i++) 
	{
        $result .= '0';
    }
     
    if ($in_front === TRUE) 
	{
        $result = $result . $number;
    } else 
	{
        // NOL dibelakang
        $result = $number . $result;
    }
     
    return $result;
}

function pad_zero_19($number, $length=19, $in_front=TRUE) 
{
    $number = (string)$number;
    $loop = $length - strlen($number);
     
    $result = '';
    for ($i=0; $i<$loop; $i++) 
	{
        $result .= '0';
    }
     
    if ($in_front === TRUE) 
	{
        $result = $result . $number;
    } else 
	{
        // NOL dibelakang
        $result = $number . $result;
    }
     
    return $result;
}
?>