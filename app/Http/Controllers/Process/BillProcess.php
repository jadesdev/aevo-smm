<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Utility\{
    N3tdataUtility, GladApi,
    Ncwallet
};
use App\Models\{
    Betsite,
    CablePlan,
    DataBundle,
    DatacardPlan,
    Decoder,
    DecoderTrx,
    Education,
    EduTrx,
    Electricity,
    Network,
    NetworkTrx,
    PowerTrx,
    RechargePin,
    Transaction
};
use Exception;

class BillProcess extends Controller
{
    //
    function purchase_airtime($data){

        $network = Network::find($data['network']);
        try{
            $slot = new Ncwallet();
            $payload = [
                'network' => $network->code,
                'phone' => $data['phone'],
                'plan_type' => "VTU",
                'bypass' => true,
                'request-id' => $data['ref'],
                'amount' => $data['amount'],
            ];
            $api_result = $slot->buyAirtime($payload);
            if(isset($api_result['status']) && $api_result['status'] == "success"){
                return $res = [
                    'name' => "ncwallet",
                    'ref' => $data['ref'],
                    'api_status' => "success",
                    'response' => $api_result,
                    'message' => $api_result['message'] ?? $api_result['msg'] ?? "",
                ];
            }else{
                return $res = [
                    'ref' => $data['ref'],
                    'name' => "ncwallet",
                    'api_status' => "fail",
                    'response' => $api_result,
                ];
            }
        }catch(Exception $e){
            return $res =[
                'api_status' => "error",
                'response' => $e->getMessage() ?? "Something is not right",
                'name' => "ncwallet",
                'api_status' => "fail",
                'ref' => $data['ref'],
            ];
            return $data;
        }
    }
    function purchase_data($data){

        $network = Network::find($data['network']);
        $plan = DataBundle::find($data['plan']);
        // glad
        try{
            $slot = new Ncwallet();
            $payload = [
                'network' => $network->code,
                'phone' => $data['phone'],
                'data_plan' => $plan->code,
                'bypass' => false,
                'request-id' => $data['ref'],
            ];
            $api_result = $slot->buyData($payload);
            if(isset($api_result['status']) && $api_result['status'] == "success"){
                return $res = [
                    'name' => "n3tdata",
                    'ref' => $data['ref'],
                    'api_status' => "success",
                    'response' => $api_result,
                    'message' => $api_result['api_response'] ?? $api_result['response'] ?? "",
                ];
            }else{
                return $res = [
                    'ref' => $data['ref'],
                    'name' => "glad",
                    'api_status' => "fail",
                    'response' => $api_result,
                ];
            }

        } catch(Exception $e){
            return $res =[
                'api_status' => "error",
                'response' => $e->getMessage() ?? "Something is not right",
                'name' => "none",
                'api_status' => "fail",
                'ref' => $data['ref'],
            ];
            return $data;
        }

    }
    // cavle
    function purchase_cabletv($data){

        $decoder = Decoder::find($data['decoder']);
        $plan = CablePlan::find($data['plan']);
        // glad
        try{
            $slot = new Ncwallet();
            $payload = [
                'cable' => ($decoder->id),
                'iuc' => $data['customer'],
                'cable_plan' => $plan->code,
                'request-id' => $data['ref'],
                'bypass' => false
            ];
            $api_result = $slot->buyCablesub($payload);
            if(isset($api_result['status']) && $api_result['status'] == "success" || $api_result['status'] == "pending"){
                return $res = [
                    'name' => "ncwallet",
                    'ref' => $data['ref'],
                    'api_status' => "success",
                    'response' => $api_result,
                    'message' => $api_result['message'],
                ];
            }else{
                return $res = [
                    'ref' => $data['ref'],
                    'name' => "ncwallet",
                    'api_status' => "fail",
                    'response' => $api_result,
                ];
            }
        }catch(Exception $e){
            return $res =[
                'api_status' => "error",
                'response' => $e->getMessage() ?? "Something is not right",
                'name' => "none",
                'ref' => $data['ref'],
            ];
            return $data;
        }

    }
    // power
    function purchase_power2($data){

        $plan = Electricity::find($data['disco']);
        // glad
        try{
            $slot = new GladApi();

            if($data['type'] == 'prepaid'){
                $data['type'] = 1;
            }else{
                $data['type'] = 2;
            }

            $payload = [
                'meter_number' => $data['number'],
                'disco_name' => $plan->code,
                'Customer_Phone' => $data["phone"],
                'customer_name' => $data['name'],
                'customer_address' => " ",
                'amount' => $data['amount'],
                'MeterType' => $data['type'],
            ];

            $api_result = $slot->buyPower($payload);
            if(isset($api_result['Status']) && $api_result['Status']== "successful"){
                return $res = [
                    'name' => "glad",
                    'ref' => $data['ref'],
                    'api_status' => "success",
                    'response' => $api_result,
                    'token' => $api_result['token'],
                ];
            }else{
                return $res = [
                    'ref' => $data['ref'],
                    'name' => "glad",
                    'api_status' => "fail",
                    'response' => $api_result,
                    "token" => "null",
                ];
            }
        } catch(Exception $e){
            return $res =[
                'api_status' => "error",
                'response' => $e->getMessage() ?? "Something is not right",
                'name' => "none",
                'ref' => $data['ref'],
            ];
            return $data;
        }
    }
    // power
    function purchase_power($data){

        $plan = Electricity::find($data['disco']);
        // glad
        try{

            $slot = new Ncwallet();

            $payload = [
                'bypass' => false,
                'request-id' => $data['ref'],
                'meter_number' => $data['number'],
                'disco' => $plan->code,
                'amount' => $data['amount'],
                'meter_type' => $data['type'],
            ];

            $api_result = $slot->buyPower($payload);

            if(isset($api_result['status']) && $api_result['status'] == "success"){
                $response['ref'] = $api_result['ref_id'];
                $response['token'] = $api_result['token'] ?? " ";
                return $res = [
                    'name' => "ncwallet",
                    'ref' => $api_result['ref_id'] ?? $data['ref'],
                    'api_status' => "success",
                    'response' => $api_result,
                    'token' => $api_result['token'] ?? "",
                ];
            }else{
                return $res = [
                    'ref' => $data['ref'],
                    'name' => "ncwallet",
                    'api_status' => "fail",
                    'response' => $api_result,
                    "token" => "null",
                ];
            }


        } catch(Exception $e){
            return $res =[
                'api_status' => "error",
                'response' => $e->getMessage() ?? "Something is not right",
                'name' => "none",
                'ref' => $data['ref'],
            ];
            return $data;
        }
    }
    // betting
    function purchase_betting($data){

        $plan = Betsite::find($data['betsite']);
        // glad
        try{

            $slot = new Ncwallet();

            $payload = [
                'bypass' => false,
                'betting_number' => $data['number'],
                'betsite_id' => $data['service'],
                'amount' => $data['amount'],
            ];

            $api_result = $slot->buyBet($payload);
            if(isset($api_result['status']) && $api_result['status'] == "success"){
                return $res = [
                    'name' => "ncwallet",
                    'ref' => $api_result['ref_id'] ?? $data['ref'],
                    'api_status' => "success",
                    'response' => $api_result,
                ];
            }else{
                return $res = [
                    'ref' => $data['ref'],
                    'name' => "ncwallet",
                    'api_status' => "fail",
                    'response' => $api_result,
                ];
            }


        } catch(Exception $e){
            return $res =[
                'api_status' => "error",
                'response' => $e->getMessage() ?? "Something is not right",
                'name' => "none",
                'ref' => $data['ref'],
            ];
            return $data;
        }
    }

}
