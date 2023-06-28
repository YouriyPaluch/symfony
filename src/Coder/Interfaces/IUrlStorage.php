<?php

namespace App\Coder\Interfaces;

interface IUrlStorage {

	/**
	 * @param string $url
	 * @return string
	 */
	public function getCodeByUrl(string $url): string;

	/**
	 * @param string $code
	 * @return string
	 */
	public function getUrlByCode(string $code): string;

	/**
	 * @param array $data
	 * @return bool
	 */
	public function saveEntity(array $data): bool;
}