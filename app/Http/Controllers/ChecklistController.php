<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Checklist;

class ChecklistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAll(Request $request)
    {
        $checklists = Checklist::all();

        foreach( $checklists as $key => $checklist ) {
            $data[$key] = (object) [
                'type' => 'checklist',
                'id' => $checklist->object_id,
                'attributes' => array(
                    'object_domain' => $checklist->object_domain,
                    'object_id' => $checklist->object_id,
                    'description' => $checklist->description,
                    'is_completed' => $checklist->is_completed,
                    'due' => $checklist->due,
                    'urgency' => $checklist->urgency,
                    'completed_at' => $checklist->completed_at,
                    'last_update_by' => $checklist->last_update_by,
                ),
                'links' => array(
                    'self' => $request->url()
                )
            ];
        }

        return response()->json(compact('data'), 200);
    }

    public function show(Request $request, $id)
    {
        $data = Checklist::where('object_id', $id)->first();
        if( !$data )
        {
            return response()->json([
                'status' => 'Checklist not found!'
            ], 404);
        }
        return response()->json([
            'type' => 'checklist',
            'id' => $id,
            'attributes' => $data,
            'links' => array(
                'self' => $request->url()
            )
        ], 200);
    }

    public function edit(Request $request, $id)
    {
        $data = Checklist::where('object_id', $id)->first();

        if ( $request->has('object_domain') ) {
            $data->object_domain = $request->input('object_domain');
        }

        if ( $request->has('urgency') ) {
            $data->urgency = $request->input('urgency');
        }

        if ( $request->has('description') ) {
            $data->description = $request->input('description');
        }

        if ( $request->has('is_completed') ) {
            $data->is_completed = $request->input('is_completed');
        }

        if ( $request->has('completed_at') ) {
            $data->completed_at = $request->input('completed_at');
        }
        $data->save();

        return response()->json([
            'status' => 'The checklist data successfuly edited!'
        ], 200);
    }

    public function delete($id)
    {
        $data = Checklist::find($id);
        $data->delete();

        return response()->json([
            'status' => 'The checklist data successfuly deleted!'
        ], 200);
    }

    public function create(Request $request)
    {
        $data = new Checklist();
        if ( $request->has('object_domain') ) {
            $data->object_domain = $request->input('object_domain');
        }

        if ( $request->has('description') ) {
            $data->description = $request->input('description');
        }

        if ( $request->has('urgency') ) {
            $data->urgency = $request->input('urgency');
        }

        if ( $request->has('is_completed') ) {
            $data->is_completed = $request->input('is_completed');
        }

        if ( $request->has('due') ) {
            $data->due = $request->input('due');
        }

        if ( $request->has('completed_at') ) {
            $data->completed_at = $request->input('completed_at');
        }

        if ( $request->has('last_update_by') ) {
            $data->last_update_by = $request->input('last_update_by');
        }
        $data->save();

        return response()->json([
            'status' => 'The checklist data successfuly added!'
        ], 200);
    }
}
