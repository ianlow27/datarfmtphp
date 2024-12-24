<?php
$usage = "
  Usage: php $argv[0] [-h]
Version: v0.0.1-241109
  About: $argv[0] facilitates reformatting between data formats
 Author: Ian Low | Date: 2024-11-09 | Copyright (c) 2024 Ian Low | Usage Rights: MIT License
Options:
    -h - Display help information including run options
    -n - Create a new instance
    -TXTaTbTc2JSKVc:aTb - TXT tab-delimited columns a, b, and c to JavaScript key-value literal array where key 'c' maps to values 'a<tab>b'    
    -txtAtBtC2jsarrastpApBpCpDpEpF - from tab-delimited file of 3 cols AtBtC output to JavaScript pipe-delimited array of *|A|B|C|D|E|F lines where fields D, E, and F default to a single space. 
";

// Get command-line arguments
echo $argc."_".$argv[0]. "_". $argv[1]."\n"; 
$goption=""; 
$gsubopt=""; 
for($i=0; $i<$argc; $i++){
  if  (preg_match("/=/", $argv[$i])){ 
    $atmp1=explode("=", $argv[$i]);
    $goption=$atmp1[0];
    $gsubopt=$atmp1[1];
  //}else if      (substr($argv[$i],0,19) == 
  //  "-TXTaTbTc2JSKVc:aTb"){  
  //  $atmp1=explode("=", $argv[$i]);
  //  $goption=$atmp1[0];
  //  $gsubopt=$atmp1[1];
  }else if(substr($argv[$i],0,2)  == "-h"){  
    $goption=$argv[$i];
  }else if(substr($argv[$i],0,2)  == "-n"){  
    $goption=$argv[$i];
  }else { 
    $goption=$argv[$i];
  }
}//endfor

if($gsubopt=="") $gsubopt="output";

