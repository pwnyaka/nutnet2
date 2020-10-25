<?php


namespace app\controllers;


use app\engine\App;
use app\model\entities\User;

class ApiController extends Controller
{

    public function actionSave()
    {
        $data = App::call()->request->getParams();
        $user = new User($data['first_name'], $data['last_name'], $data['age']);
        App::call()->usersRepository->save($user);
        echo json_encode([
            'status' => 'OK',
        ]);
        die;
    }

    public function actionUnload()
    {
        $users = App::call()->usersRepository->getAdultUsers();
        $service = new \Google_Service_Sheets(App::call()->google->getClient());
        $spreadsheetId = '12j5qPd6caB9_esazuYVywR-LmgC8lnIpiVC7uR3rESk';
        $range = 'sheet1';
        $requestBody = new \Google_Service_Sheets_ClearValuesRequest();
        $clearResponse = $service->spreadsheets_values->clear(
            $spreadsheetId,
            $range,
            $requestBody
        );
        if ($clearResponse) {
            $values = [
                ['first_name', 'last_name', 'age']
            ];
            foreach ($users as $user) {
                $values[] = [$user['first_name'], $user['last_name'], $user['age']];
            }

            $body = new \Google_Service_Sheets_ValueRange([
                'values' => $values
            ]);
            $params = ['valueInputOption' => 'RAW'];
            $insert = ['insertDataOption' => 'INSERT_ROWS'];
            $result = $service->spreadsheets_values->append(
                $spreadsheetId,
                $range,
                $body,
                $params,
                $insert
            );
            if ($result) {
                echo json_encode([
                    'status' => 'OK',
                ]);
            }
            die;
        }


    }
}