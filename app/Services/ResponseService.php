<?php

namespace App\Services;

use Exception;
use Throwable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class ResponseService
{
    /**
     * Redirect with a success message.
     *
     * @param string $message
     * @param string|null $redirectRoute
     * @return Application|RedirectResponse|Redirector
     */
    public static function successRedirectResponse(string $message="Success", string|null $redirectRoute=null)
    {
        return redirect()->route($redirectRoute)->with('success', $message);
    }

    /**
     * Redirect with an error message.
     * @param string $message
     * @param string|null $redirectRoute
     * @return Application|RedirectResponse|Redirector
     */
    public static function errorRedirectResponse(string $message="Error occurred", string|null $redirectRoute=null)
    {
        return redirect()->route($redirectRoute)->with('error', $message);
    }

    /**
     * Logs an error and redirects with an error message.
     *
     * @param Throwable|Exception $e
     * @param string $logMessage
     * @param string $responseMessage
     * @param string|null $redirectRoute
     * @return Application|RedirectResponse|Redirector
     */
    public static function logErrorRedirect(Throwable|Exception $e, string $logMessage = 'Error occurred', string $responseMessage = 'Error occurred', string|null $redirectRoute=null)
    {
        Log::error($logMessage . ' ' . $e->getMessage() . ' ---> ' . $e->getFile() . ' at line ' . $e->getLine());
        return redirect($redirectRoute)->with('error', $responseMessage);
    }


    /**
     * Handles validation error responses by redirecting back with errors and old input.
     *
     * @param array $errors
     * @param array $oldInput
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public static function validationErrorResponse(array $errors, array $oldInput = [])
    {
        return redirect()
            ->back()
            ->withErrors($errors)
            ->withInput($oldInput);
    }


}