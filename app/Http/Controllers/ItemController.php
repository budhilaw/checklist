<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Checklist;
use App\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function complete(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',
        ]);

        $item = Item::where('id', $request->item_id)->first();
        $item->is_completed = 1;
        $item->save();

        return response()->json([
            'status' => 'The item is completed!'
        ], 200);
    }

    public function incomplete(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',
        ]);

        $item = Item::where('id', $request->item_id)->first();
        $item->is_completed = 0;
        $item->save();

        return response()->json([
            'status' => 'The item is incompleted!'
        ], 200);
    }

    public function getByChecklist(Request $request, $checklistid)
    {
        $checklists = Checklist::where('object_id', $checklistid)->get();

        foreach( $checklists as $key => $checklist ) {
            $item = Item::where('checklist_id', $checklist->object_id)->get();
            if ( !$item->count() > 0 ) {
                $data = 'No item on this checklist';
                return response()->json(compact('data'), 404);
            }
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
                'items' => $item,
                'links' => array(
                    'self' => $request->url()
                )
            ];
        }

        return response()->json(compact('data'), 200);
    }

    public function getByItemId(Request $request, $checklistid, $itemid)
    {
        $checklists = Checklist::where('object_id', $checklistid)->get();

        foreach( $checklists as $key => $checklist ) {
            $item = Item::where('checklist_id', $checklist->object_id)
                            ->where('id', $itemid)
                            ->get();
            if ( !$item->count() > 0 ) {
                $data = 'No item on this checklist';
                return response()->json(compact('data'), 404);
            }
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
                'items' => $item,
                'links' => array(
                    'self' => $request->url()
                )
            ];
        }

        return response()->json(compact('data'), 200);
    }

    public function editByItemId(Request $request, $checklistid, $itemid)
    {
        $checklist = Checklist::where('object_id', $checklistid)->first();

        $item = Item::where('checklist_id', $checklist->object_id)
                    ->where('id', $itemid)
                    ->first();

        if ( $item == null ) {
            $data = 'No item on this checklist';
            return response()->json(compact('data'), 404);
        }

        if ( !$item->count() > 0 ) {
            $data = 'No item on this checklist';
            return response()->json(compact('data'), 404);
        }

        $data = $item;

        if ( $request->has('name') ) {
            $data->name = $request->input('name');
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
            'status' => 'The item data from checklist successfuly edited!'
        ], 200);
    }

    public function deleteByItemId(Request $request, $checklistid, $itemid)
    {
        $checklist = Checklist::where('object_id', $checklistid)->first();

        $item = Item::where('checklist_id', $checklist->object_id)
                    ->where('id', $itemid)
                    ->first();

        if ( $item == null ) {
            $data = 'No item on this checklist';
            return response()->json(compact('data'), 404);
        }

        if ( !$item->count() > 0 ) {
            $data = 'No item on this checklist';
            return response()->json(compact('data'), 404);
        }

        $data = $item;
        $data->delete();

        return response()->json([
            'status' => 'The item from checklist data successfuly deleted!'
        ], 200);
    }

    public function getAll(Request $request)
    {
        $checklists = Checklist::all();

        foreach( $checklists as $key => $checklist ) {
            $item = Item::where('checklist_id', $checklist->object_id)->get();

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
                'items' => $item,
                'links' => array(
                    'self' => $request->url()
                )
            ];
        }

        return response()->json(compact('data'), 200);
    }

    public function create(Request $request, $checklistid)
    {
        $data = new Item();
        $data->checklist_id = $checklistid;

        if ( $request->has('name') ) {
            $data->name = $request->input('name');
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
            'status' => 'The item data successfuly added!'
        ], 200);
    }
}
