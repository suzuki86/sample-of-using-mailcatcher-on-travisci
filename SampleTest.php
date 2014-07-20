<?php

class SampleTest extends PHPUnit_Framework_TestCase{
  public function testMailcatcher(){
    mb_language('ja');
    mb_internal_encoding('UTF-8');
    mb_send_mail('to@example.com', 'test subject', 'test body');
    $messages = json_decode(file_get_contents('http://127.0.0.1:1080/messages'));
    $message = json_decode(file_get_contents('http://127.0.0.1:1080/messages/' . $messages[0]->id . '.json'));
    $this->assertEquals('<to@example.com>', $message->recipients[0]);
    $this->assertEquals('test subject', $message->subject);
    preg_match_all('/\n\n(.*)/', $message->source, $matches);
    $this->assertEquals('test body', mb_convert_encoding($matches[1][0], 'UTF-8', 'ISO-2022-JP'));
  }
}
