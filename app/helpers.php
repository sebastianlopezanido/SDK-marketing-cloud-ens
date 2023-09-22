<?php
if (!function_exists('getPaginateParams')) {
    function getPaginateParams()
    {
        $request = request()->all();
        $params = array();
        if (isset($request['pageSize']) && is_numeric($request['pageSize']) && $request['pageSize'] != 0) {
            $params['$pageSize'] = (int)$request['pageSize'];
        }
        if (isset($request['lastEventId']) && is_string($request['lastEventId'])) {
            $params['lastEventId'] = (int)$request['lastEventId'];
        }
        if (isset($request['triggeredSendId']) && is_string($request['triggeredSendId'])) {
            $params['triggeredSendId'] = $request['triggeredSendId'];
        }
        if (isset($request['sortOrder']) && is_string($request['sortOrder'])) {
            $params['sortOrder'] = $request['sortOrder'];
        }

        return $params;
    }
}
