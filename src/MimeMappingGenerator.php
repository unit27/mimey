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
 * Generates a mapping for use in the MimeTypes class.
 *
 * Reads text in the format of http's mime.types and generates a PHP array containing the mappings.
 */
class MimeMappingGenerator
{
    // Mime types as text
	protected string $mimeTypesText;


	/**
	 * Create a new generator instance with the given mime.types text.
	 *
	 * @param string $mimeTypesText The text from the mime.types file.
	 */
	public function __construct(string $mimeTypesText) {
		$this->mimeTypesText = $mimeTypesText;
	}

	/**
	 * Read the given mime.types text and return a mapping compatible with the MimeTypes class.
	 *
	 * @return array The mapping.
	 */
	public function generateMapping(): array {
		$mapping = [];
		$lines = \explode("\n", $this->mimeTypesText);
		foreach ($lines as $line) {
			$line = \trim(\preg_replace('~\\#.*~', "", $line));
			$parts = $line ? \array_values(\array_filter(\explode("\t", $line))) : [];
			if (\count($parts) === 2) {
				$mime = \trim($parts[0]);
				$extensions = \explode(" ", $parts[1]);
				foreach ($extensions as $extension) {
					$extension = \trim($extension);
					if ($mime && $extension) {
						$mapping["mimes"][$extension][] = $mime;
						$mapping["extensions"][$mime][] = $extension;
						$mapping["mimes"][$extension] = \array_unique($mapping["mimes"][$extension]);
						$mapping["extensions"][$mime] = \array_unique($mapping["extensions"][$mime]);
					}
				}
			}
		}
		return $mapping;
	}

	/**
	 * Read the given mime.types text and generate mapping code.
	 *
	 * @return string The mapping PHP code for inclusion.
	 */
	public function generateMappingCode(): string {
		$mapping = $this->generateMapping();
		$mapping_export = \var_export($mapping, true);
		return "<?php return $mapping_export;";
	}
}
