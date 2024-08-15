<?php
/**
 * WP Travel Engine Email class.
 *
 * @since 6.0.0
 */

namespace WPTravelEngine\Email;

/**
 * Email class.
 *
 * @since 6.0.0
 */
class Email {

	/**
	 * Email from.
	 *
	 * @var array
	 */
	protected array $from = array( 'name' => '', 'email' => '' );

	/**
	 * Email to.
	 *
	 * @var string[]
	 */
	protected array $to = array();

	/**
	 * Email Subject.
	 *
	 * @var string
	 */
	protected string $subject = '';

	/**
	 * Email message.
	 *
	 * @var string
	 */
	protected string $body = '';

	/**
	 * Email headers.
	 *
	 * @var string|string[]
	 */
	protected $headers = array( 'Content-Type: text/html; charset=UTF-8; MIME-Version:1.0' );

	/**
	 * Email attachments.
	 *
	 * @var string|string[]
	 */
	protected $attachments = array();

	/**
	 * Email should use template if available.
	 *
	 * @var ?string Template Name.
	 */
	protected ?string $template = null;

	/**
	 * Email content.
	 *
	 * @return $this
	 */
	public function set( string $property, $value ): Email {
		$this->{$property} = $value;

		return $this;
	}

	/**
	 * Add Headers.
	 *
	 * @param string|array $header Headers
	 *
	 * @return $this
	 */
	public function add_headers( $header ): Email {
		if ( is_array( $header ) ) {
			$this->headers = array_merge( $this->headers, $header );
		} else {
			$this->headers[] = $header;
		}

		return $this;
	}

	/**
	 * Get email property.
	 *
	 * @param string $property Property name.
	 *
	 * @return mixed
	 */
	public function get( string $property ) {

		if ( method_exists( $this, "get_$property" ) ) {
			return $this->{"get_$property"}();
		}

		return $this->{$property} ?? null;
	}

	/**
	 * Send email.
	 *
	 * @return bool
	 */
	public function send() {
		$to          = $this->get( 'to' );
		$subject     = $this->get( 'subject' );
		$body        = $this->get( 'body' );
		$headers     = $this->get( 'headers' );
		$attachments = $this->get( 'attachments' );

		// Send email.
		$result = wp_mail( $to, $subject, $body, $headers, $attachments );

		return compact( 'to', 'subject', 'body', 'headers', 'attachments', 'result' );
	}

}
