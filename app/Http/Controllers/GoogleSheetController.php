<?php

namespace App\Http\Controllers;

use Exception;
use Google\Service\Drive;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;

class GoogleSheetController extends Controller
{
    public function index()
    {
        /* Load pre-authorized user credentials from the environment.
                  TODO(developer) - See https://developers.google.com/identity for
                   guides on implementing OAuth2 for your application. */
        $client = new Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Drive::DRIVE);
        $service = new Google_Service_Sheets($client);
        try{

            $spreadsheet = new Google_Service_Sheets_Spreadsheet([
                'properties' => [
                    'title' => 'jhgkjh'
                ]
            ]);
            $spreadsheet = $service->spreadsheets->create($spreadsheet, [
                'fields' => 'spreadsheetId'
            ]);
            printf("Spreadsheet ID: %s\n", $spreadsheet->spreadsheetId);
            return $spreadsheet->spreadsheetId;
        }
        catch(Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' .$e->getMessage();
        }
    }
}
