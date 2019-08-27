<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Log, Session;
use App\Models\Tax;
use App\Models\Restaurant;

class TaxesController extends Controller
{
    CONST default_index = 'tax';
    CONST required_method = [
        'updateTaxInfo'
    ];
    CONST model = Tax::class;
    // Show tax info of restaurant
    public function showTaxInfo($slug)
    {
        $this->restaurant = Session::get('res');
        $resId = $this->restaurant->id;
        $breadcrumbs = [
            'title' => __('admin.taxes.breadcrumbs.tax_info'),
            'links' => [
                [
                    'href' => url('#'),
                    'text' => __('admin.taxes.breadcrumbs.tax_detail')
                ]
            ]
        ];
        $tax = Tax::where('restaurant_id', $resId)->first();
        $restaurant = Restaurant::findOrFail($resId);
        $take_red_bill = $restaurant->take_red_bill;
        return view('admin.restaurants.taxes.tax', compact('tax', 'breadcrumbs','take_red_bill'));
    }

    //create tax info
    public function createTax($slug, Request $request)
    {
        $this->restaurant = Session::get('res');

        $this->validate($request, [
            'type' => 'required',
            'rate' => 'required|min:0|max:1000'
        ]);

        $requestData = $request->all();
        $requestData['restaurant_id'] = $this->restaurant->id;

        Tax::create($requestData);     

        $restaurant = Restaurant::findOrFail($requestData['restaurant_id'] );
        $restaurant->take_red_bill = isset($requestData['take_red_bill'])?$requestData['take_red_bill']:false;
        $restaurant->save();

        Session::flash('flash_message', trans('admin.taxes.flash_messages.create'));

        return redirect('admin/' . $slug . '/tax-info');
    }

    // edit tax info
    public function updateTaxInfo($slug, $id, Request $request)
    {
        $this->restaurant = Session::get('res');

        $requestData = $request->all();
        $this->validate($request, [
            'type' => 'required',
            'rate' => 'required|min:0|max:1000'
        ]);
        
        $requestData['restaurant_id'] = $this->restaurant->id;

        $taxDetail = Tax::where('restaurant_id',$this->restaurant->id)->findOrFail($id);

        $taxDetail->update($requestData);

        $restaurant = Restaurant::findOrFail($requestData['restaurant_id'] );
        $restaurant->take_red_bill = isset($requestData['take_red_bill'])?$requestData['take_red_bill']:false;
        $restaurant->save();

        Session::flash('flash_message', trans('admin.taxes.flash_messages.update'));
        return redirect('admin/' . $slug . '/tax-info');
    }
}
