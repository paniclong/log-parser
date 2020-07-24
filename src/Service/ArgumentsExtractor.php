<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Service;

use App\Exception\ArgumentNotFoundException;

class ArgumentsExtractor
{
    private const COMMAND_ARGUMENT = 1;
    private const COUNT_ARGUMENT = 2;
    private const DUMMY_PATH_ARGUMENT = 3;
    private const PATH_ARGUMENT = 1;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return string
     *
     * @throws ArgumentNotFoundException
     */
    public function getCommand(): ?string
    {
        if ($this->isIsset(self::COMMAND_ARGUMENT)) {
            return (string)$this->arguments[self::COMMAND_ARGUMENT];
        }

        $this->generateException(self::COMMAND_ARGUMENT);
    }

    /**
     * @return int
     *
     * @throws ArgumentNotFoundException
     */
    public function getCount(): int
    {
        if ($this->isIsset(self::COUNT_ARGUMENT)) {
            return (string)$this->arguments[self::COUNT_ARGUMENT];
        }

        $this->generateException(self::COUNT_ARGUMENT);
    }

    /**
     * @return string
     *
     * @throws ArgumentNotFoundException
     */
    public function getPath(): string
    {
        if ($this->isIsset(self::PATH_ARGUMENT)) {
            return (string)$this->arguments[self::PATH_ARGUMENT];
        }

        $this->generateException(self::PATH_ARGUMENT);
    }

    /**
     * @return string
     *
     * @throws ArgumentNotFoundException
     */
    public function getPathForDummyFile(): string
    {
        if ($this->isIsset(self::DUMMY_PATH_ARGUMENT)) {
            return (string)$this->arguments[self::DUMMY_PATH_ARGUMENT];
        }

        $this->generateException(self::DUMMY_PATH_ARGUMENT);
    }

    /**
     * @param int $position
     *
     * @return bool
     */
    private function isIsset(int $position): bool
    {
        return isset($this->arguments[$position]);
    }

    /**
     * @param int $position
     *
     * @throws ArgumentNotFoundException
     */
    private function generateException(int $position): void
    {
        throw new ArgumentNotFoundException(
            sprintf('Position %d not found in arguments %s', $position, json_encode($this->arguments))
        );
    }
}
