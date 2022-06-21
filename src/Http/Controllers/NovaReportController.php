<?php

namespace Joy2362\UserReport\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Seller;
use App\Models\SiteReport;
use App\Notifications\sendEmailUser;
use Illuminate\Http\Request;

class NovaReportController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $profile = SiteReport::where('type',SiteReport::PROFILE)->where('status','pending')->count();
        $job = SiteReport::where('type',SiteReport::JOB)->where('status','pending')->count();
        $bid = SiteReport::where('type',SiteReport::BID)->where('status','pending')->count();
        $message = SiteReport::where('type',SiteReport::MESSAGE)->where('status','pending')->count();
        $package = SiteReport::where('type',SiteReport::PACKAGE)->where('status','pending')->count();
        return response()->json([
            'profile' => $profile,
            'job' => $job,
            'bid' => $bid,
            'message' => $message,
            'package' => $package,
        ]);
    }

    public function report(Request $request): \Illuminate\Http\JsonResponse
    {
        $type = $request->type ? $request->type : "profile";
        $perPage = $request->perPage ? $request->perPage : 10;
        $report = SiteReport::where('type',$type)->orderBy('id',"DESC")->paginate($perPage);
        return response()->json(
            $report
        );
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $report = SiteReport::where('id',$id)->delete();

        return response()->json( $report);
    }

    public function destroyAll(Request $request): \Illuminate\Http\JsonResponse
    {
        foreach ( $request->resource as $row){
            SiteReport::destroy($row["id"]);
        }
        return response()->json("success");
    }

    public function ChangeStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        if($request->requestType === "single"){
            if($request->status == "investigate"){
                SiteReport::where('id',$request->resource["id"])->where('status',"pending")->update([
                    'status' => $request->status,
                ]);
            }
            if($request->status == "solved"){
                SiteReport::where('id',$request->resource["id"])->where('status',"investigate")->update([
                    'status' => $request->status,
                ]);
            }
        }else{
            foreach ( $request->resource as $row){
                if($request->status == "investigate"){
                    SiteReport::where('id',$row["id"])->where('status',"pending")->update([
                        'status' => $request->status,
                    ]);
                }
                if($request->status == "solved"){
                    SiteReport::where('id',$row["id"])->where('status',"investigate")->update([
                        'status' => $request->status,
                    ]);
                }
            }
        }

        return response()->json("success");
    }

    private function selectAuthor($user){
        if ( $user["authorableType"] == Buyer::class){
            return Buyer::find( $user["authorableId"]);
        }else{
            return Seller::find( $user["authorableId"]);
        }
    }

    private function selectAgainst($user){
        if ( $user["againestableType"] == Buyer::class){
            return Buyer::find( $user["againestableId"]);
        }else{
            return Seller::find($user["againestableId"]);
        }
    }

    private function selectUser($type,$user){
        if($type == "author"){
            $user =  $this->selectAuthor($user);
        }
        if($type == "against"){
            $user = $this->selectAgainst($user);
        }
        return $user;
    }

    public function emailSend(Request $request): \Illuminate\Http\JsonResponse
    {

        if($request->requestType === "single"){
            $user  = $this->selectUser($request->receiver,$request->resource);
            $user->notify(new sendEmailUser($request->subject,$request->body,null));
        }else{
            foreach ( $request->resource as $row){
                $user  = $this->selectUser($request->receiver,$row);
                $user->notify(new sendEmailUser($request->subject,$request->body,null));
            }
        }

        return response()->json("success");
    }

    public function view($id): \Illuminate\Http\JsonResponse
    {
        $report = SiteReport::find($id);
        return response()->json(
            $report
        );
    }
}
