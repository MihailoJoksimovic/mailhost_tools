<?php

namespace Mixa\Mailing;

class MailhostChecker
{
    const ERROR_NO_MX_HOST          = 'no_mx_host';

    const ERROR_CANT_CONNECT_TO_MX  = 'cant_connect_to_mx';

    /**
     * @var \PHPMailer
     */
    private $phpmailer;

    private $last_error = false;

    public function __construct(\PHPMailer $phpmailer = false)
    {
        $this->setPhpmailer($phpmailer);
    }

    public function checkEmailWorks($emailAddress)
    {
        list ($address, $hostname) = explode("@", $emailAddress);

        $dns_recs   = dns_get_record($hostname, DNS_MX);

        if (empty($dns_recs)) {
            $this->setLastError(self::ERROR_NO_MX_HOST);

            return false;
        }

        // Try connecting to the MX host
        $telnet_address     = $hostname . ':25';
        $errorNum           = null;
        $errorString        = null;

        $conn = stream_socket_client($telnet_address, $errorNum, $errorString, 10);

        if (empty($conn)) {
            $this->setLastError(self::ERROR_CANT_CONNECT_TO_MX);

            return false;
        }

        return true;
    }

    /**
     * @param \PHPMailer $phpmailer
     */
    public function setPhpmailer($phpmailer)
    {
        $this->phpmailer = $phpmailer;
    }

    /**
     * @return \PHPMailer
     */
    public function getPhpmailer()
    {
        return $this->phpmailer;
    }

    /**
     * @param boolean $last_error
     */
    public function setLastError($last_error)
    {
        $this->last_error = $last_error;
    }

    /**
     * @return boolean
     */
    public function getLastError()
    {
        return $this->last_error;
    }


}