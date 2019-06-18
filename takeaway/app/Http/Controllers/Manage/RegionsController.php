<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parents = Region::where('parent_id', 0)
            ->orderBy('region_name', 'asc')
            ->get();

        // query
        $conditions = [];
        if ($request->filled('id')) {
            array_push($conditions, ['id', $request->id]);
        }
        if ($request->filled('region_name')) {
            array_push($conditions, ['region_name', 'like', '%' . $request->region_name . '%']);
        }
        if ($request->filled('parent_id') && $request->parent_id >= 0) {
            array_push($conditions, ['parent_id', $request->parent_id]);
        }

        $regions = Region::where($conditions)
            ->orderBy('parent_id', 'asc')
            ->orderBy('region_name', 'asc')
            ->paginate(10);
        return view('manage.regions.index')
            ->with('regions', $regions)
            ->with('parents', $parents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Region::where('parent_id', 0)
            ->orderBy('region_name', 'asc')
            ->get();
        return view('manage.regions.create')
            ->with('parents', $parents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region_name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('regions.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $region_names = $this->filterValue($request->input('region_name'));
        $parent_id = $request->input('parent_id');
        $parent_name = '';
        if ($parent_id != 0) {
            $parent = Region::find($parent_id);
            if ($parent) {
                $parent_name = $parent->region_name;
            } else {
                $parent_id = 0;
            }
        }

        // filter regions that already exist
        $exists = DB::table('regions')->select('region_name')->where('parent_id', $parent_id)->get();
        foreach ($exists as $exist) {
            $region_names = array_diff($region_names, array($exist->region_name));
        }

        foreach ($region_names as $region_name) {
            $region = new Region();
            $region->region_name = $region_name;
            $region->parent_id = $parent_id;
            $region->parent_name = $parent_name;
            $region->save();
        }
    
        return redirect(route('regions.index'))->with('success', 'Region Created');
    }

    /**
     * trim value, remove empty value, remove same value
     * @param String
     * @return String
     */
    private function filterValue($value)
    {
        $replace = "<!@#$%>";
        $value = str_replace(["\r\n", "\n", "\r"], $replace, $value);
        $values = explode($replace, $value);
        for ($i = count($values) - 1; $i >= 0; $i--) {
            $values[$i] = trim($values[$i]);
            if (strlen($values[$i]) == 0) {
                unset($values[$i]);
            }
        }
        return array_unique($values);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parents = Region::where('parent_id', 0)->get();
        $total_updated = 0;
        foreach ($parents as $parent) {
            $affected = DB::update("update regions set parent_name = '" . $parent->region_name . "' where parent_id = '" . $parent->id . "'");
            if ($affected > 0) {
                $total_updated += $affected;
                echo "Updating #" . $parent->id . ":" . $parent->region_name . ", affected " . $affected . ' lines<br>';
            }
        }
        if ($total_updated == 0) {
            echo "No rows affected";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parents = Region::where('parent_id', 0)
            ->orderBy('region_name', 'asc')
            ->get();

        $region = Region::find($id);
        if (is_null($region)) {
            return redirect(route('regions.index'))
                ->with('error', 'Region(' . $id . ') Not Found');
        }
        
        return view('manage.regions.edit')
            ->with('parents', $parents)
            ->with('region', $region);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $region = Region::find($id);
        if (is_null($region)) {
            return redirect(route('regions.index'))
                ->with('error', 'Region(' . $id . ') Not Found');
        }

        // input validate
        $validator = Validator::make($request->all(), [
            'region_name' => [
                'required',

                // unique within siblings
                Rule::unique('regions')->where('parent_id', $region->parent_id)->ignore($id)
            ],
        ]);

        if ($validator->fails()) {
            return redirect(route('regions.edit', ['region' => $region->id]))
                        ->withErrors($validator)
                        ->withInput();
        }

        $region->region_name = $request->input('region_name');

        $parent_id = $request->input('parent_id');
        if ($parent_id != 0) {
            $parent = Region::find($parent_id);
            if (!$parent) {
                $parent_id = 0;
            }
        }

        $region->parent_id = $parent_id;
        $region->save();

        return redirect(route('regions.index'))->with('success', 'Region Updated, but you need update parent name!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // check if region with this id exists
        $region = Region::find($id);
        if (is_null($region)) {
            return redirect(route('regions.index'))
                ->with('error', 'Region(' . $id . ') Not Found');
        }

        // check if region has children regions
        $childrens = DB::table('regions')
            ->where('parent_id', $region->id)
            ->count();
        if ($childrens > 0) {
            return redirect(route('regions.index'))
                ->with('error', 'Region(' . $id . ') still has ' . $childrens . ' children regions');
        }

        $region->delete();
        return redirect(route('regions.index'))
            ->with('success', 'Region Removed');
    }
}
