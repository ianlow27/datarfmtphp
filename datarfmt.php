<?php
$usage = "
  Usage: php $argv[0] [-h]
Version: v0.0.1-241109
  About: $argv[0] facilitates reformatting between data formats
 Author: Ian Low | Date: 2024-11-09 | Copyright (c) 2024 Ian Low | Usage Rights: MIT License
Options:
    -h   Display help information including run options
    -n   Create a new instance
";
if(isset($argv[1])){
  if($argv[1]=="-h"){
    echo $usage;
  }else if($argv[1]=="-n"){  
    echo "Please enter the following information or press 'Enter' for default...\n";
    echo "Project name (defaults to 'myprojphp'): "; $projname = trim(readline());
    if($projname=="") $projname = "myprojphp";
  }
}
?>