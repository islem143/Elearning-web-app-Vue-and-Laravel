<?php


namespace App\Exceptions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Error implements Arrayable, Jsonable, JsonSerializable
{
    private string $help;
    private string $error;
    public function __construct(string $help = "", $error = "")
    {
        $this->help = $help;
        $this->error = $error;
    }

    public function toArray(): array
    {
        return [
            "error" => $this->error,
            //'help' => $this->help
        ];
    }
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0.0)
    {
        $jsonEncoded = json_encode($this->jsonSerialize(), $options);
        throw_unless($jsonEncoded, JsonEncodeException::class);
        return $jsonEncoded;
    }
}
