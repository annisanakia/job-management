<?php

namespace Lib\workflow;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Storage;
use File;
use Excel;
use App\Imports\generalImport;

class libWorkflowProcess extends Controller
{

    protected $globalTools;

    public function __construct()
    {
        $this->globalTools = new \Lib\core\GlobalTools();
    }

    public function nabDataTblPortofolio($date, $custodian_code)
    {
        $portfolio_nabs = \Models\pims\sec_tbl_portfolio::from('sec_tbl_portfolio as p')
            ->select(
                DB::raw('CONVERT(DATE, pn.PositionDate) as PositionDate'), 'p.PortfolioID', 'p.PortfolioCode', 'p.PortfolioName',
                'pn.NAB', 'pn.Unit', 'pn.NAB_per_unit', 'pn.CDate', 'pn.MDate',
                'pep.SystemPortfolioCode'
            )
            ->leftJoin('mis_tbl_portfolio_nab as pn', function ($join) use($date){
                $join->on('pn.PortfolioID', '=', 'p.PortfolioID')->whereDate('pn.PositionDate',$date);
            })
            ->leftJoin('sec_tbl_parameter_custodian as pc', function ($join) {
                $join->on('pc.CompanyID', '=', 'p.PortfolioCustodianID');
            })
            ->leftJoin('master_tbl_parameter_external_portfolio as pep', function ($join) {
                $join->on('pep.PortfolioID', '=', 'p.PortfolioID')->where('SystemID',47);
            })
            ->where('pc.CustodianCode', $custodian_code)
            ->where('p.PortfolioStatusID',2)
            ->orderBy('p.PortfolioCode')
            ->get();
        return $portfolio_nabs;
    }
    
    public function nabDataPims(){
        $data = \Models\pims\sec_tbl_portfolio::from('sec_tbl_portfolio as p')
            ->select('pc.CustodianCode', 'c.CompanyName', DB::raw('COUNT(p.PortfolioID) as TotalPortfolioID'))
            ->leftJoin('sec_tbl_parameter_custodian as pc', function ($join) {
                $join->on('pc.CompanyID', '=', 'p.PortfolioCustodianID');
            })
            ->leftJoin('sec_tbl_company as c', function ($join) {
                $join->on('c.CompanyID', '=', 'pc.CompanyID');
            })
            ->where('p.PortfolioStatusID',2)
            ->groupBy('pc.CustodianCode')->groupBy('c.CompanyName')->paginate(request()->max_row ?? 10);

        $with['data_pims'] = $data;
        $with['max_row'] = request()->max_row ?? 10;
        $with['template'] = 'template.nab.nabDataPims';
        return $with;
    }

    public function nabDataFile(){
        $with = $this->nabDataPims();
        $with['template'] = 'template.nab.nabDataFile';
        return $with;
    }

