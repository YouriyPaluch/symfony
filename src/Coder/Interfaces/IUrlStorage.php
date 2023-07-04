<?php

namespace App\Coder\Interfaces;

use Exception;

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
     * @return void
     * @throws Exception
     */
	public function saveEntity(array $data): void;
}