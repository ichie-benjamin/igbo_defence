<?php


function convertToWord($input): string
{
    return ucwords(str_replace(['_', '-'], ' ', $input));
}
