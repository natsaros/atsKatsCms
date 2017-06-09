<?php

class Email {
    private $from;
    private $to;
    private $subject;
    private $body;
    private $headers;

    /**
     * Email constructor.
     */
    public function __construct() {
    }

    /**
     * @return Email
     */
    public static function create() {
        $instance = new self();
        return $instance;
    }

    /**
     * @param $from
     * @param $to
     * @param $subject
     * @param $body
     * @param $headers
     * @return Email
     */
    public static function createFull($from, $to, $subject, $body, $headers) {
        return self::create()->setTo($to)->setFrom($from)->setSubject($subject)->setBody($body)->setHeaders($headers);
    }

    /**
     * @param mixed $from
     * @return Email
     */
    public function setFrom($from) {
        $this->from = $from;
        return $this;
    }

    /**
     * @param mixed $to
     * @return Email
     */
    public function setTo($to) {
        $this->to = $to;
        return $this;
    }

    /**
     * @param mixed $subject
     * @return Email
     */
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param mixed $headers
     * @return Email
     */
    public function setHeaders($headers) {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param mixed $body
     * @return Email
     */
    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getTo() {
        return $this->to;
    }

    /**
     * @return mixed
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getHeaders() {
        return $this->headers;
    }


}