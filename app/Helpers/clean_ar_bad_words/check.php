<meta charset="utf-8">
<?php 

    /**
        MADE BY : soulaimane takiddine 
        EMAIL : takiddine.job@gmail.com
    **/ 

    // GET THE LIST OF FORBIDDEN WORDS .
    $forbidden_words_array = json_decode(file_get_contents('words.json'));

    $myword = 'مغربية تتناك فى كسها';
    $text = explode(' ',$myword);

    foreach ($text as $word) {
        if(in_array($word,$forbidden_words_array)) {
           return true;
            break;
        }else {
        	return false;
        }
    }

?>