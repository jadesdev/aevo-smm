<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Betsite;
use App\Models\CablePlan;
use App\Models\DataBundle;
use App\Models\Decoder;
use App\Models\Electricity;
use App\Models\Network;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    //
    public function bills_setting()
    {
        return view('admin.bills.setting');
    }

    public function index()
    {
        return view('admin.bills.index');
    }

    public function airtime()
    {
        $networks = Network::whereStatus(1)->get();

        return view('admin.bills.airtime', compact('networks'));
    }

    // Airtime Status
    public function airtime_status($id, $status)
    {
        $network = Network::findorFail($id);
        $network->airtime = $status;
        $network->save();

        return redirect()->back()->withSuccess(__('Network Updated Successfully.'));
    }

    public function update_airtime(Request $request, $id)
    {
        $request->validate([
            'minimum' => 'required|string|min:2',
        ]);
        $network = Network::findorFail($id);
        $network->minimum = $request->minimum;
        $network->discount = $request->discount;
        $network->code = $request->code;
        $network->save();

        return redirect()->back()->withSuccess(__('Airtime Network updated Successfully.'));
    }

    // Data
    public function internet_data()
    {
        $networks = Network::whereStatus(1)->get();

        return view('admin.bills.data.index', compact('networks'));
    }

    public function datasub_status($id, $status)
    {
        $network = Network::findorFail($id);
        $network->data = $status;
        $network->save();

        return redirect()->back()->withSuccess(__('Data Network Updated Successfully.'));
    }

    public function manage_dataplans($id)
    {
        $network = Network::whereStatus(1)->whereId($id)->first();
        $dataplans = DataBundle::whereNetworkId($id)->get();

        return view('admin.bills.data.plans', compact('network', 'dataplans'));
    }

    public function create_dataplan(Request $request)
    {
        $request->validate([
            'network_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'code' => 'required|string',
        ]);
        $dataplan = new DataBundle;
        $dataplan->name = $request->name;
        $dataplan->network_id = $request->network_id;
        $dataplan->service = $request->service;
        $dataplan->price = $request->price;
        $dataplan->status = 1;
        $dataplan->code = $request->code;
        $dataplan->save();

        return redirect()->back()->withSuccess(__('Dataplan Created Successfully.'));
    }

    public function edit_dataplan(Request $request, $id)
    {
        $request->validate([
            'network_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'code' => 'required|string',
        ]);
        $dataplan = DataBundle::findorFail($id);
        $dataplan->name = $request->name;
        $dataplan->price = $request->price;
        $dataplan->service = $request->service;
        $dataplan->code = $request->code;
        $dataplan->save();

        return redirect()->back()->withSuccess(__('Dataplan Edited Successfully.'));
    }

    public function dataplan_status($id, $status)
    {
        $data = DataBundle::findorFail($id);
        $data->status = $status;
        $data->save();

        return redirect()->back()->withSuccess(__('Dataplan Updated Successfully.'));
    }

    public function delete_dataplan($id)
    {
        $data = DataBundle::findorFail($id);
        $data->delete();

        return redirect()->back()->withSuccess(__('Dataplan Deleted Successfully.'));
    }

    // cable tv
    public function cabletv()
    {
        $decoders = Decoder::all();

        return view('admin.bills.cabletv.index', compact('decoders'));
    }

    public function cabletv_status($id, $status)
    {
        $decoder = Decoder::findorFail($id);
        $decoder->status = $status;
        $decoder->save();

        return redirect()->back()->withSuccess(__('Decoder Updated Successfully.'));
    }

    public function manage_cabletvplans($id)
    {
        $decoder = Decoder::whereId($id)->first();
        $plans = CablePlan::whereDecoderId($id)->get();

        return view('admin.bills.cabletv.plans', compact('decoder', 'plans'));
    }

    public function create_cabletvplan(Request $request)
    {
        $request->validate([
            'decoder_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric',
            // 'code' => 'required|string'
        ]);
        $plan = new CablePlan;
        $plan->name = $request->name;
        $plan->decoder_id = $request->decoder_id;
        $plan->price = $request->price;
        $plan->status = 1;
        $plan->code = $request->code;
        $plan->save();

        return redirect()->back()->withSuccess(__('CableTV plan Created Successfully.'));
    }

    public function edit_cabletvplan(Request $request, $id)
    {
        $request->validate([
            'decoder_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|numeric',
            // 'code' => 'required|string'
        ]);
        $plan = CablePlan::findorFail($id);
        $plan->name = $request->name;
        $plan->price = $request->price;
        $plan->code = $request->code;
        $plan->save();

        return redirect()->back()->withSuccess(__('Cable plan Updated Successfully.'));
    }

    public function cableplan_status($id, $status)
    {
        $plan = CablePlan::findorFail($id);
        $plan->status = $status;
        $plan->save();

        return redirect()->back()->withSuccess(__('Plan Updated Successfully.'));
    }

    public function delete_cableplan($id)
    {
        $plan = CablePlan::findorFail($id);
        $plan->delete();

        return redirect()->back()->withSuccess(__('Plan Deleted Successfully.'));
    }

    // Electricity
    public function electricity()
    {
        $powers = Electricity::all();

        return view('admin.bills.electricity', compact('powers'));
    }

    public function electricity_status($id, $status)
    {
        $plan = Electricity::findorFail($id);
        $plan->status = $status;
        $plan->save();

        return redirect()->back()->withSuccess(__('Plan Updated Successfully.'));
    }

    public function create_electricity(Request $request)
    {
        $request->validate([
            'fee' => 'required',
            'name' => 'required|string',
            'minimum' => 'required|numeric',
            // 'code' => 'required|string'
        ]);
        $plan = new Electricity;
        $plan->name = $request->name;
        $plan->fee = $request->fee;
        $plan->minimum = $request->minimum;
        $plan->code = $request->code;
        $plan->save();

        return redirect()->back()->withSuccess(__('Electricity Created Successfully.'));
    }

    public function edit_electricity(Request $request, $id)
    {
        $request->validate([
            'fee' => 'required',
            'name' => 'required|string',
            'minimum' => 'required|numeric',
            'code' => 'string',
        ]);
        $plan = Electricity::findOrFail($id);
        $plan->name = $request->name;
        $plan->fee = $request->fee;
        $plan->minimum = $request->minimum;
        $plan->code = $request->code;
        $plan->save();

        return redirect()->back()->withSuccess(__('Electricity Updated Successfully.'));
    }

    public function delete_electricity($id)
    {
        $plan = Electricity::findorFail($id);
        $plan->delete();

        return redirect()->back()->withSuccess(__('Plan Deleted Successfully.'));
    }

    // Betting
    public function betting()
    {
        $plans = Betsite::all();

        return view('admin.bills.betting', compact('plans'));
    }

    public function bet_status($id, $status)
    {
        $plan = Betsite::findorFail($id);
        $plan->status = $status;
        $plan->save();

        return redirect()->back()->withSuccess(__('Plan Updated Successfully.'));
    }

    public function create_bet(Request $request)
    {
        $request->validate([
            'fee' => 'required|numeric',
            'name' => 'required|string',
            'code' => 'required|string',
            // 'code' => 'required|string'
        ]);
        $plan = new Betsite;
        $plan->name = $request->name;
        $plan->fee = $request->fee;
        $plan->code = $request->code;
        $plan->save();

        return redirect()->back()->withSuccess(__('Betsite Created Successfully.'));
    }

    public function edit_bet(Request $request, $id)
    {
        $request->validate([
            'fee' => 'required',
            'name' => 'required|string',
            'minimum' => 'required|numeric',
            'code' => 'string',
        ]);
        $plan = Betsite::findOrFail($id);
        $plan->name = $request->name;
        $plan->fee = $request->fee;
        $plan->minimum = $request->minimum;
        $plan->code = $request->code;
        $plan->save();

        return redirect()->back()->withSuccess(__('Betsite Updated Successfully.'));
    }

    public function delete_bet($id)
    {
        $plan = Betsite::findorFail($id);
        $plan->delete();

        return redirect()->back()->withSuccess(__('Plan Deleted Successfully.'));
    }
}