    public function nabGetFileTxt($date, $custodian_code)
    {
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));
        $month_text = date('F', strtotime($date));
        $day = date('d', strtotime($date));

        // $smb_op_root = Storage::disk('smb_op')->getConfig()['root'] ?? null;
        $smb_op_root = getPreferences('file_smb_op');
        $directory = getPreferences('nab_location_file').'/'.$year.'/'.$month_text.'/'.$day;

        $nab_files = json_decode(getPreferences('nab_files'));
        $filename = $nab_files->$custodian_code ?? null;
        // $filename = getPreferences('nab_file_'.$custodian_code);
        $filenames = is_array($filename)? $filename : [$filename];

        $texts = [];
        $filename_files = [];
        foreach($filenames as $filename){
            $arr_filename = array_filter(explode('#',$filename));
            $filename_detail = $arr_filename[1] ?? null;

            if($filename_detail != ''){
                $filename_detail = str_replace("yyyy",$year,$filename_detail);
                $filename_detail = str_replace("MM",$month,$filename_detail);
                $filename_detail = str_replace("dd",$day,$filename_detail);
                $filename = ($arr_filename[0] ?? $filename).$filename_detail;
            }

            $filename = $filename ?? '-';
            $path = $smb_op_root.'/'.$directory.'/'.$filename;
            
            $if_exists = Storage::disk('smb_op')->exists($directory.'/'.$filename);
            if($if_exists){
                $data = Storage::disk('smb_op')->get($directory.'/'.$filename);

                $text = nl2br($data);

                $text = str_replace("\r\n","",$text);
                $text = str_replace("\n","",$text);
                $texts = array_merge(array_filter(explode('<br />',$text)),$texts);
            }else{
                $filename_files[] = $filename;
            }
        }

        $with['texts'] = $texts;
        $with['filename'] = $filename;
        $with['filenames'] = $filename_files;
        return $with;
    }

    public function nabDataReturnFund(){
        $workflow_activity_id = request()->workflow_activity_id;
        $id = request()->id;

        $workflow_activity = \Models\workflow_activity::find($workflow_activity_id);
        $date = $workflow_activity->date ?? date('Y-m-d');
        $last_working_day = getLastWorkingDate($date);
            
        $datas = \Models\pims\mis_tbl_portfolio_return::from('mis_tbl_portfolio_return as r')
            ->select()
            ->leftJoin('sec_tbl_portfolio as p', function ($join) {
                $join->on('p.PortfolioID', '=', 'r.PortfolioID');
            })
            ->where('p.PortfolioStatusID',2)
            ->where('PositionDate',$last_working_day)
            ->orderBy('p.PortfolioName')
            ->paginate(request()->max_row ?? 10);

        $with['datas'] = $datas;
        $with['max_row'] = request()->max_row ?? 10;
        $with['template'] = 'template.nab.nabDataReturnFund';
        return $with;
    }

    public function nabDataReturnBenchmark(){
        $workflow_activity_id = request()->workflow_activity_id;
        $id = request()->id;

        $workflow_activity = \Models\workflow_activity::find($workflow_activity_id);
        $date = $workflow_activity->date ?? date('Y-m-d');
        $last_working_day = getLastWorkingDate($date);
            
        $datas = \Models\pims\mis_tbl_benchmark_portfolio::from('mis_tbl_benchmark_portfolio as b')
            ->select()
            ->leftJoin('sec_tbl_portfolio as p', function ($join) {
                $join->on('p.PortfolioID', '=', 'b.PortfolioID');
            })
            ->where('p.PortfolioStatusID',2)
            ->where('PositionDate',$last_working_day)
            ->orderBy('p.PortfolioName')
            ->paginate(request()->max_row ?? 10);

        $with['datas'] = $datas;
        $with['max_row'] = request()->max_row ?? 10;
        $with['template'] = 'template.nab.nabDataReturnBenchmark';
        return $with;
    }

    public function getQueryBreaching($last_working_day, $portfolioCode = [], $userEmail = []){
        $datas = \Models\pims\comp_tbl_breaching::from('comp_tbl_breaching as b')
            ->select(
                'p.PortfolioID', 'p.PortfolioCode', 'p.PortfolioName', 'p.PortfolioCcyID',
                'b.BreachingType', 'b.BreachingValue', 'b.BreachingMin', 'b.CompanyID',
                'b.BreachingMax', 'b.BreachingDate', 'b.BreachingDate2', 'b.DataID',
                'pn.NAB', 'pn.PositionDate', 'c.CompanyName', 'c.CompanyCode',
                'b.BreachingValue2', 'b.BreachingValue3', 'b.BreachingValue4', 'b.BreachingValue5', 'b.BreachingValue6',
                'b.BreachingValue7', 'b.BreachingValue8', 'b.BreachingValue9', 'b.BreachingValue10', 'b.BreachingDays', 'b.Remarks',
                'at.PortfolioAccountType'
            )
            // ->selectRaw("
            // CASE
            //     WHEN BreachingStatus = 1 and BreachingDate <= '".$last_working_day."' and BreachingDate2 > '".$last_working_day."'
            //         THEN 0
            //     ELSE BreachingStatus
            // END AS BreachingStatus")
            ->whereIn('BreachingType', array_keys(breachingType()))
            ->where(function($query) use($last_working_day){
                $query->where('BreachingStatus', 0)
                    ->where('BreachingDate2', '=', $last_working_day)
                    ->orWhere('BreachingStatus', 0)
                    ->where('BreachingDate', '=', $last_working_day)
                    ->whereNull('BreachingDate2')
                    ->orWhere('BreachingStatus', 1)
                    ->where('BreachingDate', '<', $last_working_day)
                    ->where('BreachingDate2', '=', $last_working_day);
                // $query->where('BreachingStatus', 0)
                //     ->orWhere('BreachingStatus', 1)
                //     ->where('BreachingDate2', '=', $last_working_day);
            })
            ->where(function($query) use($last_working_day){
                $query->whereColumn('BreachingDate', '!=', 'BreachingDate2')
                    // ->orWhere('BreachingDate', $last_working_day)
                    ->orWhereNull('BreachingDate2');
            })
            ->leftJoin('sec_tbl_portfolio as p', function ($join) {
                $join->on('p.PortfolioID', '=', 'b.PortfolioID');
            })
            ->leftJoin('sec_tbl_parameter_portfolio_accounttype as at', function ($join) use($last_working_day){
                $join->on('at.PortfolioAccountTypeID', '=', 'p.PortfolioAccountTypeID');
            })
            ->leftJoin('mis_tbl_portfolio_nab as pn', function ($join) use($last_working_day){
                $join->on('pn.PortfolioID', '=', 'p.PortfolioID')->whereDate('pn.PositionDate',$last_working_day);
            })
            ->leftJoin('sec_tbl_company as c', function ($join){
                $join->on('c.CompanyID', '=', 'b.CompanyID');
            });

        if(count($portfolioCode) > 0){
            $datas->whereIn('p.PortfolioCode', $portfolioCode);
        }
        if(count($userEmail) > 0){
            $datas->join('master_tbl_user_pm as pm', function ($join){
                $join->on('pm.PortfolioID', '=', 'b.PortfolioID');
            })
            ->join('master_tbl_user as u', function ($join){
                $join->on('u.UserID', '=', 'pm.UserID');
            })
            ->whereIn('u.UserEmail', $userEmail);
        }

        // select [p].[PortfolioID], [p].[PortfolioCode], [p].[PortfolioName], [p].[PortfolioCcyID],
        // [b].[BreachingType], [b].[BreachingValue], [b].[BreachingMin], [b].[CompanyID], [b].[BreachingMax], [b].[BreachingDate], [b].[BreachingDate2], [b].[DataID],
        // [pn].[NAB], [pn].[PositionDate], [c].[CompanyName], [c].[CompanyCode],
        // [b].[BreachingValue2], [b].[BreachingValue3], [b].[BreachingValue4], [b].[BreachingValue5], [b].[BreachingValue6], [b].[BreachingValue7], [b].[BreachingValue8],
        // [b].[BreachingValue9], [b].[BreachingValue10], [b].[BreachingDays], [b].[Remarks],
        // [at].[PortfolioAccountType] from [comp_tbl_breaching] as [b] left join [sec_tbl_portfolio] as [p] on [p].[PortfolioID] = [b].[PortfolioID]
        // left join [sec_tbl_parameter_portfolio_accounttype] as [at] on [at].[PortfolioAccountTypeID] = [p].[PortfolioAccountTypeID]
        // left join [mis_tbl_portfolio_nab] as [pn] on [pn].[PortfolioID] = [p].[PortfolioID] and cast([pn].[PositionDate] as date) = ?
        // left join [sec_tbl_company] as [c] on [c].[CompanyID] = [b].[CompanyID] where [BreachingType] in (?, ?, ?, ?, ?, ?, ?, ?) and
        // (
        //     [BreachingStatus] = ? and [BreachingDate2] = ? or
        //     [BreachingStatus] = ? and [BreachingDate] = ? and [BreachingDate2] is null or
        //     [BreachingStatus] = ? and [BreachingDate] < ? and [BreachingDate2] = ?
        // ) and (
        //     [BreachingDate] != [BreachingDate2] or [BreachingDate2] is null
        // )

        return $datas;
    }

    public function portfolioList($last_working_day, $portfolioCode, $userEmail){
        $datas = $this->getQueryBreaching($last_working_day, $portfolioCode, $userEmail)->orderBy('PortfolioCode')->pluck('PortfolioCode','PortfolioCode')->all();
        return $datas;
    }

    public function pmList(){
        $users_pm = \Models\pims\master_tbl_user_pm::from('master_tbl_user_pm as pm')
            ->select('u.UserEmail','u.UserName')
            ->groupBy('u.UserEmail')
            ->groupBy('u.UserName')
            ->leftJoin('master_tbl_user as u', function ($join){
                $join->on('u.UserID', '=', 'pm.UserID');
            })
            ->pluck('u.UserName','u.UserEmail')
            ->all();

        return $users_pm;
    }

    public function breachingReportCategory(){
        $workflow_activity_id = request()->workflow_activity_id;
        $id = request()->id;
        $portfolioCode = array_filter(request()->PortfolioCode ?? []);
        $userEmail = array_filter(request()->UserEmail ?? []);
        
        $employee = Auth::user()->employee ?? null;
        $email = $employee->email ?? null;
        $department_code = $employee->department_active->department->code ?? 'OPS';
        $position_code = $employee->position_active->job_position->code ?? 'EMP';

        // if(!request()->has('UserEmail') && $position_code == 'EMP' && $department_code != 'COMP'){
        if(!request()->has('UserEmail') && request()->access == 1){ // process owner
            $userEmail = [$email];
        }
        // }

        $workflow_activity_task = \Models\workflow_activity_task::with('workflow_task','workflow_task.workflow')
                ->where('workflow_activity_id',$workflow_activity_id)
                ->where('workflow_task_id',$id)
                ->first();
        $workflow_activity_task->status = 1;
        $workflow_activity_task->save();

        $date = request()->date ?? date('Y-m-d');
        $dates = getWeekendDate(date('Y-m-d',strtotime($date.'+6 months')));
        $last_working_day = getLastWorkingDate($date);

        $datas = $this->getQueryBreaching($last_working_day, $portfolioCode, $userEmail);

        $datas = $datas->whereNotNull('p.PortfolioCode')
            ->orderBy('BreachingStatus')
            // ->orderBy('at.PortfolioAccountTypeID')
            ->orderBy('b.BreachingDays', 'DESC')
            ->orderBy('p.PortfolioCode')
            ->get()->keyBy('DataID');

        $portfolios = $this->portfolioList($last_working_day, $portfolioCode, $userEmail);
        $users_pm = $this->pmList();

        $with['datas'] = $datas;
        $with['datas_cat1'] = $datas->whereIn('BreachingType',(categoryBreachingType()[1] ?? []));
        $with['datas_cat2'] = $datas->whereIn('BreachingType',(categoryBreachingType()[2] ?? []));
        $with['datas_cat3'] = $datas->whereIn('BreachingType',(categoryBreachingType()[3] ?? []));
        $with['datas_cat4'] = $datas->whereIn('BreachingType',(categoryBreachingType()[4] ?? []));
        $with['datas_cat5'] = $datas->whereIn('BreachingType',(categoryBreachingType()[5] ?? []));
        $with['dates'] = $dates;
        $with['template'] = 'breachingReportCategory';
        $with['title_head_export'] = ($workflow_activity_task->workflow_task->name ?? null).' report - '.date('Ymd',strtotime($last_working_day));
        $with['title_col_sum'] = 13;
        $with['paper_position'] = 'landscape';
        $with['date'] = $date;
        $with['last_working_day'] = $last_working_day;
        $with['workflow'] = $workflow_activity_task->workflow_task->workflow ?? null;
        $with['users_pm'] = $users_pm;
        $with['portfolios'] = $portfolios;
        $with['portfolioCode'] = $portfolioCode;
        $with['userEmail'] = $userEmail;
        return $with;
    }

    public function breachingReportPortfolio(){
        $workflow_activity_id = request()->workflow_activity_id;
        $id = request()->id;
        $portfolioCode = array_filter(request()->PortfolioCode ?? []);
        $userEmail = array_filter(request()->UserEmail ?? []);
        
        $employee = Auth::user()->employee ?? null;
        $email = $employee->email ?? null;
        $department_code = $employee->department_active->department->code ?? 'OPS';
        $position_code = $employee->position_active->job_position->code ?? 'EMP';
        
        // if(!request()->has('UserEmail') && $position_code == 'EMP' && $department_code != 'COMP'){
        if(!request()->has('UserEmail') && request()->access == 2){
            $userEmail = [$email];
        }
        // }

        $workflow_activity_task = \Models\workflow_activity_task::with('workflow_task','workflow_task.workflow')
                ->where('workflow_activity_id',$workflow_activity_id)
                ->where('workflow_task_id',$id)
                ->first();
        $workflow_activity_task->status = 1;
        $workflow_activity_task->save();

        $date = request()->date ?? date('Y-m-d');
        $last_working_day = getLastWorkingDate($date);

        $datas = $this->getQueryBreaching($last_working_day, $portfolioCode, $userEmail);

        $datas = $datas->orderBy('BreachingStatus')
            // ->whereDate('pn.PositionDate',$last_working_day)
            // ->orderBy('at.PortfolioAccountTypeID')
            ->orderBy('b.BreachingDays', 'DESC')
            ->orderBy('p.PortfolioCode')
            ->orderByRaw('CASE WHEN BreachingType in(1,2,3,6) THEN 1 WHEN BreachingType = 4 THEN 2 WHEN BreachingType = 7 THEN 3 WHEN BreachingType = 5 THEN 4 ELSE 5 END')
            ->get()->keyBy('DataID');

        $portfolios = $this->portfolioList($last_working_day, $portfolioCode, $userEmail);
        $users_pm = $this->pmList();

        $with['datas'] = $datas;
        $with['template'] = 'breachingReportPortfolio';
        $with['title_head_export'] = ($workflow_activity_task->workflow_task->name ?? null).' report - '.date('Ymd',strtotime($last_working_day));
        $with['title_col_sum'] = 12;
        $with['paper_position'] = 'landscape';
        $with['date'] = $date;
        $with['last_working_day'] = $last_working_day;
        $with['workflow'] = $workflow_activity_task->workflow_task->workflow ?? null;
        $with['users_pm'] = $users_pm;
        $with['portfolios'] = $portfolios;
        $with['portfolioCode'] = $portfolioCode;
        $with['userEmail'] = $userEmail;
        return $with;
    }

    public function getDataExcel($filenames, $directory, $excel_tabs = [1], $location = 'file/temp/', $disk = 'smb_data'){
        $locationLocal = 'app/public/'.$location.'/';
        $datas = [];
        foreach($filenames as $row){
            $if_exists = Storage::disk('smb_data')->exists($directory.'/'.$row->filename);
            $data = Storage::disk('smb_data')->get($directory.'/'.$row->filename);

            if($if_exists){;
                $filename = $row->filename;
                if (!Storage::disk('public')->exists($location)) {
                    Storage::disk('public')->makeDirectory($location);
                }
    
                $localPath = storage_path($locationLocal.'/'.$filename); // Temporary path to store the Excel file
                file_put_contents($localPath, $data);
    
                $excel = Excel::toArray(new generalImport(), storage_path($locationLocal.'/'.$filename));
                foreach($excel_tabs as $excel_tab){
                    $excel_tab = $excel_tab-1;
                    $datas = array_key_exists($excel_tab,$excel)? array_merge($datas, array_slice($excel[$excel_tab], 1, count($excel[$excel_tab]))) : $datas;
                }
            }
        }
        return $datas;
    }
    
    public function emailSent(){
        $date = request()->date;
        $access = request()->access ?? 0;
        $model_email_sent = new \Models\email_sent();
        
        $workflow_activity_id = request()->workflow_activity_id;
        $id = request()->id;

        $workflow_task = \Models\workflow_task::find($id);
        $date_days = $workflow_task->date_days ?? null;
        $root_location_file = $workflow_task->root_location_file ?? null;
        $filenames = json_decode($workflow_task->location_filename ?? null);
        $excel_tabs = json_decode($workflow_task->excel_tabs ?? "[1]");
        
        $last_working_day = getLastWorkingDate($date, $date_days ?? '-1');
        $year = date('Y', strtotime($last_working_day));
        $month = date('m', strtotime($last_working_day));
        $day = date('d', strtotime($last_working_day));

        $directory = $root_location_file.'/'.$year.'/'.$month.'/'.$day;

        $datas = $this->getDataExcel($filenames, $directory , $excel_tabs);

        $email_sents_status = \Models\email_sent::select('status',DB::raw("CONCAT(bank_custodian,'#',portfolio_code,'#',client_name) AS keyName"))
            ->where('workflow_task_id',$id)
            ->where('date',$last_working_day)->get()->pluck('status','keyName');
        
        foreach($datas as $key => $rows){
            $system_portfolio_code = $rows[7] ?? null; //reksa_dana
            $portfolio_code = ($rows[10] ?? null) != ''? ($rows[10] ?? null) : substr($system_portfolio_code, strrpos($system_portfolio_code, '_') + 1);

            if((($rows[0] ?? null) != '') && ($portfolio_code != '') && (($rows[11] ?? null) != '')){
                $status = $email_sents_status[($rows[0] ?? null).'#'.$portfolio_code.'#'.($rows[11] ?? null)] ?? null;

                $status_excel = $rows[9] == 1? 1 : 0;
    
                $datas[$key] = [
                    'workflow_task_id' => $id,
                    'bank_custodian' => $rows[0] ?? null,
                    'portfolio_code' => $portfolio_code,
                    'client_name' => $rows[11] ?? null,
                    'subject' => $rows[1],
                    'description' => $rows[3],
                    'to' => $rows[4],
                    'cc' => $rows[5],
                    'bcc' => $rows[6],
                    'system_portfolio_code' => $system_portfolio_code,
                    'date' => $last_working_day,
                    'status' => $status_excel == 1? $status_excel : ($status ?? $status_excel),
                    'deleted_at' => null
                    // 'process_owner' => null,
                    // 'approver' => null,
                    // 'note_email' => null,
                ];
            }else{
                unset($datas[$key]);
            }
        }

        $model_email_sent->upsert($datas, uniqueBy: ['workflow_task_id', 'bank_custodian', 'portfolio_code', 'client_name', 'date'], update: ['status', 'deleted_at']);

        $datas = \Models\email_sent::select('*')
            ->where('workflow_task_id',$id)
            ->where('date',$last_working_day);
        if($access == 1){
            $datas->orderBy(DB::raw('FIELD(email_sent.status, 2, 0, 3, 4, 1)'));
        }elseif($access == 2){
            $datas->orderBy(DB::raw('FIELD(email_sent.status, 3, 2, 0, 4, 1)'));
        }
        $datas = $datas->orderBy('portfolio_code')->paginate(request()->max_row ?? 10);

        // $datas = collect($datas)
        //     ->sortBy('status')->all();

        // $datas = $this->globalTools->paginate($datas, request()->max_row ?? 10, ['path' => request()->url(), 'query' => request()->query()]);

        $with['last_working_day'] = $last_working_day;
        $with['datas'] = $datas;
        $with['max_row'] = request()->max_row ?? 10;
        $with['template'] = 'template.emailSent.emailSentList';
        return $with;
    }
}