<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Mail\ProblemSolvedMail;
use App\Mail\SendMailable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SendGrid\Mail\Mail;
use Session;
use App\Models\User;
use App\Models\Restaurant;

class ReviewsController extends Controller
{
    CONST default_index = 'review';
    CONST required_method = [
        'edit',
        'update',
        'destroy',
        'show',
    ];
    CONST model = Review::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$slug)
    {
        $statuses = Review::REVIEW_STATUS;
        $this->restaurant = Session::get('res');
        // breadrums on head page
        $breadcrumbs = [
            'title' => __('admin.reviews.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'. $slug .'/reviews'),
                    'text' => __('admin.reviews.breadcrumbs.reviews_index')
                ]
            ]
        ];
        session(['mainPage' => $request->fullUrl()]);

        // get search params
//        $keyword = $request->get('q');
        $status = $request->get('status');
        $date_search = $request->get('date_from_to');
        $today = new \DateTime('now');
        $from = $today->format('Y-m-d');
        $to = $today->format('Y-m-d');
        if(!empty($date_search)) {
            $list_date = explode(' - ',$date_search);
            $from = $list_date[0] . ' 00:00:00';
            $to = $list_date[1] . ' 23:59:59';
        }

        $lang = Session::get('locale');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $reviews = Review::select('reviews.*' )->orderBy('reviews.status', 'asc')->orderBy('reviews.id', 'desc');

        $reviews = $reviews->whereBetween('created_at',[$from,$to]);

        // filter with search params
        if($status != ""){
            $reviews = $reviews->where('reviews.status', '=', $status);
        }


        $restaurantId = $this->restaurant->id;
        $reviews = $reviews->where(function ($query) use ($restaurantId) {
            $query->orWhere("reviews.restaurant_id", '=',$restaurantId);
        });

        $reviews = $reviews->paginate($perPage);
        return view ('admin.reviews.index',compact('reviews', 'status',  'breadcrumbs', 'lang','statuses','from','to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug,$id)
    {
        $breadcrumbs = [
            'title' => __('admin.reviews.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/'.$slug.'/reviews'),
                    'text' => __('admin.reviews.breadcrumbs.reviews_index')
                ],
                [
                    'href' => url('admin/'.$slug.'/reviews/' . $id),
                    'text' => __('admin.reviews.breadcrumbs.show_review')
                ]
            ]
        ];

        $review = Review::findOrFail($id);

        if($review->status == 0) {
            $review->update(array('status' => 1));
        }

        return view('admin.reviews.show',compact('review', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function changeStatus($slug,Request $request) {
        $data = $request->all();
        try{
            $review = Review::findOrFail($data['review_id']);
            $review->status = $data['status'];
            if($data['status'] == 2) {
                $review->published = true;
            }
            $review->save();
        }catch(\Exception $exception){
            \Illuminate\Support\Facades\Log::error($exception->getMessage());
        }

        Session::flash('flash_message', trans('admin.reviews.flash_messages.update'));
        return response()->json([
           'is_success' => true
        ]);
    }

    public function solveSendMail($slug,Request $request)
    {
        $mailSubject = $request ->input('mailSubject');
        $mailContent = $request ->input('mailContent');
        $otherMail = $request->get('otherMail');
        $this->sendMail($otherMail,$mailSubject,$mailContent);
        //
        $review = Review::findOrFail($request->get('review_id'));
        $review->status = 3; // solved
        $review->save();

        Session::flash('flash_message', trans('admin.reviews.flash_messages.update'));
        return response()->json(['is_success'=>true,'message' => trans('admin.reviews.statuses.success')]);
    }

    private function sendMail($email,$subject,$message)
    {
        return \Mail::to($email)->send(new SendMailable([
            'email' => env('MAIL_FROM_ADDRESS'),
            'name' => env('MAIL_FROM_NAME'),
            'subject' => $subject,
            'message' => $message,
            'view_path' => 'emails.review_solve'
        ]));
    }

    public function confirmReview($slug, $id)
    {
        $review = Review::findOrFail($id);
        if(empty($review)==0){
            Session::flash('flash_error', "This review is not exist!");
            return redirect("/");
        }
        if($review->status<2){
            $review->published = true;
            $review->status = 2;
            $review->save();
            Session::flash('flash_message', "Review is publish now!");            
        }else{
            Session::flash('flash_error', "Cannot Confirmed this review. Please contact administrator!");
        }
        return redirect("/");
    }

    public function sendProblemSolved($slug, $id)
    {
        $review = Review::findOrFail($id);
        $review->published = false;
        $review->save();
        //TODO: Write send email
        Session::flash('flash_message', "An email problem solved will be send to customer."); 
        
        return redirect()->back();
    }

    public function approvedProblemSolved($id)
    {
        $review = Review::findOrFail($id);
        if(empty($review)){
            Session::flash('flash_error', "Review not exist");
            return redirect('/');
        }
        if($review->status == 3){
            Session::flash('flash_error', "This review has been solved, no action required");
            return redirect('/');
        }
        $review->published = false;
        $review->status = 3;
        $review->save();
        Session::flash('flash_message', "Thank for your confirmed and have a NiceMeal"); 
        
        return redirect("/");
    }

    public function sendProblemSolveMail($slug,$id){
        $review = Review::findOrFail($id);
        $review->published = false;
        $userEmail = User::where('id',$review->customer_id)->first()->email;
        if (empty($userEmail)){
            Session::flash('flash_error', "User email is not exist");
            return redirect()->back();
        }
        $resData = Session::get('res');
        $review->save();

        \Mail::to($userEmail)->send(new ProblemSolvedMail($resData,$review));
        Session::flash('flash_message', "An email problem solved will be send to customer.");

        return redirect()->back();
    }
   

}
