<?php

namespace Modulus\Utility;

use Modulus\Support\Extendable;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
  use Extendable;

  /**
   * $subject
   *
   * @var string
   */
  private $subject;

  /**
   * $body
   *
   * @var string
   */
  private $body = '';

  /**
   * $bcc
   *
   * @var array
   */
  private $bcc;

  /**
   * $cc
   *
   * @var array
   */
  private $cc;

  /**
   * $to
   *
   * @var array
   */
  private $to;

  /**
   * $replyTo
   *
   * @var array
   */
  private $replyTo;

  /**
   * $attachment
   *
   * @var string
   */
  private $attachment;

  /**
   * $outputdata
   *
   * @var string
   */
  private $outputdata;

  /**
   * $viewLocation
   *
   * @var string
   */
  private $viewLocation;

  /**
   * $viewArgs
   *
   * @var array
   */
  private $viewArgs;

  /**
   * $connection
   *
   * @var string
   */
  private $connection = 'default';

  /**
   * __construct
   *
   * @param ?string $name
   * @return void
   */
  public function __construct(?string $name = null)
  {
    try {
      $this->viewLocation = config('mail.view');
    } catch (\Exception $e) {
      // do nothing...
    }

    $this->connection = ($name == null) ? config('mail.connections.default') : config("mail.connections.{$name}");
  }

  /**
   * Set default connection and return new mail class
   *
   * @param mixed ?string
   * @return void
   */
  public static function connection(?string $name = null) : Mail
  {
    $mail = new Mail($name);
    return $mail;
  }

  /**
   * Set default connection and return new mail class
   *
   * @param mixed ?string
   * @return void
   */
  public static function make(?string $name = null) : Mail
  {
    $mail = new Mail($name);
    return $mail;
  }

  /**
   * Add a line
   *
   * @param string $message
   * @return Mail
   */
  public function line(string $message = null) : Mail
  {
    $this->body .= "<p>{$message}</p>";
    return $this;
  }

  /**
   * Add a separator
   *
   * @param string $message
   * @return Mail
   */
  public function separate() : Mail
  {
    $this->body .= "<hr>";
    return $this;
  }

  /**
   * Add a h3 line
   *
   * @param string $message
   * @return Mail
   */
  public function title(string $message = null) : Mail
  {
    $this->body .= "<h3>{$message}</h3>";
    return $this;
  }

  /**
   * Add a small line
   *
   * @param string $message
   * @return Mail
   */
  public function small(string $message = null) : Mail
  {
    $this->body .= "<small>{$message}</small>";
    return $this;
  }

  /**
   * Create a action
   *
   * @param string $message
   * @param string $link
   * @param string $class
   * @return Mail
   */
  public function action(string $message, string $link, string $class = 'btn btn-primary') : Mail
  {
    $this->body .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"{$class}\">
<tbody>
  <tr>
    <td align=\"left\">
      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tbody>
          <tr>
            <td>
              <a href=\"{$link}\" target=\"_blank\">{$message}</a>
            </td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
</tbody>
</table>
";
    return $this;
  }

  /**
   * Set view email view
   *
   * @param string $view
   * @param array $data
   * @return Mail
   */
  public function view(string $view, array $data = []) : Mail
  {
    $this->viewLocation = $view;
    $this->viewArgs = $data;
    return $this;
  }

  /**
   * Make a view
   *
   * @param mixed $view
   * @param mixed $data
   * @return Mail
   */
  private function render(string $view, $data = []) : Mail
  {
    $body = array(
      'body' => $this->body,
      'subject' => $this->subject
    );

    if ($this->body != null) {
      $data = array_merge($data, $body);
    }

    $this->outputdata = View::make($this->viewLocation, $data, true);
    return $this;
  }

  /**
   * Set email subject
   *
   * @param string $subject
   * @return void
   */
  public function subject(string $subject) : Mail
  {
    $this->subject = $subject;
    return $this;
  }

  /**
   * Add replyTo
   *
   * @param mixed $email
   * @param mixed $name
   * @return void
   */
  public function replyTo(string $email, ?string $name = null)
  {
    $this->replyTo = ['email' => $email, 'name' => $name];
    return $this;
  }

  /**
   * Add attachment
   *
   * @param string $file
   * @param ?string $name
   * @return void
   */
  public function attachment(string $file, ?string $name = null)
  {
    $this->attachment[] = ['file' => $file, 'name' => $name];
    return $this;
  }

  /**
   * Send to
   *
   * @param string $email
   * @param mixed string
   * @return void
   */
  public function to(string $email, ?string $name = null)
  {
    $this->to[] = ['email' => $email, 'name' => $name];
    return $this;
  }

  /**
   * Add bcc
   *
   * @param string $email
   * @param mixed ?string
   * @return void
   */
  public function bcc(string $email, ?string $name = null)
  {
    $this->bcc[] = ['email' => $email, 'name' => $name];
    return $this;
  }

  /**
   * Add cc
   *
   * @param string $email
   * @param mixed ?string
   * @return void
   */
  public function cc(string $email, ?string $name = null)
  {
    $this->cc[] = ['email' => $email, 'name' => $name];
    return $this;
  }

  /**
   * Finally send the email!!!
   *
   * @param mixed ?string
   * @param mixed ?string
   * @return void
   */
  public function send(?string $message = null, ?string $subject = null)
  {
    if ($message != null) {
      $this->body = $message;
    }

    if ($subject != null) {
      $this->subject = $subject;
    }

    if ($this->viewLocation != null || $this->viewLocation !== '') {
      $this->render($this->viewLocation, $this->viewArgs);
    }

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = $this->connection['encryption'];
    $mail->SMTPKeepAlive = true;
    $mail->Host = $this->connection['host'];
    $mail->Port = $this->connection['port'];
    $mail->IsHTML(true);
    $mail->Username = $this->connection['username'];
    $mail->Password = $this->connection['password'];

    $mail->SetFrom($this->connection['from']['address'], $this->connection['from']['name']);

    $mail->Subject = $this->subject;
    $mail->Body = $this->outputdata == null ? $this->body : $this->outputdata;

    if ($this->replyTo != null) {
      $mail->addReplyTo($this->replyTo['email'], $this->replyTo['name']);
    }

    if ($this->to != null) {
      foreach($this->to as $email) {
        $mail->AddAddress($email['email'], $email['name']);
      }
    }

    if ($this->bcc != null) {
      foreach($this->bcc as $email) {
        $mail->addBCC($email['email'], $email['name']);
      }
    }

    if ($this->cc != null) {
      foreach($this->cc as $email) {
        $mail->addCC($email['email'], $email['name']);
      }
    }

    if ($this->attachment != null) {
      foreach($this->attachment as $attachment) {
        $mail->addAttachment($attachment['file'], $attachment['name']);
      }
    }

    if(!$mail->Send()) {
      return ["status" => "failed", "reason" => $mail->ErrorInfo];
    }

    return ["status" => "success"];
  }
}
