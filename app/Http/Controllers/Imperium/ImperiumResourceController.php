<?php

namespace App\Http\Controllers\Imperium;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImperiumResourceController extends Controller
{
    public function getDependencyValues($module_name, $dependable_field_name, Request $request)
    {
        try {
            $resource = getResource($module_name);

            $form = $resource->form();

            if (count($form->fields ?? []) > 0) {
                $form_field_names = collect($form->fields)->map(function ($field) {
                    return $field->field;
                })->toArray();
                if (in_array($dependable_field_name, $form_field_names)) {
                } else {
                    return response()->json(['error' => $module_name . ' resource class does not have any dependable fields ' . $dependable_field], 400);
                }
            } else {
                return response()->json(['error' => $module_name . ' resource class does not have any form fields'], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => 'No resource class found for ' . $module_name], 404);
        }
    }
}
