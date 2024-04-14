<?php

class Requests_Cookie_Jar implements ArrayAccess, IteratorAggregate
{
	protected $cookies = array();

	public function __construct($cookies = array())
	{
		$this->cookies = $cookies;
	}

	public function normalize_cookie($cookie, $key = null): Requests_Cookie
	{
		if ($cookie instanceof Requests_Cookie) {
			return $cookie;
		}

		return Requests_Cookie::parse($cookie, $key);
	}

	public function normalizeCookie($cookie, $key = null): Requests_Cookie
	{
		return $this->normalize_cookie($cookie, $key);
	}

	public function offsetExists($key): bool
	{
		return isset($this->cookies[$key]);
	}

	public function offsetGet($key): ?string
	{
		if (!isset($this->cookies[$key])) {
			return null;
		}

		return $this->cookies[$key];
	}

	public function offsetSet($key, $value): void
	{
		if ($key === null) {
			throw new Requests_Exception('Object is a dictionary, not a list', 'invalidset');
		}

		$this->cookies[$key] = $value;
	}

	public function offsetUnset($key): void
	{
		unset($this->cookies[$key]);
	}

	public function getIterator(): ArrayIterator
	{
		return new ArrayIterator($this->cookies);
	}

	public function register(Requests_Hooker $hooks): void
	{
		$hooks->register('requests.before_request', array($this, 'before_request'));
		$hooks->register('requests.before_redirect_check', array($this, 'before_redirect_check'));
	}

	public function before_request($url, &$headers, &$data, &$type, &$options): void
	{
		if (!$url instanceof Requests_IRI) {
			$url = new Requests_IRI($url);
		}

		if (!empty($this->cookies)) {
			$cookies = array();
			foreach ($this->cookies as $key => $cookie) {
				$cookie = $this->normalize_cookie($cookie, $key);

				if ($cookie->is_expired()) {
					continue;
				}

				if ($cookie->domain_matches($url->host)) {
					$cookies[] = $cookie->format_for_header();
				}
			}

			$headers['Cookie'] = implode('; ', $cookies);
		}
	}

	public function before_redirect_check(Requests_Response &$return): void
	{
		$url = $return->url;
		if (!$url instanceof Requests_IRI) {
			$url = new Requests_IRI($url);
		}

		$cookies = Requests_Cookie::parse_from_headers($return->headers, $url);
		$this->cookies = array_merge($this->cookies, $cookies);
		$return->cookies = $this;
	}
}
