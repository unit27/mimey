<?php declare(strict_types=1);
/*******************************************************************************
 * Name: App -> Account
 * Version: 1.0.0
 * Author: Przemyslaw Ankowski (przemyslaw.ankowski@gmail.com)
 * Original source code: Ralph Khattar (https://github.com/ralouphie/mimey)
 ******************************************************************************/


// Default namespace
namespace Mimey;


/**
 * An interface for converting between MIME types and file extensions.
 */
interface MimeTypesInterface
{
	/**
	 * Get the first MIME type that matches the given file extension.
	 *
	 * @param string $extension The file extension to check.
	 *
	 * @return string|null The first matching MIME type or null if nothing matches.
	 */
	public function getMimeType(string $extension): ?string;

	/**
	 * Get the first file extension (without the dot) that matches the given MIME type.
	 *
	 * @param string $mime_type The MIME type to check.
	 *
	 * @return string|null The first matching extension or null if nothing matches.
	 */
	public function getExtension(string $mimeType): ?string;

	/**
	 * Get all MIME types that match the given extension.
	 *
	 * @param string $extension The file extension to check.
	 *
	 * @return array An array of MIME types that match the given extension; can be empty.
	 */
	public function getAllMimeTypes(string $extension): array;

	/**
	 * Get all file extensions (without the dots) that match the given MIME type.
	 *
	 * @param string $mime_type The MIME type to check.
	 *
	 * @return array An array of file extensions that match the given MIME type; can be empty.
	 */
	public function getAllExtensions(string $mimeType): array;
}
