<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEmailAPIRequest;
use App\Http\Requests\API\UpdateEmailAPIRequest;
use App\Models\Email;
use App\Repositories\EmailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;

/**
 * Class EmailController
 * @package App\Http\Controllers\API
 */

class EmailAPIController extends AppBaseController
{
    /** @var  EmailRepository */
    private $emailRepository;

    public function __construct(EmailRepository $emailRepo)
    {
        $this->emailRepository = $emailRepo;
    }

    /**
     * Display a listing of the Email.
     * GET|HEAD /Emails
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->emailRepository->pushCriteria(new RequestCriteria($request));
        $this->emailRepository->pushCriteria(new LimitOffsetCriteria($request));
        $emails = $this->emailRepository->all();

        return Response::json($emails);
//        return $this->sendResponse($emails->toArray(), 'Emails retrieved successfully');
    }

    /**
     * Store a newly created Email in storage.
     * POST /Emails
     *
     * @param CreateEmailAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateEmailAPIRequest $request)
    {
        $input = $request->all();

        $emails = $this->EmailRepository->create($input);

        return $this->sendResponse($emails->toArray(), 'Email saved successfully');
    }

    /**
     * Display the specified Email.
     * GET|HEAD /Emails/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Email $Email */
        $email = $this->emailRepository->findWithoutFail($id);

        if (empty($Email)) {
            return $this->sendError('Email not found');
        }

        return $this->sendResponse($email->toArray(), 'Email retrieved successfully');
    }

    /**
     * Update the specified Email in storage.
     * PUT/PATCH /Emails/{id}
     *
     * @param  int $id
     * @param UpdateEmailAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmailAPIRequest $request)
    {
        $input = $request->all();

        /** @var Email $Email */
        $email = $this->emailRepository->findWithoutFail($id);

        if (empty($Email)) {
            return $this->sendError('Email not found');
        }

        $Email = $this->emailRepository->update($input, $id);

        return $this->sendResponse($Email->toArray(), 'Email updated successfully');
    }

    /**
     * Remove the specified Email from storage.
     * DELETE /Emails/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Email $Email */
        $email = $this->emailRepository->findWithoutFail($id);

        if (empty($email)) {
            return $this->sendError('Email not found');
        }

        $Email->delete();

        return $this->sendResponse($id, 'Email deleted successfully');
    }

    public function extra($filter, $limit)
    {
        $result = DB::connection('mysql2')->table('email');
        $sub_query = DB::connection('mysql2')->table('email')
                                             ->select(['email.emailID'])
                                             ->join('cargo_offer_extracted','email.emailID' ,'=', 'cargo_offer_extracted.emailID')
                                             ->groupBy('email.emailID')
                                             ->get();
        
        if ($filter == "classification") {
            $result->select(['emailID', 'classification_manual', 'classification_automated', 'classification_automated_certainty' ])
            ->where( 'classification_automated',  'Unknown')
            ->limit ($limit);
        }
        if ($filter == "unclassified") {
            $result->select(['emailID', 'subject', 'body', 'sender','receiver','cc', 'date', 'classification_manual', 'classification_automated', 'classification_automated_certainty']) 
            ->where( 'classification_automated', 'Unknown') 
            ->orWhere( 'classification_automated')
            ->limit($limit);
        }
        if ($filter == "classificationtraining") {
            $result->select(['emailID', 'subject', 'body', 'sender', 'receiver', 'cc', 'date', 'classification_manual', 'classification_automated', 'classification_automated_certainty'])
            ->where('classification_manual' ,'!=',null)
            ->limit($limit);
        }
        if ($filter == "classificationconfidence") {
            $result->select(['emailID', 'subject', 'body', 'sender', 'receiver', 'cc', 'date', 'classification_manual', 'classification_automated', 'classification_automated_certainty'])
            ->where( 'classification_automated_certainty' ,'!=',null)
            ->orderBy( 'classification_automated_certainty','asc')
            ->limit($limit);;
        }
        if (in_array(strtolower($filter), array("ship", "cargo", "mix", "report", "spam", "unknown", "spam", "order"))) {
            $result->select(['emailID', 'subject', 'body', 'sender', 'receiver', 'cc', 'date', 'classification_manual', 'classification_automated', 'classification_automated_certainty'])
            ->where ('classification_manual', ucfirst(strtolower($filter)))
            -> limit($limit);
        }
        //3 Filters used by the 3 extraction scripts respectively to get unextracted emaisl. 
        if ($filter == "unextracted-cargo") { 
            $result->whereNotIn('emailID',$sub_query) 
                ->where('classification_automated','Cargo') 
                ->orderBy ('_created_on', 'desc')
                ->limit($limit);
        }
        if ($filter == "unextracted-ship") {
            $result->whereNotIn('emailID',$sub_query) 
                ->where('classification_automated','Ship') 
                ->orderBy ('_created_on', 'desc')
                ->limit($limit);
        }
        if ($filter == "unextracted-order") {
            $result->whereNotIn('emailID',$sub_query) 
                ->where('classification_automated','Order') 
                ->orderBy ('_created_on', 'desc')
                ->limit($limit);
        }


        //emails/cargoforcleaning/{limit}
        if ($filter == "cargoforcleaning") {
            $result->join('cargo_offer_extracted','email.emailID' ,'=', 'cargo_offer_extracted.emailID') 
                ->select(['cargo_offer_extracted.*', 'email.date'])
                ->limit($limit);
        }
        //Filter that allows getting emails of a particular class. Not in use.
        if (in_array(strtolower($filter), array("ship", "cargo", "mix", "report", "spam", "unknown", "spam", "order"))) 
        {

            $result->select(['emailID', 'subject', 'body', 'sender', 'receiver', 
                'cc', 'date', 'classification_manual', 'classification_automated', 
                'classification_automated_certainty'])
                ->where( 'classification_manual',ucfirst(strtolower($filter)))
                ->limit($limit);
        }
        return Response::json($result->get());
    }

}
