<?php

function asLetters($number) {
    
    $num[17] = array('Zero', 'Un', 'Deux', 'Trois', 'Quatre', 'Cinq', 'Six', 'Sept', 'Huit',
                     'Neuf', 'Dix', 'Onze', 'Douze', 'Treize', 'Quatorze', 'Quinze', 'Seize');
                      
    $num[100] = array(20 => 'Vingt', 30 => 'Trente', 40 => 'Quarante', 50 => 'Cinquante',
                      60 => 'Soixante', 70 => 'Soixante-Dix', 80 => 'Quatre-Vingt', 90 => 'Quatre-Vingt-Dix');
                                      
    if ($number < 17) {
      return $num[17][$number];
    }
    elseif ($number < 20) {
      return 'Dix-'.asLetters($number-10);
    }
    elseif ($number < 100) {
      if ($number%10 == 0) {
        return $num[100][$number];
      }
      elseif (substr($number, -1) == 1) {
        if( ((int)($number/10)*10)<70 ){
          return asLetters((int)($number/10)*10).'-Et-Un';
        }
        elseif ($number == 71) {
          return 'Soixante-Et-Onze';
        }
        elseif ($number == 81) {
          return 'Quatre-Vingt-Un';
        }
        elseif ($number == 91) {
          return 'Quatre-Vingt-Onze';
        }
      }
      elseif ($number < 70) {
        return asLetters($number-$number%10).'-'.asLetters($number%10);
      }
      elseif ($number < 80) {
        return asLetters(60).'-'.asLetters($number%20);
      }
      else {
        return asLetters(80).'-'.asLetters($number%20);
      }
    }
    elseif ($number == 100) {
      return 'Cent';
    }
    elseif ($number < 200) {
      return asLetters(100).' '.asLetters($number%100);
    }
    elseif ($number < 1000) {
      return asLetters((int)($number/100)).' '.asLetters(100).($number%100 > 0 ? ' '.asLetters($number%100): '');
    }
    elseif ($number == 1000){
      return 'Mille';
    }
    elseif ($number < 2000) {
      return asLetters(1000).' '.asLetters($number%1000).' ';
    }
    elseif ($number < 1000000) {
      return asLetters((int)($number/1000)).' '.asLetters(1000).($number%1000 > 0 ? ' '.asLetters($number%1000): '');
    }
    elseif ($number == 1000000) {
      return 'Millions';
    }
    elseif ($number < 2000000) {
      return asLetters(1000000).' '.asLetters($number%1000000);
    }
    elseif ($number < 1000000000) {
      return asLetters((int)($number/1000000)).' '.asLetters(1000000).($number%1000000 > 0 ? ' '.asLetters($number%1000000): '');
    }
  }

  function Months($Month)
  {
    $Mois[12] = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');

    return $Mois[12][$Month - 1];
  }

  function Heure($H) {
    $convert = explode(":", $H);
    //$Heures[16] = array('Une', 'Deux', 'Trois', 'Quatre', 'Cinq', 'Six', 'Sept', 'Huit',
                    // 'Neuf', 'Dix', 'Onze', 'Douze', 'Treize', 'Quatorze', 'Quinze', 'Seize',);
                      
    $Heur = $convert[0];
    $Min = $convert[1];
    
    if ($Heur != "01" && $Heur != "00")
    {
      if ($Min!="00")
      {
        return asLetters($Heur) . " Heures " . asLetters($Min);
      }
      else
      {
        return asLetters($Heur) . " Heures";
      }
    }

    elseif ($Heur = "00" && $Heur != "01")
    {
      if ($Min!="00")
      {
        return "Minuit " . asLetters($Min);
      }
      else
      {
        return "Minuit";
      }
    }
    
    elseif ($Heur = "01")
    {
      if ($Min!="00")
      {
        return "Une Heure " . asLetters($Min);
      }
      else
      {
        return "Une Heure ";
      }
    }                 
  }
  ?>