<?php

namespace App\Http\Controllers;

use App\Know;
use App\Officer;
use App\Reporter;
use App\Visit;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

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
        Log::debug(Carbon::parse('2019-03-01')->translatedFormat('l, d F Y')); //Output: "01 Maret 2019");
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
        $visit = $this->save($visit, $request);
        foreach ($request->addmore as $key => $value) {
            //ProductStock::create($value);
            $value["visit_id"] = $visit->id;
            // Log::debug($value["nama"]);
            Officer::create($value);
        }
        $know = new Know();
        $know->visit_id = $visit->id;
        $know->nama = $request->mengetahuinama;
        $know->jabatan = $request->mengetahuijabatan;
        $know->save();
        $rep = new Reporter();
        $rep->visit_id = $visit->id;
        $rep->nama = $request->melaporkannama;
        $rep->jabatan = $request->melaporkanjabatan;
        $rep->save();

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
    private function save(Visit $visit, Request $request)
    {
        $visit->nama = $request->nama;
        $visit->namakegiatan = $request->namakegiatan;
        $visit->tujuan = $request->tujuan;
        $visit->tanggal = $request->tanggal;
        $visit->tempat = $request->tempat;
        $visit->hasil = $request->hasil;
        $visit->tanggalend = $request->tanggalend;
        $visit->penutup = $request->penutup;
        $visit->dasar = $request->dasar;
        if (isset($request->foto)) {
            $imageName = time() . '.' . $request->foto->getClientOriginalExtension();
            request()->foto->move(public_path(), $imageName);
            $visit->foto = $imageName;
        }
        if (isset($request->foto2)) {
            $imageName = time() . '.' . $request->foto2->getClientOriginalExtension();
            request()->foto2->move(public_path(), $imageName);
            $visit->foto2 = $imageName;
        }
        if (isset($request->nosurat)) {
            $visit->nosurat = $request->nosurat;
        }
        if (isset($request->dipa)) {
            $visit->dipa = $request->dipa;
        }
        $visit->save();

        return $visit;
    }
    public function update(Request $request, $id)
    {
        //hapus dulu officers nya bedasarkan id visit
        $deletedRows = Officer::where('visit_id', $id)->delete();
        $visit = Visit::findOrFail($id);
        $this->save($visit, $request);
        foreach ($request->addmore as $key => $value) {
            //ProductStock::create($value);

            $value["visit_id"] = $visit->id;
            // Log::debug($value["nama"]);
            Officer::create($value);
        }
        $know = Know::where('visit_id', $visit->id)->first();
        $know->visit_id = $visit->id;
        $know->nama = $request->mengetahuinama;
        $know->jabatan = $request->mengetahuijabatan;
        $know->save();
        $rep = Reporter::where('visit_id', $visit->id)->first();
        $rep->visit_id = $visit->id;
        $rep->nama = $request->melaporkannama;
        $rep->jabatan = $request->melaporkanjabatan;
        $rep->save();

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
    public function print(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        if ($visit->foto === null) {
            $fotoexists = false;
        } else {
            $fotoexists = true;
        }

        $foto = public_path() . str_replace(URL::to('/'), "", $visit->foto);
        $pdf = PDF::loadView('print', ['visit' => $visit, 'foto' => $foto, 'fotoexist' => $fotoexists]);

        return $pdf->stream();
        //return view('print',['visit'=>$visit]);
    }
    public function printsementara($id)
    {
        Log::debug(URL::to('/'));

        $visit = Visit::findOrFail($id);
        if ($visit->foto === null) {
            $fotoexists = false;
        } else {
            $fotoexists = true;
        }
        $ext = pathinfo(public_path($visit->foto), PATHINFO_EXTENSION);
        $image = file_get_contents(public_path($visit->foto));
        $base64 = 'data:image/' . $ext . ';base64,' . base64_encode($image);
        // return response(public_path($visit->foto));
        // $pdf = PDF::loadView('print', ['visit' => $visit, 'foto' => $base64, 'fotoexist' => $fotoexists]);
        //return $pdf->stream('document.pdf');
        //return view('print', ['visit' => $visit, 'foto' => $base64, 'fotoexist' => $fotoexists]);
        $wordTest = new \PhpOffice\PhpWord\PhpWord();
        $fontStyleName = 'rStyle';
        //  $wordTest->addTitleStyle(1, array('bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100), array('size' => 30));
        $newSection = $wordTest->addSection();
        $title = "LAPORAN KEGIATAN";
        $title2 = "BRSKPN SATRIA BATURADEN";
        $newSection->addText($title, array('name' => 'Times New Roman', 'bold' => true, 'size' => 20, 'color' => 'black', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 20));
        $newSection->addText($title2, array('name' => 'Times New Roman', 'bold' => true, 'size' => 20, 'color' => 'black', 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 700));

        $paragraphStyleName = 'P-Style';
        $ONETAB = 'ONETAB';
        $wordTest->addParagraphStyle($ONETAB, array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('right', 9090))));
        $predefinedMultilevelStyle = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_ALPHANUM, 'format' => 'upperLetter');
        $fontStyleName = 'myOwnStyle';
        $wordTest->addFontStyle($fontStyleName, array('name' => 'Times New Roman', 'bold' => true, 'size' => 12, 'color' => 'black'));

        $fontStyleName2 = 'myOwnStyle2';
        $wordTest->addFontStyle($fontStyleName, array('name' => 'Times New Roman', 'size' => 12, 'color' => 'black'));


        $newSection->addText("A. NAMA KEGIATAN", $fontStyleName);
        $newSection->addText($visit->nama, $fontStyleName2);
        $newSection->addText("B. TUJUAN", $fontStyleName);
        $newSection->addText("Adapun tujuan dari kegiatan tersebut adalah : ", $fontStyleName2);
        $tujuans = preg_split('/\r\n|[\r\n]/', $visit->tujuan);
        foreach ($tujuans as $t) {
            $newSection->addListItem($t, 0, $fontStyleName2, $predefinedMultilevelStyle, $paragraphStyleName);
        }
        $newSection->addText("C. DASAR KEGIATAN", $fontStyleName);
        $newSection->addText($visit->namakegiatan, $fontStyleName2);
        $newSection->addText("D. WAKTU DAN TEMPAT PELAKSANAAN KEGIATAN", $fontStyleName);
        Carbon::setLocale("id");
        $carbon = new Carbon($visit->tanggal);

        $date = $carbon->format('l, d F Y');
        $newSection->addText("Hari dan Tanggal : " . $date, $fontStyleName2);
        $newSection->addText("Tempat : " . $visit->tempat, $fontStyleName2);
        $newSection->addText("E. PETUGAS PELAKSANA", $fontStyleName);

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 1, 'cellMargin' => 5,  'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 0);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 1);
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableFontStyle = array('bold' => true);
        $wordTest->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $newSection->addTable($fancyTableStyleName);
        $table->addRow(300);
        $table->addCell(500, $fancyTableCellStyle)->addText(' No.', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText(' Nama', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText(' NIP', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText(' Jabatan', $fancyTableFontStyle);
        $officerIndex = 1;
        foreach ($visit->officers as $officer) {
            $table->addRow(300);
            $table->addCell(500)->addText(" " . $officerIndex);
            $table->addCell(2000)->addText(" " . $officer->nama);
            $table->addCell(2000)->addText(" " . $officer->nip);
            $table->addCell(2000)->addText(" " . $officer->jabatan);
            $officerIndex++;
        }
        $newSection->addText("F. HASIL", $fontStyleName);
        $hasils = preg_split('/\r\n|[\r\n]/', $visit->hasil);
        $predefinedMultilevelStyle2 = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER, 'format' => 'upperLetter');
        foreach ($hasils as $hasil) {
            $newSection->addListItem($hasil, 0, $fontStyleName2, $predefinedMultilevelStyle2, $paragraphStyleName);
        }
        $newSection->addText("G. LAMPIRAN FOTO KEGIATAN", $fontStyleName);
        $fancyTableStyleName = 'FOTO_TBLE';
        $fancyTableStyle = array('borderSize' => 0, 'cellMargin' => 5, 'width' => 100, 'unit' => 'pct',  'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 10);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 1);
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableFontStyle = array('bold' => true);
        $wordTest->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $newSection->addTable($fancyTableStyleName);
        $table->addRow(210);
        $table->addCell(210, $fancyTableCellStyle)->addImage(public_path($visit->foto), array('width' => 210, 'height' => 210, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        $table->addCell(210, $fancyTableCellStyle)->addImage(public_path($visit->foto2), array('width' => 210, 'height' => 210, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));



        //$newSection->addListItem("Nama Kegiatan", [$depth], [$fontStyle], [$listStyle], [$paragraphStyle]);
        // $newSection->addText($desc1, array('name' => 'Tahoma', 'size' => 15, 'color' => 'red'));

        $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
        try {
            $objectWriter->save(storage_path('TestWordFile.docx'));
        } catch (Exception $e) {

            return response($e);
        }
        return response()->download(storage_path('TestWordFile.docx'));
        //return response(200);
    }
}