if(isset($goption)){
  if($goption=="-h"){
    echo $usage;
  }else if($goption=="-n"){  
    echo "Please enter the following information or press 'Enter' for default...\n";
    echo "Project name (defaults to 'myprojphp'): "; $projname = trim(readline());
    if($projname=="") $projname = "myprojphp";
  }else if($goption=="-txtAtBtC2jsarrastpApBpCpDpEpF"){ //!!
    $alines = mktxtAtBtCtmpfile($goption, $gsubopt);
    if(!$alines) exit;
    rfmtoutputdata($goption, $gsubopt, $alines);

  }else if($goption=="-TXTaTbTc2JSKVc:aTb"){  
    $alines = mktxtAtBtCtmpfile($goption, $gsubopt);
    if(!$alines) exit;
    rfmtoutputdata($goption, $gsubopt, $alines);
    /* ---------------------------------------------------
    $count = 0;
    $outstr = ""; 
    $lastkey = "";
    $prevkey = "";
    $vcbdata = "";
    foreach($alines as $line){
      $line = trim(preg_replace("/\"/", "'", $line));
      if($line=="") continue;
      $acols = explode("\t", $line);
if($acols[0]=="Europe")
echo "[0]". $lastkey."_". $acols[0]."\n";
      if(!isset($acols[1])){ 
        echo "Warning - missing offset 1 on line ".$count.":". $line. "\n";
      }else if(!isset($acols[2])){
        echo "Warning - missing offset 2 on line ".$count.":". $line. "\n";
      }else {
        // Group entries for same English word into 1 line
        if($lastkey != $acols[0]){
          $outstr .= "\"".$lastkey."\": \"".
              //$acols[1]."\t".
              //$acols[2].
              sortuniq($vcbdata, "/"). 
              "\",\n"; 
          $vcbdata = "";
        }
        if($vcbdata!="") $vcbdata.="/";
        $vcbdata.=$acols[1]."(".$acols[2].")";
        $lastkey = $acols[0];
      }
      //$count++; if($count > 100) break;
    }//endforeach
    if($vcbdata != ""){
      $outstr .= "\"".$lastkey."\": \"".
         sortuniq($vcbdata, "/"). 
         "\",\n"; 
    }
    file_put_contents("./".$gsubopt. ".js", 
"const ".$gsubopt."js  = {\n". $outstr. "\"\":\"\"};
const ". $gsubopt."js_loaded=true;
if(". $gsubopt."js_loaded) console.log(". $gsubopt."js[\"".$lastkey."\"]); ");  
    file_put_contents("./". $gsubopt.".html", 
"<!DOCTYPE html><html><head>
<meta name='viewport' content='width=device-width, initial-scale=1' />
</head><body>
<h2 id='h2a'>Waiting 5 secs...</h2>
<script src='./". $gsubopt.".js'></script> 
<script> 
  setTimeout(\"test1();\", 5 * 1000);
function test1(){
  const testword = \"ship\";
  document.getElementById('h2a').innerHTML = testword+\" - \" +". $gsubopt."js[testword];
}
</script> 
</body></html>");
    echo "\noutput files './". $gsubopt.".html and ./". $gsubopt.".js' created\n";
    --------------------------------------------------- */
  }//endif
}//if(isset($goption))
//---------------------------
function sortuniq($pstr, $pdelim){
  $astr = explode($pdelim, $pstr);
  sort($astr);
  $astr = array_unique($astr);
  $outstr="";
  foreach($astr as $item){
    if($outstr!="") $outstr.=$pdelim;
    $outstr .= $item;
  }//emdforeach
  return $outstr;
}//endfunc
//---------------------------
function mktxtAtBtCtmpfile($goption, $gsubopt){
    if(!file_exists("./input.txt")){
      echo "File 'input.txt' does not exist!";
      exit;
    }
    echo "File 'input.txt' found!\n";
    $alines = explode("\n", file_get_contents("./input.txt")); 
    $count = 0;
    $outstr = ""; 
    $lastkey = "";
    //---------------- 
    // First loop to sort by English
    foreach($alines as $line){
      $line = trim(preg_replace("/\"/", "'", $line));
      if($line=="") continue;
      $acols = explode("\t", $line);
      if(!isset($acols[1])){ 
        echo "Warning - missing offset 1 on line ".$count.":". $line. "\n";
      }else if(!isset($acols[2])){
        echo "Warning - missing offset 2 on line ".$count.":". $line. "\n";
      }else {
        if($goption=="-TXTaTbTc2JSKVc:aTb"){ 
          $outstr .= $acols[2]."\t". $acols[0]."\t". $acols[1]."\n";
        }else if($goption=="-txtAtBtC2jsarrastpApBpCpDpEpF"){ 
          $outstr .= $acols[2]."\t". $acols[0]."\t". $acols[1]."\n";
        }
      }
    }//endforeach
    file_put_contents("./output-tmp1.txt", $outstr); 
    $alines = explode("\n", file_get_contents("./output-tmp1.txt")); 
    sort($alines); 
    $alines = array_unique($alines); 
    //echo count($alines)."____1\n";
    return $alines;
}//endfunc
//---------------------------
function rfmtoutputdata($goption, $gsubopt, $alines){
//if($goption=="-TXTaTbTc2JSKVc:aTb"){ }
//if($goption=="-txtAtBtC2jsarrastpApBpCpDpEpF"){ }
    $count = 0;
    $outstr = ""; 
    $lastkey = "";
    $prevkey = "";
    $vcbdata = "";
    foreach($alines as $line){
      $line = trim(preg_replace("/\"/", "'", $line));
      if($line=="") continue;
      $acols = explode("\t", $line);
if($acols[0]=="Europe")
echo "[0]". $lastkey."_". $acols[0]."\n";
      if(!isset($acols[1])){ 
        echo "Warning - missing offset 1 on line ".$count.":". $line. "\n";
      }else if(!isset($acols[2])){
        echo "Warning - missing offset 2 on line ".$count.":". $line. "\n";
      }else {
      $count++;  //if($count > 100) break;
      if($goption=="-TXTaTbTc2JSKVc:aTb"){ 
        // Group entries for same English word into 1 line
        if($lastkey != $acols[0]){
          $outstr .= "\"".$lastkey."\": \"".
              //$acols[1]."\t".
              //$acols[2].
              sortuniq($vcbdata, "/"). 
              "\",\n"; 
          $vcbdata = "";
        }
        if($vcbdata!="") $vcbdata.="/";
        $vcbdata.=$acols[1]."(".$acols[2].")";
        $lastkey = $acols[0];
      }else if($goption=="-txtAtBtC2jsarrastpApBpCpDpEpF"){ 
        $outstr .= "\"*|".$acols[0]."|".$acols[1]."|".$acols[2].
                   "| | | \",\n";
      }//endif
      }//endif
    }//endforeach
    if($vcbdata != ""){
      $outstr .= "\"".$lastkey."\": \"".
         sortuniq($vcbdata, "/"). 
         "\",\n"; 
    }//endif
  //-----------------------------------
  $testwd="";
  if($goption=="-TXTaTbTc2JSKVc:aTb"){ 
    $testwd="\"ship\"";
    file_put_contents("./".$gsubopt. ".js", 
"const ".$gsubopt."js  = {\n". $outstr. "\"\":\"\"};
const ". $gsubopt."js_loaded=true;
if(". $gsubopt."js_loaded) console.log(". $gsubopt."js[\"".$lastkey."\"]); ");  
  }else if($goption=="-txtAtBtC2jsarrastpApBpCpDpEpF"){ 
    $testwd= (int)($count - 10);
    file_put_contents("./".$gsubopt. ".js", 
"const ".$gsubopt."js  = [\n". $outstr. "\n\"\"];
const ". $gsubopt."js_loaded=true;
if(". $gsubopt."js_loaded) console.log(". $gsubopt."js[\"".($count - 10)."\"]); ");  
  }//endif
  //-----------------------------------
    file_put_contents("./". $gsubopt.".html", 
"<!DOCTYPE html><html><head>
<meta name='viewport' content='width=device-width, initial-scale=1' />
</head><body>
<h2 id='h2a'>Waiting 5 secs...</h2>
<script src='./". $gsubopt.".js'></script> 
<script> 
  setTimeout(\"test1();\", 5 * 1000);
function test1(){
  const testword = ".$testwd. ";
  document.getElementById('h2a').innerHTML = testword+\" - \" +". $gsubopt."js[testword];
}
</script> 
</body></html>");
    echo "\noutput files './". $gsubopt.".html and ./". $gsubopt.".js' created\n";


}//endfunc
//---------------------------
?>
