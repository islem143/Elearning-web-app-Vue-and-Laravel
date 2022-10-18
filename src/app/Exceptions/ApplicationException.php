<?php


namespace App\Exceptions;


use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;

abstract class ApplicationException extends Exception
{

    abstract public function status(): int;

    abstract public function help(): string;

    abstract public function error(): mixed;

    public function render(HttpRequest $request): Response
    {

        $error = new  Error($this->help(), $this->error());
        return response($error->toArray(), $this->status());
    }
}
