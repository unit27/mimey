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
 * Class for converting MIME types to file extensions and vice versa.
 */
class MimeTypes implements MimeTypesInterface
{
	/** @var array|null The cached built-in mapping array. */
	private static ?array $builtIn = null;

	/** @var array The mapping array. */
	protected array $mapping;


	/**
	 * Create a new mime types instance with the given mappings.
	 *
	 * If no mappings are defined, they will default to the ones included with this package.
	 *
	 * @param array $mapping An associative array containing two entries.
	 * Entry "mimes" being an associative array of extension to array of MIME types.
	 * Entry "extensions" being an associative array of MIME type to array of extensions.
	 * Example:
	 * <code>
	 * array(
	 *   "extensions" => array(
	 *     "application/json" => array("json"),
	 *     "image/jpeg"       => array("jpg", "jpeg"),
	 *     ...
	 *   ),
	 *   "mimes" => array(
	 *     "json" => array("application/json"),
	 *     "jpeg" => array("image/jpeg"),
	 *     ...
	 *   )
	 * )
	 * </code>
	 */
	public function __construct(array $mapping = null) {
		if ($mapping === null) {
			$this->mapping = self::getBuiltIn();
		} else {
			$this->mapping = $mapping;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function getMimeType(string $extension): ?string {
		$extension = $this->cleanInput($extension);

		if (!empty($this->mapping["mimes"][$extension])) {
			return $this->mapping["mimes"][$extension][0];
		}

		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getExtension(string $mimeType): ?string {
		$mimeType = $this->cleanInput($mimeType);

		if (!empty($this->mapping["extensions"][$mimeType])) {
			return $this->mapping["extensions"][$mimeType][0];
		}

		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getAllMimeTypes(string $extension): array {
		$extension = $this->cleanInput($extension);

		if (isset($this->mapping["mimes"][$extension])) {
			return $this->mapping["mimes"][$extension];
		}

		return [];
	}

	/**
	 * @inheritdoc
	 */
	public function getAllExtensions(string $mimeType): array {
		$mimeType = $this->cleanInput($mimeType);

		if (isset($this->mapping["extensions"][$mimeType])) {
			return $this->mapping["extensions"][$mimeType];
		}

		return [];
	}

	/**
	 * Get the built-in mapping.
	 *
	 * @return array The built-in mapping.
	 */
	protected static function getBuiltIn(): array {
		if (self::$builtIn === null) {
			self::$builtIn = require(\dirname(__DIR__) . "/mime.types.php");
		}

		return self::$builtIn;
	}

	/**
	 * Normalize the input string using lowercase/trim.
	 *
	 * @param string $input The string to normalize.
	 *
	 * @return string The normalized string.
	 */
	private function cleanInput(string $input): string {
		return \strtolower(\trim($input));
	}
}
