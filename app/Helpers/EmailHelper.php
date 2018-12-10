


  public function sendMail($mailFrom,$maileTo, $mailCc,$subject,$content){
        if ($mailFrom == null){
            $mailFrom = '<your maile from address>';
        }
        $message = $this->container['smtpMessage'];
        $message->setFrom($mailFrom);
        if (\is_array($maileTo)){
            foreach ($maileTo as $to){
                $message->addTo($to);
            }
        }else{
            $message->addTo($maileTo);
        }
        if ($mailCc != null) {
            if (\is_array($mailCc)){
                foreach ($mailCc as $cc){
                    $message->addCc($cc);
                }
            }else{
                $message->addCc($mailCc);
            }
        }
        $message->setSubject($subject);
        $message->setHTMLBody($content);
        //$message->addEmbeddedFile(APP_PATH . DS . 'Static' . DS . 'img' . DS . 'spacer.gif');
        $this->container['smtpMailer']->send($message);
    }
    