<?php

namespace Accompli\CredentialStorage;

/**
 * FileCredentialStorage.
 *
 * @author Niels Nijens <nijens.niels@gmail.com>
 */
class FileCredentialStorage extends AbstractCredentialStorage
{
    /**
     *
     */
    public function load()
    {
        $file = $this->workingDirectory.DIRECTORY_SEPARATOR.'accompli.credentials.json';
        if (file_exists($file) === false) {
            return;
        }

        $json = file_get_contents($file);

        $this->validateSyntax($json);

        $this->encryptedStorage = json_decode($json, true);
    }

    /**
     * Validates the syntax of $json.
     *
     * @param string $json
     *
     * @throws ParsingException when the string does not contain valid JSON
     */
    private function validateSyntax($json)
    {
        $parser = new JsonParser();
        $result = $parser->lint($json);
        if ($result === null) {
            return;
        }

        throw new ParsingException(sprintf("The file \"%s\" does not contain valid JSON.\n%s", $this->configurationFile, $result->getMessage()), $result->getDetails());
    }
}
