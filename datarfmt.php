<?php
$usage = "
  Usage: php $argv[0] [-h]
Version: v0.0.1-241109
  About: $argv[0] facilitates reformatting between data formats
 Author: Ian Low | Date: 2024-11-09 | Copyright (c) 2024 Ian Low | Usage Rights: MIT License
Options:
    -h      Display help information including run options
    -n      Create a new instance
    -TXTaTbTc2JSKVc:aTb   TXT tab-delimited columns a, b, and c to JavaScript key-value literal array where key 'c' maps to values 'a<tab>b'    
";
if(isset($argv[1])){
  if($argv[1]=="-h"){
    echo $usage;
  }else if($argv[1]=="-n"){  
    echo "Please enter the following information or press 'Enter' for default...\n";
    echo "Project name (defaults to 'myprojphp'): "; $projname = trim(readline());
    if($projname=="") $projname = "myprojphp";
  }else if($argv[1]=="-TXTaTbTc2JSKVc:aTb"){  
    if(!file_exists("./input.txt")){
      echo "File 'input.txt' does not exist!";
      exit;
    }
    echo "File 'input.txt' found!\n";
    $alines = explode("\n", file_get_contents("./input.txt")); 
    echo count($alines);
    $count = 0;
    $outstr = ""; 
    $lastkey = "";
    foreach($alines as $line){
      $line = trim(preg_replace("/\"/", "'", $line));
      if($line=="") continue;
      $acols = explode("\t", $line);
      if(!isset($acols[1])){ 
        echo "Warning - missing offset 1 on line ".$count.":". $line. "\n";
      }else if(!isset($acols[2])){
        echo "Warning - missing offset 2 on line ".$count.":". $line. "\n";
      }else {
        $outstr .= "\"".$acols[2]."\": \"".$acols[0]."\t".$acols[1]."\",\n"; 
        $lastkey = $acols[2];
      }
      //$count++; if($count > 10) break;
    }//endforeach
    file_put_contents("./output.js", 
"const outputjs = {\n". $outstr. "\"\":\"\"};
const outputjs_loaded=true;
if(outputjs_loaded) console.log(outputjs[\"".$lastkey."\"]); ");  
    file_put_contents("./output.html", 
"<!DOCTYPE html><html><head>
<meta name='viewport' content='width=device-width, initial-scale=1' />
</head><body>
<h2 id='h2a'>Waiting 5 secs...</h2>
<script src='./output.js'></script> 
<script> 
  setTimeout(\"test1();\", 5 * 1000);
function test1(){
  const testword = \"ship\";
  document.getElementById('h2a').innerHTML = testword+\" - \" +outputjs[testword];
}
</script> 
</body></html>");
    echo "\noutput files './output.html and ./output.js' created\n";
  }//endif
}
?>
