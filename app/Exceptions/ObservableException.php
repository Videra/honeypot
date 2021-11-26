<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class ObservableException extends Exception
{
    public function __construct(string $message)
    {
        $this->message = $message;
        parent::__construct();
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return RedirectResponse
     */
    public function render(): RedirectResponse
    {
        return redirect()->back()->with('error', $this->message);
    }
}
