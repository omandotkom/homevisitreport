<?php

namespace App\Http\Controllers;

use App\Officer;
use App\Visit;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use PDF;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //showlast 10 data
        $visits = Visit::select("id", "nama", "namakegiatan", "tanggal", "created_at", "updated_at")->orderBy("created_at", "desc")->get();
        return view('report', ['visits' => $visits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $visit = new Visit();
        $visit->nama = $request->nama;
        $visit->namakegiatan = $request->namakegiatan;
        $visit->tujuan = $request->tujuan;
        $visit->tanggal = $request->tanggal;
        $visit->tempat = $request->tempat;
        $visit->hasil = $request->hasil;
        if (isset($request->foto)) {
            $imageName = time() . '.' . $request->foto->getClientOriginalExtension();
            request()->foto->move(public_path('images/foto'), $imageName);
            $visit->foto = asset('images/foto/' . $imageName);
        }
        $visit->save();

        foreach ($request->addmore as $key => $value) {
            //ProductStock::create($value);
            $value["visit_id"] = $visit->id;
            // Log::debug($value["nama"]);
            Officer::create($value);
        }
        return redirect()->route('list-laporan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visit = Visit::findOrFail($id);
        return view('reportform', ['edit' => true, 'visit' => $visit]);
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
        //hapus dulu officers nya bedasarkan id visit
        $deletedRows = Officer::where('visit_id', $id)->delete();
        $visit = Visit::findOrFail($id);
        $visit->nama = $request->nama;
        $visit->namakegiatan = $request->namakegiatan;
        $visit->tujuan = $request->tujuan;
        $visit->tanggal = $request->tanggal;
        $visit->tempat = $request->tempat;
        $visit->hasil = $request->hasil;
        if (isset($request->foto)) {
            $imageName = time() . '.' . $request->foto->getClientOriginalExtension();
            request()->foto->move(public_path('images/foto'), $imageName);
            $visit->foto = asset('images/foto/' . $imageName);
        }
        $visit->nosurat = $request->nosurat;
        $visit->dipa = $request->dipa;
        $visit->save();

        foreach ($request->addmore as $key => $value) {
            //ProductStock::create($value);
            $value["visit_id"] = $visit->id;
            // Log::debug($value["nama"]);
            Officer::create($value);
        }
        return redirect()->route('list-laporan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function print(Request $request, $id){
        $visit = Visit::findOrFail($id);
        $pdf = PDF::loadView('print',['visit'=>$visit]);
        return $pdf->stream();   
        //return view('print',['visit'=>$visit]);
    }
}
